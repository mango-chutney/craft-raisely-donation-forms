<?php

namespace mangochutney\raiselydonationforms\fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\helpers\Html;
use mangochutney\raiselydonationforms\models\DonationForm as DonationFormClass;
use mangochutney\raiselydonationforms\RaiselyDonationForms;
use mangochutney\raiselydonationforms\web\assets\cp\CpAssets;
use yii\db\Schema;

/**
 * Donation Form field type
 */
class DonationForm extends Field
{
    public function init(): void
    {
        parent::init();

        $results = Craft::$app->getCache()->get('raisely-campaigns');

        if ($results === false) {
            try {
                $campaigns = RaiselyDonationForms::getInstance()->apiService->fetchCampaigns();
            } catch (\Exception) {
                $campaigns = [];
            }

            $duration = RaiselyDonationForms::getInstance()->getSettings()->campaignCacheDuration;
            Craft::$app->getCache()->set('raisely-campaigns', $campaigns, $duration);
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

        $form = new DonationFormClass();

        if (is_array($value)) {
            $form->slug = $value['slug'] ?? $value['data'] ?? '';

            return $form;
        }

        $data = json_decode($value, true);

        $form->slug = $data['slug'] ?? $value ?? '';
        return $form;
    }

    public function isValueEmpty(mixed $value, ElementInterface $element): bool
    {
        return $value->slug === '';
    }

    protected function inputHtml(mixed $value, ElementInterface $element = null): string
    {
        $name = $this->handle;
        $id = Html::id($name);
        $view = Craft::$app->getView();
        $view->registerAssetBundle(CpAssets::class);
        Craft::$app->getView()->registerJs('new Craft.RaiselyForms("' . Craft::$app->getView()->namespaceInputId($name) . '");');

        $campaigns = Craft::$app->getCache()->get('raisely-campaigns');

        return Craft::$app->getView()->renderTemplate('raisely-donation-forms/donation-form-field/_input', [
            'field' => $this,
            'value' => $value,
            'data' => $campaigns->data ?? '',
            'id' => $id,
        ]);
    }
}
