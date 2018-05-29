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
 * This widget will show a privacy notification. It includes a privacy cookie content, which can be accepted or declined.
 * The cookie content will disappear after the user has taken a choice and if forceOutput is false. Otherwise it will show up.
 * All settings can be passed as an array to the widget.
 *
 * Attention: The widget's functionality can be broken if it is not correctly used! It has to be taken in account that
 * the trackers or other cookies need to be set through either the \luya\privacy\assets\PrivacyAsset's $jsOnPrivacyAccepted
 * or having been checked through \luya\privacy\traits\PrivacyTrait's `isPrivacyAccepted()` method.
 *
 * Usage:
 * ```php
 * PrivacyWidget::widget([
 *      'content' => [
 *          'content' => 'We use cookies on our site. Please read and accept our privacy agreement',
 *          'tag' => 'a',
 *          'class' => 'content',
 *          'href' => '/privacy'
 *      ],
 *      'acceptButton' => [
 *          'content' => 'I accept',,
 *          'tag' => 'button',
 *          'value' => true,
 *          'class' => 'btn btn-primary',
 *      ],
 *      'declineButtonText' => [
 *          'content' =>  'I decline',
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
     * @var string|array Provide a string which is the content from the div, or provide an array in order to build a full
     * html element.
     */
    public $message;

    /**
     * @var array The button element in order to accept privacy
     */
    public $acceptButton = [
        'tag' => 'a',
        'href' => '?acceptCookies=1',
        'class' => 'btn btn-primary',
    ];

    /**
     * @var array|boolean The decline button element, if false it will not be rendered.
     */
    public $declineButton = false;

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
     * @param $config string The configuration (E.g. the button config).
     * @param $defaultTag string The html tag which is used as default if there is nothing set.
     * @param $defaultcontent string The content which is set if there is nothing set.
     * @return string
     */
    protected function buildTag($config, $defaultTag, $defaultContent)
    {
        // false means we don't want to render this tag
        if ($config === false) {
            return false;
        }

        // if its an empty string, generate an array
        if (empty($config)) {
            $config = (array) $config;
        }
        // for example when `$content` does only contain a text, this is used as content property in the config
        if (!is_array($config)) {
            $content = $config;
            $config = [];
            $config['content'] = $content;
        }
        
        $tag = ArrayHelper::remove($config, 'tag', $defaultTag);
        $content = ArrayHelper::remove($config, 'content', $defaultContent);
        
        return Html::tag($tag, $content, $config);
    }

    /**
     * @inheritdoc
     *
     * If privacy policies are whether accepted nor declined, or forcing output is set, it will show up the widget.
     * The widget gives the user the ability to chose the cookie settings.
     */
    public function run()
    {
        // see if user clicks on a button
        $acceptCookies = Yii::$app->request->get('acceptCookies');
        
        // cookie param provided with status accepted
        if ($acceptCookies == '1') {
            $this->setPrivacyCookieValue(true);
            // @TODO: maybe we have to complet reload the page in order to see cookie is set.
        }
        
        if (!$this->isPrivacyAccepted() || $this->forceOutput) {
            
            return $this->render('privacywidget', [
                'css' => $this->css,
                'messageDiv' => $this->buildTag($this->message, 'div', Module::t('privacy_widget.privacy_content')),
                'acceptButton' => $this->buildTag($this->acceptButton, 'a', Module::t('privacy_widget.accept_privacy_button_text')),
                'declineButton' => $this->buildTag($this->declineButton, 'a', Module::t('privacy_widget.decline_privacy_button_text')),
            ]);
        }
    }
}
