<?php

namespace luya\privacy;

use luya\privacy\traits\PrivacyTrait;
use luya\web\Asset;

/**
 * Privacy Asset File.
 *
 * The privacy asset file adds the possibility to add javascript files which need the privacy policy accepted.
 * 
 * Example usage
 * 
 * ```php
 * class MyCustomTrackerAsset extends PrivacyAsset 
 * {
 *     
 *     $jsOnPrivacyAccepted = [
 *         '//google.com/cdn/js/google-analytics.js',
 *         '//facebook.com/cdn/js/facebook-pixel.js',
 *     ]
 * }
 * ```
 *
 * @author Alex Schmid <alex.schmid@stud.unibas.ch>
 * @since 1.0.0
 */
class PrivacyAsset extends Asset
{
    use PrivacyTrait;

    /**
     * @var array list of JavaScript files that this bundle contains which need privacy policies allowed.
     * Each JavaScript file can be specified in one of the following formats:
     *
     * - an absolute URL representing an external asset. For example,
     *   `http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js` or
     *   `//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js`.
     * - a relative path representing a local asset (e.g. `js/main.js`). The actual file path of a local
     *   asset can be determined by prefixing [[basePath]] to the relative path, and the actual URL
     *   of the asset can be determined by prefixing [[baseUrl]] to the relative path.
     * - an array, with the first entry being the URL or relative path as described before, and a list of key => value pairs
     *   that will be used to overwrite [[jsOptions]] settings for this entry.
     *   This functionality is available since version 2.0.7.
     *
     * Note that only a forward slash "/" should be used as directory separator.
     */
    public $jsOnPrivacyAccepted = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        // merge privacy js files with other js files if accepted.
        if ($this->isPrivacyAccepted()) {
            $this->js = array_merge($this->js, $this->jsOnPrivacyAccepted);
        }
    }
}
