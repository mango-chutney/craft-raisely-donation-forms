<?php

namespace mangochutney\raiselydonationforms\controllers;

use Craft;
use craft\web\Controller;
use yii\web\Response;
use mangochutney\raiselydonationforms\RaiselyDonationForms;

class FormsController extends Controller
{
    public function actionRefreshCache(): Response
    {
        $this->requireAcceptsJson();
        $forms = RaiselyDonationForms::getInstance()->raiselyService->fetchApi();
        Craft::$app->getCache()->set('raisely', $forms);

        return $this->asJson([
            'success' => true,
            'forms' => $forms
        ]);
    }
}
