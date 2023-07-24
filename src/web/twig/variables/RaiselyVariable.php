<?php

namespace mangochutney\raiselydonationforms\web\twig\variables;

use mangochutney\raiselydonationforms\RaiselyDonationForms;

/**
 * Twig extension
 */
class RaiselyVariable
{
    public function renderForm(string $slug, int $height = 800)
    {
        return RaiselyDonationForms::getInstance()->formService->getEmbed($slug, $height);
    }

    public function getDonations(string $slug, int $limit = null, string $sort = '', string $order = '')
    {
        return RaiselyDonationForms::getInstance()->formService->getDonations($slug, $limit, $sort, $order);
    }
}
