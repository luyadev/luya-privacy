# luya-privacy
Helpers for privacy stuff

## Installation

Install the extension through composer:

`composer require luya/luya-privacy:dev-master`

## Privacy cookie widget
The privacy widget shows a privacy warning and stops cookies. 
It can be set to use no cookie at all or to place a single cookie to 

## Usage
The privacy widget has to be placed somewhere on the page, e.g. inside the main layout.
```
<?= PrivacyWidget::widget([
    'privacyMessage' => 'We use cookies, please accept our privacy policies',
    'messageLink' => 'https://luya.io/privacy',
    'acceptPrivacyButtonText' => 'I read and accept',
    'acceptPrivacyButtonClass' => 'btn btn-primary'
]); ?>
```

Assets with js cookies should extend luya\privacy\assets\PrivacyAsset;

## Configuration

