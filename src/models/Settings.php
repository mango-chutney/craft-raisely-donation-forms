<?php

namespace mangochutney\raiselydonationforms\models;

use Craft;
use craft\base\Model;

/**
 * Raisely Donation Forms settings
 */
class Settings extends Model
{
    public string $raiselyApiToken = '';

    protected function defineRules(): array
    {
        return [
            [['raiselyApiToken'], 'string'],
        ];
    }
}
