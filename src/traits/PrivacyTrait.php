<?php

namespace luya\privacy\traits;

use Yii;
use yii\web\Cookie;

/**
 * Trait PrivacyTrait
 * 
 * The privacy trait helps getting and setting the privacy policy state.
 * 
 * @author Alex Schmid <alex.schmid@stud.unibas.ch>
 * @since 1.0.0
 */
trait PrivacyTrait
{
    /**
     * @return bool|null The privacy value
     */
    public function getPrivacy()
    {
        return Yii::$app->response->cookies->getValue('_privacyPolicy', null) !== null ?
            Yii::$app->response->cookies->getValue('_privacyPolicy') : 
            Yii::$app->request->cookies->getValue('_privacyPolicy', null);
    }

    /**
     * Sets the privacy
     */
    public function setPrivacy($value = null)
    {
        Yii::$app->response->cookies->add(new Cookie(['name' => '_privacyPolicy', $value]));
    }

    /**
     * @return bool Checks whether the privacy is accepted or not
     */
    public function isPrivacyAccepted()
    {
        return !empty($this->getPrivacy()) ? true : false;
    }

    /**
     * @return bool Checks whether the privacy is declined or not
     */
    public function isPrivacyDeclined()
    {
        return ($this->getPrivacy() === false) ? true : false;
    }
}