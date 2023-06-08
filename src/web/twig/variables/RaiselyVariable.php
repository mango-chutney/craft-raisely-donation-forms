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
}
