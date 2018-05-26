<?php

namespace luya\privacy\assets;

use luya\admin\assets\Jquery;
use luya\privacy\traits\PrivacyTrait;
use luya\web\Asset;

/**
 * Privacy Asset File.
 * 
 * The privacy asset file adds the possibility to add javascript files which need the privacy policy accepted.
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
    function registerAssetFiles($view)
    {
        parent::registerAssetFiles($view);
        
        if ($this->isPrivacyAccepted())
        {
            foreach ($this->jsOnPrivacyAccepted as $js)
            {
                if (is_array($js)) {
                    $file = array_shift($js);
                    $options = ArrayHelper::merge($this->jsOptions, $js);
                    $view->registerJsFile($manager->getAssetUrl($this, $file), $options);
                } else {
                    if ($js !== null) {
                        $view->registerJsFile($manager->getAssetUrl($this, $js), $this->jsOptions);
                    }
                }
            }
        }
    }
}
