<?php
namespace luya\privacy\widgets;

use luya\privacy\BasePrivacyWidget;
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
 * 
 * @todo Widget id must be better
 * @todo Position -> fixed / relative
 */
class PrivacyWidget extends BasePrivacyWidget
{    
    /**
     * @var string The cookie message which will be shown to the user
     */
    public $privacyMessage;

    /**
     * @var string Link to the privacy policy page
     */
    public $messageLink = '';
    
    /**
     * @var string Text on the accept button
     */
    public $acceptPrivacyButtonText;

    /**
     * @var string Accept privacy policy button css class
     */
    public $acceptPrivacyButtonClass = 'btn btn-primary';

    /**
     * @var bool Whether it should have a decline button or not
     * @todo Implement decline functionality
     */
    public $declineButton = false;

    /**
     * @var string Text on the decline button
     */
    public $declinePrivacyButtonText;

    /**
     * @var string Decline privacy policy button css class
     */
    public $declinePrivacyButtonClass = 'btn';

    /**
     * @var bool Whether the buttons should be forced.
     */
    public $forceOutput = false;

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
                    }
                    .privacyPolicyConsent a {
                        color: #fff;
                    }';

    /**
     * @var bool Whether to remove css or not
     */
    public $removeCSS = false;

    /**
     * Add a decline cookie. Needed to set the declined privacy policies cookie.
     */
    private $addDeclineCookie = false;
    
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
        if(empty($this->declinePrivacyButtonText)) {
            $this->declinePrivacyButtonText = Module::t('privacy_widget.decline_privacy_button_text');
        }
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->setMessages();
        Module::onLoad();
        $privacyPolicy = Yii::$app->request->post('_privacyPolicy', null);
        if (!empty($privacyPolicy)){
            if ($privacyPolicy === 'true') {
                Yii::$app->response->cookies->add(new Cookie(["name" => "_privacyPolicy", "value" => true]));
            } elseif ($privacyPolicy === 'false') {
                Yii::$app->response->cookies->add(new Cookie(["name" => "_privacyPolicy", "value" => false]));
                $this->addDeclineCookie = true;
            }
        }
        if (!$this->isPrivacyAccepted()) {
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
        if ((!$this->isPrivacyAccepted() && !$this->isPrivacyDeclined()) || $this->forceOutput) {
            if (!$this->removeCSS) $this->getView()->registerCss($this->css);
            return $this->render('privacy-widget', [
                'privacyMessage' => $this->privacyMessage,
                'messageLink' => $this->messageLink,
                'acceptPrivacyButtonText' => $this->acceptPrivacyButtonText,
                'acceptPrivacyButtonClass' => $this->acceptPrivacyButtonClass,
                'declineButton' => $this->declineButton,
                'declinePrivacyButtonText' => $this->declinePrivacyButtonText,
                'declinePrivacyButtonClass' => $this->declinePrivacyButtonClass,
            ]);
        }
    }
}