<?php
namespace luya\privacy\widgets;

use Yii;
use yii\web\Cookie;
use luya\base\Widget;
use luya\cms\helpers\Url;
use luya\helpers\Json;
use luya\privacy\Module;
use luya\privacy\assets\PrivacyWidgetAsset;
use luya\privacy\traits\PrivacyTrait;

/**
 * Privacy Widget
 * 
 * This widget will show a privacy notification. It includes a privacy (cookie) message, which can be accepted.
 * 
 * ```php
 * PrivacyWidget::widget();
 * ```
 *
 * @author Alex Schmid <alex.schmid@stud.unibas.ch>
 * @since 1.0.0
 */

class PrivacyWidget extends Widget
{
    use PrivacyTrait;
    
    /**
     * @var string The cookie message which will be shown to the user
     */
    public $privacyMessage;

    /**
     * @var string Link to the privacy policy page
     */
    public $messageLink;
    
    /**
     * @var string Text on the accept button
     */
    public $acceptPrivacyButtonText;

    /**
     * @var string Accept privacy policy button css class
     */
    public $acceptPrivacyButtonClass = 'btn';

    /**
     * @var bool Whether it should have a decline button or not
     * @todo Implement decline functionality
     */
    public $addDeclineCookie = false;

    /**
     * @var string CSS to be applied
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
                    }';

    /**
     * Translate messages if no widget input
     */
    private function setMessages()
    {
        if (empty($this->privacyMessage)) {
            $this->privacyMessage = Module::t('privacy_widget.privacy_message');
        }
        if(empty($this->acceptPrivacyButtonText)) {
            $this->acceptPrivacyButtonText = Module::t('privacy_widget.accept_privacy_button_text');
        }
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (!$this->isPrivacyAccepted()) {
            if (!$this->isPrivacyDeclined()) {
                $privacyPolicy = Yii::$app->request->post('_privacyPolicy', null);
                if (!empty($privacyPolicy)){
                    if ($privacyPolicy === 'true') {
                       Yii::$app->response->cookies->add(new Cookie(["name" => "_privacyPolicy", "value" => true]));
                       return;
                    } elseif ($privacyPolicy === 'false') {
                        Yii::$app->response->cookies->add(new Cookie(["name" => "_privacyPolicy", "value" => false]));
                        $this->addDeclineCookie = true;
                    }
                } else {
                    parent::init();
                    $this->setMessages();
                    Module::onLoad();
                }
            }
            Yii::$app->on(Yii::$app::EVENT_AFTER_REQUEST, function ($event) {
                Yii::$app->response->cookies->removeAll();
                if ($this->addDeclineCookie) Yii::$app->response->cookies->add(new Cookie(["name" => "_privacyPolicy", "value" => false]));
            });
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (!$this->isPrivacyAccepted() ) {
            if (!$this->isPrivacyDeclined()) {
                $this->getView()->registerCss($this->css);
                return $this->render('privacy-widget', [
                    'privacyMessage' => $this->privacyMessage,
                    'link' => $this->messageLink,
                    'acceptPrivacyButtonText' => $this->acceptPrivacyButtonText,
                    'acceptPrivacyButtonClass' => $this->acceptPrivacyButtonClass,
                ]);
            }
        }
    }
}