# Raisely Donation Forms

A field plugin to fetch [Raisely](https://raisely.com/) donation data and embed forms in your [Craft CMS](https://craftcms.com/) content.

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

### Field

1. Add your Raisely API key in your CMS settings or create a create a `config/raisely-donation-forms.php` file with the following:

```php
'raiselyApiKey' => 'RAISELY_API_KEY'
```

2. Create a Raisely Donation Form field and select a form

_Use the `Refresh Campaigns` button if the campaigns listed in the dropdown don't match those in your Raisely account_

3. Embed a form in your template using `{{ entry.yourField.renderForm() }}`

_Use `{{ entry.yourField.isEmpty() }}` to check if the field is populated_

or fetch campaign donations with `{{ entry.yourField.getDonations() }}`, this will return an array that you can loop through to display donations with something like

```twig
  {% for item in entry.yourField.getDonations() %}
    {{ item.anonymous == true ? 'Anonymous' : item.firstName }} donated {{ item.publicAmount|currency }}
  {% endfor %}
```

If you only want to return a few donations, you can pass a limit variable `entry.yourField.getDonations(5)`

_A reference of available data can be found in the [Raisely API docs](https://developers.raisely.com/reference/getdonations)_

### Variables

If you prefer, the `renderForm()` and `getDonations()` variables can be used directly in your template using a Raisely campaign path without the need for a field, and without an API key if you aren't using `getDonations()`.

```twig
{{ craft.raisely.renderForm('campaign-path') }}

or

{{ craft.raisely.getDonations('campaign-path') }}
```

Both functions work the same as their field counterparts.

### Caching

Forms and donations are cached for 24 hours and 6 hours respectively to avoid making too many API calls, and for a better user experience - without donation caching, a call would be made every time the template is loaded leading to longer page load times.

If you need to adjust cache times you can use the following settings in your `config/raisely-donation-forms.php` file

```php
'campaignCacheDuration' => 86400,
'donationCacheDuration' => 21600
```

You can clear the cache in the Craft Control Panel by going to **Utilities** → **Clear Caches**, or using

```bash
php craft clear-caches/raisely-campaigns
```

and

```bash
php craft clear-caches/raisely-donations
```
