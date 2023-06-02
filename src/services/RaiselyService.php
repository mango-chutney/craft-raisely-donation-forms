<?php

namespace mangochutney\raiselydonationforms\services;

use GuzzleHttp\Client;
use mangochutney\raiselydonationforms\RaiselyDonationForms;
use yii\base\Component;
use craft\helpers\App;

/**
 * Raisely Service service
 */
class RaiselyService extends Component
{
    public function fetchApi(): mixed
    {
        $token = RaiselyDonationForms::getInstance()->getSettings()->raiselyApiToken;

        $client = new Client();

        $response = $client->request('GET', 'https://api.raisely.com/v3/campaigns', [
            'headers' => [
                'Authorization' => 'Bearer ' . App::parseEnv($token),
                'accept' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody());
    }
}
