<?php

namespace mangochutney\raiselydonationforms\fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\elements\db\ElementQueryInterface;
use craft\helpers\StringHelper;
use yii\db\Schema;
use mangochutney\raiselydonationforms\RaiselyDonationForms;
use mangochutney\raiselydonationforms\models\DonationForm as DonationFormClass;


/**
 * Donation Form field type
 */
class DonationForm extends Field
{
    public function init(): void
    {
        parent::init();

        $results = Craft::$app->getCache()->get('raisely');

        if ($results == false) {
            $forms = RaiselyDonationForms::getInstance()->raiselyService->fetchApi();

            Craft::$app->getCache()->set('raisely', $forms);
        }
    }

    public static function displayName(): string
    {
        return Craft::t('raisely-donation-forms', 'Raisely Donation Form');
    }

    public static function valueType(): string
    {
        return 'mixed';
    }

    public function getContentColumnType(): array|string
    {
        return Schema::TYPE_STRING;
    }

    public function normalizeValue(mixed $value, ElementInterface $element = null): mixed
    {
        if ($value instanceof DonationFormClass) {
            return $value->slug;
        }

        $form =  new DonationFormClass();

        if (is_array($value)) {
            $form->slug = $value['slug']  ?? $value['data'];
            return $form;
        }

        if (!is_array($value)) {
            $data = json_decode($value, true);

            $form->slug = $data['slug'] ?? $value;
            return $form;
        }

        return null;
    }

    protected function inputHtml(mixed $value, ElementInterface $element = null): string
    {
        $forms = Craft::$app->getCache()->get('raisely');

        return Craft::$app->getView()->renderTemplate('raisely-donation-forms/donation-form-field/_input', [
            'field'  => $this,
            'value' => $value ?? '',
            'data' => $forms->data
        ]);
    }
}
