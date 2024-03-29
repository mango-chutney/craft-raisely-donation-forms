<?php

namespace mangochutney\raiselydonationforms\models;

use craft\base\Model;

/**
 * Raisely Donation Forms settings
 */
class Settings extends Model
{
    public string $raiselyApiKey = '';
    public int $campaignCacheDuration = 604800;
    public int $donationCacheDuration = 21600;
    public int $donationLimit = 10;

    protected function defineRules(): array
    {
        return [
            [['raiselyApiKey'], 'string'],
        ];
    }
}
