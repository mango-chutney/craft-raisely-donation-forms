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
        $forms = RaiselyDonationForms::getInstance()->apiService->fetchApi();
        Craft::$app->getCache()->set('raisely', $forms);

        return $this->asJson([
            'success' => true,
            'forms' => $forms,
        ]);
    }
}
