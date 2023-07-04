<?php

namespace mangochutney\raiselydonationforms\models;

use craft\base\Model;

/**
 * Raisely Donation Forms settings
 */
class Settings extends Model
{
    public string $raiselyApiKey = '';
    public int $campaignCacheDuration = 86400;
    public int $donationCacheDuration = 21600;

    protected function defineRules(): array
    {
        return [
            [['raiselyApiKey'], 'string'],
        ];
    }
}
