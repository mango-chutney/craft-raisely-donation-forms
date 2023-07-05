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
    public function getEmbed(string $slug): ?Markup
    {
        if ($slug !== '') {
            Template::js('https://cdn.raisely.com/v3/public/embed.js');

            return Template::raw('<div class="raisely-donate" data-width="100%" data-height="800" data-campaign-path="' . $slug . '" data-profile=""></div/>');
        }

        return null;
    }

    public function getDonations(string $slug, ?int $limit = null): array
    {
        $donations = Craft::$app->getCache()->get('raisely-donations');

        if ($donations === false or !isset($donations[$slug])) {
            try {
                $results = RaiselyDonationForms::getInstance()->apiService->fetchDonations($slug);
                $donations[$slug] = $results->data;
            } catch (\Exception) {
                $donations[$slug] = [];
            }
            $duration = RaiselyDonationForms::getInstance()->getSettings()->donationCacheDuration;

            Craft::$app->getCache()->set('raisely-donations', $donations, $duration);
        }

        return array_slice($donations[$slug], 0, $limit);
    }
}
