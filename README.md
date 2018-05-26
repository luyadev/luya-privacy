# luya-privacy
Helpers for privacy stuff

## Installation

Install the extension through composer:

`composer require luyadev/luya-privacy:dev-master`

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