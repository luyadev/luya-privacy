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
 * This widget will show a privacy notification. It includes a privacy (cookie) message, which can be accepted.
 *
 * Usage:
 * ```php
 * PrivacyWidget::widget([
 *      'message' => 'We use cookies on our site. Please read and accept our privacy agreement',
 *      'messageWrapperOptions' => [
 *          'tag' => 'a',
 *          'class' => 'message',
 *          'href' => '/privacy'
 *      ],
 *      'acceptButtonText' => 'I accept',
 *      'acceptButtonOptions' => [
 *          'tag' => 'button',
 *          'value' => true,
 *          'class' => 'btn btn-primary',
 *      ],
 *      'declineButton' => true,
 *      'declineButtonText' => 'I decline',
 *      'declineButtonOptions => [
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
    public $message;

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
     * @var string Text on the accept button
     */
    public $acceptButtonText;

    /**
     * @var null|array If set, a wrapper will be wrapped around the message
     * - tag: The tag for the wrapper, e.g. `a`
     * - class: Class or classes for the wrapper
     */
    public $acceptButtonOptions = [
        'tag' => 'button',
        'value' => "true",
        'class' => 'btn btn-primary',
        'type' => 'submit'
    ];

    /**
     * @var string Text on the decline button
     */
    public $declineButtonText;

    /**
     * @var null|array If set, a wrapper will be wrapped around the message
     * - tag: The tag for the wrapper, e.g. `a`
     * - class: Class or classes for the wrapper
     *
     * Attention: Functionality can be broken!
     */
    public $declineButtonOptions = [
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
     * Translate messages if no widget input
     */
    private function setMessages()
    {
        if (empty($this->message)) {
            $this->message = Module::t('privacy_widget.privacy_message');
        }
        if (empty($this->acceptButtonText)) {
            $this->acceptButtonText = Module::t('privacy_widget.accept_privacy_button_text');
        }
        if (empty($this->declineButtonText)) {
            $this->declineButtonText = Module::t('privacy_widget.decline_privacy_button_text');
        }
    }

    /**
     * Set the name value for buttons for post. Defaults to the privacy cookie name.
     *
     * Attention: Functionality can be broken!
     */
    private function setNames()
    {
        $this->acceptButtonOptions['name'] = self::$PRIVACY_COOKIE_NAME;
        $this->declineButtonOptions['name'] = self::$PRIVACY_COOKIE_NAME;
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->setMessages();
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
            $html = $this->message;
            if (!empty($this->messageWrapperOptions)) {
                $wrapperTag = ArrayHelper::remove($this->messageWrapperOptions, 'tag', 'a');
                $html = Html::tag($wrapperTag, $html, $this->messageWrapperOptions);
            }
            if (!empty($this->acceptButtonOptions)){
                $wrapperTag = ArrayHelper::remove($this->acceptButtonOptions, 'tag', 'button');
                $buttons = Html::tag($wrapperTag, $this->acceptButtonText, $this->acceptButtonOptions);
            }
            if (!empty($this->declineButtonOptions)){
                $wrapperTag = ArrayHelper::remove($this->declineButtonOptions, 'tag', 'button');
                $buttons .= Html::tag($wrapperTag, $this->declineButtonText, $this->declineButtonOptions);
            }
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
