<?php

namespace luya\privacy\traits;

use Yii;
use yii\web\Cookie;

/**
 * Trait PrivacyTrait
 *
 * The privacy trait helps getting and setting the privacy policy state.
 * It can be used e.g. inside a widget to check the privacy policies' actual settings and to change these.
 *
 * @author Alex Schmid <alex.schmid@stud.unibas.ch>
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
trait PrivacyTrait
{
    public static $PRIVACY_COOKIE_NAME = '_privacyPolicy';

    /**
     * Cookie Value.
     *
     * Method to retreive the actual privacy policies' state, e.g. whether a user has accepted or declined these.
     * It returns null if the user has not made any choice at all yet.
     *
     * @return boolean|null The privacy value
     */
    public function getPrivacyCookieValue()
    {
        $cookie = Yii::$app->request->cookies->getValue(self::$PRIVACY_COOKIE_NAME, null);
        
        if ($cookie === null) {
            $cookie = Yii::$app->response->cookies->getValue(self::$PRIVACY_COOKIE_NAME, null);
        }
            
        return $cookie;
    }

    /**
     * Sets the privacy cookie value.
     *
     * If it sets this to true, it will allow cookies, if set to false, it will place a single cookie which tells that
     * a user declined the privacy policies. Therefore no other cookies should be allowed.
     *
     * @param string|boolean $value
     */
    public function setPrivacyCookieValue($value = null)
    {
        Yii::$app->response->cookies->add(new Cookie([
            'name' => self::$PRIVACY_COOKIE_NAME,
            'value' => $value,
            'expire' => time() + 86400 * 365, // now + one year
        ]));
    }

    /**
     * Whether privacy cookie is accepted.
     *
     * @return boolean Returns true if accepted.
     */
    public function isPrivacyAccepted()
    {
        return $this->getPrivacyCookieValue() === true;
    }
    
    /**
     * Whether privacy cookie is not decieded.
     *
     * @return boolean Returns true if not decied.
     */
    public function isPrivacyNotDecided()
    {
        return $this->getPrivacyCookieValue() === null;
    }

    /**
     * Whether privacy cookie is declined.
     *
     * @return boolean Returns true if declined.
     */
    public function isPrivacyDeclined()
    {
        return $this->getPrivacyCookieValue() === false;
    }
}
