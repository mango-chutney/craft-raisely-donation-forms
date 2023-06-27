<?php

namespace mangochutney\raiselydonationforms\controllers;

use Craft;
use craft\web\Controller;
use mangochutney\raiselydonationforms\RaiselyDonationForms;
use yii\web\Response;

class FormsController extends Controller
{
    public function actionRefreshCache(): Response
    {
        $this->requireAcceptsJson();
        $forms = RaiselyDonationForms::getInstance()->apiService->fetchCampaigns();
        $duration = RaiselyDonationForms::getInstance()->getSettings()->campaignCacheDuration;
        Craft::$app->getCache()->set('raisely-campaigns', $forms, $duration);

        return $this->asJson([
            'success' => true,
            'forms' => $forms,
        ]);
    }
}
