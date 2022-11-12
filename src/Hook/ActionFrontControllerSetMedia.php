<?php

declare(strict_types=1);

namespace Oksydan\IsSearchbar\Hook;

class ActionFrontControllerSetMedia extends AbstractHook
{
    public function execute(array $params): void
    {
        $this->context->controller->registerJavascript('modules-searchbar', "modules/{$this->module->name}/views/js/is_searchbar.js", [
            'position' => 'bottom',
            'priority' => 150,
        ]);
    }
}
