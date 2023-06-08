<?php

namespace mangochutney\raiselydonationforms\services;

use craft\helpers\Template;
use Twig\Markup;
use yii\base\Component;

/**
 * Form Service service
 */
class FormService extends Component
{
    public function getEmbed(string $slug): ?Markup
    {
        Template::js('https://cdn.raisely.com/v3/public/embed.js');

        return Template::raw('<div class="raisely-donate" data-width="100%" data-height="800px" data-campaign-path="' . $slug . '" data-profile=""></div/>');
    }
}
