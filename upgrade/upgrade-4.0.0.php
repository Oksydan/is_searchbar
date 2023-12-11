<?php

use Oksydan\IsSearchbar\Configuration\SearchbarConfiguration;

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_4_0_0($module)
{
    if (Shop::isFeatureActive()) {
        Shop::setContext(Shop::CONTEXT_ALL);
    }

    $res = $module->registerHook('displayBeforeBodyClosingTag');
    $res .= Configuration::updateGlobalValue(SearchbarConfiguration::IS_SEARCHBAR_PER_PAGE, 8);

    return $res;
}
