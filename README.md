<p align="center">
  <img src="https://raw.githubusercontent.com/luyadev/luya/master/docs/logo/luya-logo-0.2x.png" alt="LUYA Logo"/>
</p>

# LUYA privacy extension

[![LUYA](https://img.shields.io/badge/Powered%20by-LUYA-brightgreen.svg)](https://luya.io)
[![Latest Stable Version](https://poser.pugx.org/luyadev/luya-privacy/v/stable)](https://packagist.org/packages/luyadev/luya-privacy)
[![Total Downloads](https://poser.pugx.org/luyadev/luya-privacy/downloads)](https://packagist.org/packages/luyadev/luya-privacy)
[![Slack Support](https://img.shields.io/badge/Slack-luyadev-yellowgreen.svg)](https://slack.luya.io/)

The LUYA privacy extension has helpers for privacy management, as needed by certain privacy laws.
It includes:
- [Privacy cookie widget](#privacy-cookie-widget)
- [Privacy asset](#privacy-asset)
- [Privacy trait](#privacy-trait)

## Installation

Install the extension through composer:

`composer require luyadev/luya-privacy:dev-master`

Then import the blocks

`./luya import`

## Privacy cookie widget
The privacy widget shows a privacy cookie warning and stops cookies, if they are implemented using the privacy trait as
 check or if they are inside a [PrivacyAsset](https://github.com/luyadev/luya-privacy/blob/master/src/assets/PrivacyAsset.php)
  in `$jsOnPrivacyAccepted`. 
It can be set to use no cookie at all or to place a single cookie and save that the user declined.

### Usage
The privacy widget must be placed somewhere on the page, e.g. inside the main layout.
```
<?= \luya\privacy\widgets\PrivacyWidget::widget([
    'message' => 'We use cookies on our site. Please read and accept our privacy agreement',
    'messageWrapperOptions' => [
        'tag' => 'a',
        'class' => 'message',
        'href' => '/privacy'
        ],
    'acceptButtonText' => 'I accept',
    'acceptButtonOptions' => [
        'tag' => 'button',
        'value' => true,
        'class' => 'btn btn-primary',
    ],
    'declineButton' => true,
    'declineButtonText' => 'I decline',
    'declineButtonOptions => [
        'tag' => 'button',
        'value' => false,
        'class' => 'btn',
    ],
    'forceOutput' => false
]); ?>
```

## Privacy asset
Assets with js cookies should extend [PrivacyAsset](https://github.com/luyadev/luya-privacy/blob/master/src/assets/PrivacyAsset.php)
They can be included by adding to the `$jsOnPrivacyAccepted` array.

### Usage
```
class MyCustomTrackerAsset extends PrivacyAsset 
{
    ...
    
    $jsOnPrivacyAccepted = [
        'js/google-analytics.js',
        'js/facebook-pixel.js',
    ]
}
```

## Privacy trait
The privacy trait can be used make checks if the privacy policies are accepted, declined or nothing at all. 
Moreover it can be used to set the state.