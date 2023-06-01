<?php

namespace mangochutney\raiselydonationforms;

use Craft;
use craft\base\Model;
use craft\base\Plugin;
use craft\events\RegisterComponentTypesEvent;
use craft\services\Fields;
use mangochutney\raiselydonationforms\fields\DonationForm;
use mangochutney\raiselydonationforms\models\Settings;
use mangochutney\raiselydonationforms\services\RaiselyService;
use craft\events\RegisterTemplateRootsEvent;
use craft\web\View;
use yii\base\Event;

/**
 * Raisely Donation Forms plugin
 *
 * @method static RaiselyDonationForms getInstance()
 * @method Settings getSettings()
 * @author Mango Chutney <team@mangochutney.com.au>
 * @copyright Mango Chutney
 * @license MIT
 * @property-read RaiselyService $raiselyService
 */
class RaiselyDonationForms extends Plugin
{
    public string $schemaVersion = '1.0.0';
    public bool $hasCpSettings = true;

    public static function config(): array
    {
        return [
            'components' => ['raiselyService' => RaiselyService::class],
        ];
    }

    public function init()
    {
        parent::init();

        // Defer most setup tasks until Craft is fully initialized
        Craft::$app->onInit(function () {
            $this->attachEventHandlers();
            Event::on(
                View::class,
                View::EVENT_REGISTER_CP_TEMPLATE_ROOTS,
                function (RegisterTemplateRootsEvent $event) {
                    $event->roots[$this->id] = __DIR__ . '/templates';
                }
            );
        });
    }

    protected function createSettingsModel(): ?Model
    {
        return Craft::createObject(Settings::class);
    }

    protected function settingsHtml(): ?string
    {
        return Craft::$app->view->renderTemplate('raisely-donation-forms/_settings.twig', [
            'plugin' => $this,
            'settings' => $this->getSettings(),
        ]);
    }

    private function attachEventHandlers(): void
    {
        // Register event handlers here ...
        // (see https://craftcms.com/docs/4.x/extend/events.html to get started)
        Event::on(Fields::class, Fields::EVENT_REGISTER_FIELD_TYPES, function (RegisterComponentTypesEvent $event) {
            $event->types[] = DonationForm::class;
        });
    }
}
