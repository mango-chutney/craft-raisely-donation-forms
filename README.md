# Raisely Donation Forms

A field plugin to fetch and embed [Raisely](https://raisely.com/) donation forms in your [Craft CMS](https://craftcms.com/) content.

## Installation

This plugin requires Craft CMS 4.4.5 or later, and PHP 8.0.2 or later.

1. To install, visit the plugin store from your Craft project, or using

```bash
composer require mango-chutney/craft-raisely-donation-forms
```

2. In the Control Panel, go to **Settings** → **Plugins** and click the “Install” button for Raisely Donation Forms, or run:

```bash
php craft plugin/install raisely-donation-forms
```

## Usage

1. Add your Raisely API key in your CMS settings or create a create a `config/raisely-donation-forms.php` file with the following:

```php
'raiselyApiToken' => 'RAISELY_API_KEY'
```

2. Create a Raisely Donation Form field and select a form

_Use the Refresh forms button if the forms listed in the dropdown don't match those in your Raisely account_

3. Embed in your template using `{{ entry.yourField.renderForm() }}`
