<?php

namespace mangochutney\raiselydonationforms\models;

use craft\base\Model;
use mangochutney\raiselydonationforms\RaiselyDonationForms;
use Twig\Markup;

/**
 * Raisely Donation Forms settings
 */
class DonationForm extends Model
{
    public $slug;

    public function renderForm(): ?Markup
    {
        return RaiselyDonationForms::getInstance()->formService->getEmbed($this->slug);
    }
}
