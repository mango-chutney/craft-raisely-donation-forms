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

    public function __toString(): string
    {
        return $this->slug ?? '';
    }

    public function isEmpty(): bool
    {
        return $this->slug === null || $this->slug === '';
    }

    public function renderForm(int $height = 800): ?Markup
    {
        if (is_string($this->slug) && $this->slug !== '') {
            return RaiselyDonationForms::getInstance()->formService->getEmbed($this->slug, $height);
        }

        return null;
    }

    public function getDonations(int $limit = null, string $sort = '', string $order = ''): ?array
    {
        if (is_string($this->slug) && $this->slug !== '') {
            return RaiselyDonationForms::getInstance()->formService->getDonations($this->slug, $limit, $sort, $order);
        }

        return null;
    }
}
