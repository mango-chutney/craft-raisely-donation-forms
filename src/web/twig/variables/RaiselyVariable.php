<?php

namespace mangochutney\raiselydonationforms\web\twig\variables;

use mangochutney\raiselydonationforms\RaiselyDonationForms;

/**
 * Twig extension
 */
class RaiselyVariable
{
    public function renderForm(string $slug)
    {
        return RaiselyDonationForms::getInstance()->formService->getEmbed($slug);
    }

    public function getDonations(string $slug, int $limit = null)
    {
        return RaiselyDonationForms::getInstance()->formService->getDonations($slug, $limit);
    }
}
