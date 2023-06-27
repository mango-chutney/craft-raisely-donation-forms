<?php

namespace mangochutney\raiselydonationforms\services;

use craft\helpers\App;
use GuzzleHttp\Client;
use mangochutney\raiselydonationforms\RaiselyDonationForms;
use yii\base\Component;

/**
 * Raisely Service service
 */
class ApiService extends Component
{
    public function fetchCampaigns(): mixed
    {
        return $this->_getApi('campaigns');
    }

    public function fetchDonations(string $campaign): mixed
    {
        return $this->_getApi('donations?campaign=' . $campaign);
    }

    private function _getApi(string $endpoint): mixed
    {
        $token = RaiselyDonationForms::getInstance()->getSettings()->raiselyApiKey;

        $client = new Client();

        $response = $client->request('GET', 'https://api.raisely.com/v3/' . $endpoint, [
            'headers' => [
                'Authorization' => 'Bearer ' . App::parseEnv($token),
                'accept' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody());
    }
}
