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

## Installation

Install the extension through composer:

`composer require luyadev/luya-privacy:dev-master`

Then import the blocks

`./luya import`

## Privacy cookie widget
The privacy widget shows a privacy warning and stops cookies. 
It can be set to use no cookie at all or to place a single cookie and save that the user declined.

## Usage
The privacy widget must be placed somewhere on the page, e.g. inside the main layout.

```
<?= \luya\privacy\widgets\PrivacyWidget::widget([
    'privacyMessage' => 'We use cookies, please accept our privacy policies',
    'messageLink' => 'https://luya.io/privacy',
    'acceptPrivacyButtonText' => 'I read and accept',
    'acceptPrivacyButtonClass' => 'btn btn-primary'
]); ?>
```

Assets with js cookies must extend [PrivacyAsset](https://github.com/luyadev/luya-privacy/blob/master/src/assets/PrivacyAsset.php)
```
$jsOnPrivacyAccepted = [
    'js/google-analytics.js',
    'js/facebook-pixel.js',
]
```

## Configuration

`privacyMessage`
- The message shown to the user

`messageLink`
- The place where the message should link to

`acceptPrivacyButtonText`
- The text shown on the accept privacy policies button

`acceptPrivacyButtonText`
- The text shown on the accept privacy policies button

`forceOutput`
- Force the widget to output, even if already set