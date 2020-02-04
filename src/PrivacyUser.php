<?php

namespace luya\privacy;

use luya\privacy\traits\PrivacyTrait;

/**
 * An Object which holds the Privacy Trait.
 * 
 * This object can be used to pass from a class to another. Like `setPrivatUser(PrivacyUser $user)` in order to determine whether
 * cookies should be accepted or not.
 * 
 * @author Basil Suter <git@nadar.io>
 * @since 1.0.5
 */
class PrivacyUser
{
    use PrivacyTrait;
}