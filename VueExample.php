<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link    https://matomo.org
 * @license https://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\VueExample;

class VueExample extends \Piwik\Plugin
{
    public function registerEvents()
    {
        $events = [
            'Translate.getClientSideTranslationKeys' => 'getClientSideTranslationKeys',
        ];
        return $events;
    }

    public function getClientSideTranslationKeys(&$translations)
    {
        $translations[] = 'VueExample_MyTitleTooltip';
    }
}
