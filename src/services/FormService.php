<?php

namespace mangochutney\raiselydonationforms\services;

use Craft;
use craft\helpers\Template;
use mangochutney\raiselydonationforms\RaiselyDonationForms;
use Twig\Markup;
use yii\base\Component;

/**
 * Form Service service
 */
class FormService extends Component
{
    public function getEmbed(string $slug, ?int $height): ?Markup
    {
        if ($slug !== '') {
            Template::js('https://cdn.raisely.com/v3/public/embed.js');

            return Template::raw('<div class="raisely-donate" data-width="100%" data-height="' . $height . '" data-campaign-path="' . $slug . '" data-profile=""></div/>');
        }

        return null;
    }

    public function getDonations(string $slug, ?int $limit, ?string $sort = '', ?string $order = ''): array
    {
        $donations = Craft::$app->getCache()->get('raisely-donations');
        $hash = hash('crc32', $slug . $limit . $sort . $order);

        if ($donations === false or !isset($donations[$hash])) {
            try {
                $results = RaiselyDonationForms::getInstance()->apiService->fetchDonations($slug, $limit, $sort, $order);
                $donations[$hash] = $results->data;
            } catch (\Exception) {
                $donations[$hash] = [];
            }
            $duration = RaiselyDonationForms::getInstance()->getSettings()->donationCacheDuration;

            Craft::$app->getCache()->set('raisely-donations', $donations, $duration);
        }

        return $donations[$hash];
    }
}
