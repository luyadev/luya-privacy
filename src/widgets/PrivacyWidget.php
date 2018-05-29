<?php
namespace luya\privacy\widgets;

use Yii;
use yii\web\Cookie;
use luya\base\Widget;
use luya\cms\helpers\Url;
use luya\helpers\ArrayHelper;
use luya\helpers\Json;
use luya\helpers\Html;

use luya\privacy\Module;
use luya\privacy\assets\PrivacyWidgetAsset;
use luya\privacy\traits\PrivacyTrait;

/**
 * Privacy Widget
 *
 * This widget will show a privacy notification. It includes a privacy cookie message, which can be accepted or declined.
 * The cookie message will disappear after the user has taken a choice and if forceOutput is false. Otherwise it will show up.
 * All settings can be passed as an array to the widget.
 *
 * Attention: The widget's functionality can be broken if it is not correctly used! It has to be taken in account that
 * the trackers or other cookies need to be set through either the \luya\privacy\assets\PrivacyAsset's $jsOnPrivacyAccepted
 * or having been checked through \luya\privacy\traits\PrivacyTrait's `isPrivacyAccepted()` method.
 *
 * Usage:
 * ```php
 * PrivacyWidget::widget([
 *      'message' => [
 *          'message' => 'We use cookies on our site. Please read and accept our privacy agreement',
 *          'tag' => 'a',
 *          'class' => 'message',
 *          'href' => '/privacy'
 *      ],
 *      'acceptButton' => [
 *          'message' => 'I accept',,
 *          'tag' => 'button',
 *          'value' => true,
 *          'class' => 'btn btn-primary',
 *      ],
 *      'declineButtonText' => [
 *          'message' =>  'I decline',
 *          'tag' => 'button',
 *          'value' => false,
 *          'class' => 'btn',
 *      ],
 *      'forceOutput' => false
 * );
 * ```
 *
 * @author Alex Schmid <alex.schmid@stud.unibas.ch>
 * @since 1.0.0
 *
 * @todo Position -> fixed / relative
 */
class PrivacyWidget extends Widget
{
    use PrivacyTrait;

    /**
     * @var null|array If set, a wrapper will be wrapped around the message
     * - tag: The tag for the wrapper, e.g. `a`
     * - class: Class or classes for the wrapper
     * - href: The place where it should link to
     */
    public $messageWrapperOptions;

    /**
     * @var string The cookie message which will be shown to the user
     * If not set it will use a default message in English:
     * `We use cookies to improve your experience on our website. Please read and accept our privacy policies.`
     */
    public $message = [
        'tag' => 'a',
        'class' => 'message',
        'href' => '/privacy'
    ];

    /**
     * @var null|array If set, a wrapper will be wrapped around the message
     * - tag: The tag for the wrapper, e.g. `div`
     * - class: Class or classes for the wrapper
     *
     * Attention: Functionality can be broken!
     */
    public $buttonsWrapperOptions = [
        'tag' => 'div',
        'class' => 'buttons'
    ];

    /**
     * @var null|array If set, a wrapper will be wrapped around the message
     * - tag: The tag for the wrapper, e.g. `a`
     * - class: Class or classes for the wrapper
     *
     * Attention: Functionality can be broken!
     */
    public $acceptButton = [
        'tag' => 'button',
        'value' => "true",
        'class' => 'btn btn-primary',
        'type' => 'submit'
    ];

    /**
     * @var null|array If set, a wrapper will be wrapped around the message
     * - tag: The tag for the wrapper, e.g. `a`
     * - class: Class or classes for the wrapper
     *
     * Attention: Functionality can be broken!
     */
    public $declineButton= [
        'tag' => 'button',
        'value' => "false",
        'class' => 'btn',
        'type' => 'submit'
    ];

    /**
     * @var bool Whether the output should be forced.
     * If set to true, the widget will output even if the cookie is already set.
     */
    public $forceOutput = false;

    /**
     * @var string CSS to be applied
     * Custom CSS can be used to style the
     */
    public $css = '.privacyPolicyConsent {
                        position: fixed;
                        width: 100%;
                        left: 0;
                        bottom: 0;
                        background-color: #A50045;
                        color: #fff;
                        z-index: 10000;
                        display: flex;
                        padding: 1em;
                        align-items: center;
                        justify-content: space-between;
                    }
                    .privacyPolicyConsent.top {
                        top: 0;
                        bottom: unset;
                    }
                    .privacyPolicyConsent a {
                        color: #fff;
                    }';

    /**
     * @param $config The configuration (E.g. the button config).
     * @param $defaultTag The html tag which is used as default if there is nothing set.
     * @param $defaultMessage The message which is set if there is nothing set.
     * @return string
     */
    protected function buildTag($config, $defaultTag, $defaultMessage)
    {
        if ($config === false)
            return '';
        $tag = ArrayHelper::remove($config, 'tag', $defaultTag);
        $message = ArrayHelper::remove($config, 'message', $defaultMessage);
        return Html::tag($tag, $message, $config);
    }

    /**
     * Set the name value for buttons for post. Defaults to the privacy cookie name.
     *
     * Attention: Functionality can be broken!
     */
    private function setNames()
    {
        if (!empty($this->acceptButton)) $this->acceptButton['name'] = self::$PRIVACY_COOKIE_NAME;
        if (!empty($this->declineButton)) $this->declineButton['name'] = self::$PRIVACY_COOKIE_NAME;
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->setNames();
        $privacyPolicy = Yii::$app->request->post(self::$PRIVACY_COOKIE_NAME, null);
        if (!empty($privacyPolicy)) {
            if ($privacyPolicy === 'true') {
                $this->setPrivacyCookieValue(true);
            } elseif ($privacyPolicy === 'false') {
                $this->setPrivacyCookieValue(false);
            }
        }
    }

    /**
     * @inheritdoc
     *
     * If privacy policies are whether accepted nor declined, or forcing output is set, it will show up the widget.
     * The widget gives the user the ability to chose the cookie settings.
     */
    public function run()
    {
        if ((!$this->isPrivacyAccepted() && !$this->isPrivacyDeclined()) || $this->forceOutput) {
            if ($this->css) {
                $this->getView()->registerCss($this->css);
            }
            $html = $this->buildTag($this->message, 'a', Module::t('privacy_widget.privacy_message'));
            $buttons = $this->buildTag($this->acceptButton, 'button', Module::t('privacy_widget.accept_privacy_button_text'));
            $buttons .= $this->buildTag($this->declineButton, 'button', Module::t('privacy_widget.decline_privacy_button_text'));

            if (!empty($this->buttonsWrapperOptions)) {
                $wrapperTag = ArrayHelper::remove($this->buttonsWrapperOptions, 'tag', 'div');
                $buttons = Html::tag($wrapperTag, $buttons, $this->buttonsWrapperOptions);
            }

            $html = Html::tag('form', $html . $buttons,
                ['action' => ' ', 'method' => 'post', 'class' => 'privacyPolicyConsent', 'id' => self::$PRIVACY_COOKIE_NAME]);
            return $html;
        }
    }
}
