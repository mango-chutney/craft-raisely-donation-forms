<?php

namespace mangochutney\raiselydonationforms\models;

use Craft;
use craft\base\Model;
use craft\helpers\Template;
use Twig\Markup;

/**
 * Raisely Donation Forms settings
 */
class DonationForm extends Model
{
    public $slug;

    public function getHtml(): ?Markup
    {
        Template::js('https://cdn.raisely.com/v3/public/embed.js');

        return Template::raw('<div class="raisely-donate" data-campaign-path="' . $this->slug . '" data-profile=""></div/>');
    }
}
