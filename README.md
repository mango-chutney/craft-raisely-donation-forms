# Raisely Donation Forms

A field plugin to fetch [Raisely](https://raisely.com/) donation data and embed forms in your [Craft CMS](https://craftcms.com/) content.

## Installation

This plugin requires Craft CMS 4.4.15 or later, and PHP 8.0.2 or later.

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

_Your API key can be found by going to Settings > API & Webhooks in a campaigns side navigation. Any campaign API key can be used for your whole Raisely account_

2. Create a Raisely Donation Form field and select a form

_Use the `Refresh Campaigns` button if the campaigns listed in the dropdown don't match those in your Raisely account_

3. Embed a form in your template using `{{ entry.yourField.renderForm() }}`

By default Raisely forms are rendered with an initial height of 800px which can lead to unwanted layout shift. To fix this you can pass a height variable `{{ entry.yourField.renderForm(400) }}`.

_Use `{{ entry.yourField.isEmpty() }}` to check if the field is populated_

or fetch campaign donations with `{{ entry.yourField.getDonations() }}`, this will return an array that you can loop through to display donations with something like

```twig
  {% for item in entry.yourField.getDonations() %}
    {{ item.anonymous == true ? 'Anonymous' : item.firstName }} donated {{ item.publicAmount|currency }}
  {% endfor %}
```

The amount of donations fetched is limited to 10 by default, but you can change this with a `donationLimit` setting in your `config/raisely-donation-forms.php` file, or by passing a limit variable `entry.yourField.getDonations(5)` - there is currently no pagination so results will be limited to the first page of results from the API.

The sort order of donations fetched can be changed using `sort` and `order` variables, for example `entry.yourField.getDonations(10, 'date', 'asc')` would return the 10 oldest donations, or `entry.yourField.getDonations(5, 'amount', 'desc')` would return the 5 top donations.

_A reference of available data can be found in the [Raisely API docs](https://developers.raisely.com/reference/getdonations). NOTE: Private data is not fetched_

### Variables

If you prefer, the `renderForm()` and `getDonations()` variables can be used directly in your template using a Raisely campaign path without the need for a field, and without an API key if you aren't using `getDonations()`.

```twig
{{ craft.raisely.renderForm('campaign-path') }}

or

{{ craft.raisely.getDonations('campaign-path') }}
```

Both functions work the same as their field counterparts.

### Caching

Forms and donations are cached for 1 week and 6 hours respectively to avoid making too many API calls, and for a better user experience - without donation caching, a call would be made every time the template is loaded leading to longer page load times.

If you need to adjust cache times you can use the following settings in your `config/raisely-donation-forms.php` file

```php
'campaignCacheDuration' => 604800,
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
