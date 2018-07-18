<p align="center">
  <img src="https://raw.githubusercontent.com/luyadev/luya/master/docs/logo/luya-logo-0.2x.png" alt="LUYA Logo"/>
</p>

# LUYA privacy extension

[![LUYA](https://img.shields.io/badge/Powered%20by-LUYA-brightgreen.svg)](https://luya.io)
[![Latest Stable Version](https://poser.pugx.org/luyadev/luya-privacy/v/stable)](https://packagist.org/packages/luyadev/luya-privacy)
[![Total Downloads](https://poser.pugx.org/luyadev/luya-privacy/downloads)](https://packagist.org/packages/luyadev/luya-privacy)
[![Slack Support](https://img.shields.io/badge/Slack-luyadev-yellowgreen.svg)](https://slack.luya.io/)

The LUYA privacy extension has helpers for privacy management, as needed by certain privacy laws.

+ Widget to agree privacy statement.
+ Asset File to load resources only when cookies are accepted.
+ Trait to attach into your own controllers, blocks etc. in order to trigger whether privacy statements has been accepted or not.

## Installation

Install the extension through composer:

```sh
composer require luyadev/luya-privacy:~1.0.0
```

## Usage

Please take a look at the description in the files for usage and API details:

+ [Privacy Asset](https://github.com/luyadev/luya-privacy/blob/master/src/PrivacyAsset.php)
+ [Cookie Widget](https://github.com/luyadev/luya-privacy/blob/master/src/widgets/PrivacyWidget.php)
+ [Privacy Trait](https://github.com/luyadev/luya-privacy/blob/master/src/traits/PrivacyTrait.php)
