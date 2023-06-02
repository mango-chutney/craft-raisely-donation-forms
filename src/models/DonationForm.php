<?php

namespace mangochutney\raiselydonationforms\models;

use craft\base\Model;
use craft\helpers\Template;
use Twig\Markup;

/**
 * Raisely Donation Forms settings
 */
class DonationForm extends Model
{
    public $slug;

    public function renderForm(): ?Markup
    {
        Template::js('https://cdn.raisely.com/v3/public/embed.js');

        return Template::raw('<div class="raisely-donate" data-width="100%" data-height="800px" data-campaign-path="' . $this->slug . '" data-profile=""></div/>');
    }
}
