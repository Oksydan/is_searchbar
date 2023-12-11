<?php

declare(strict_types=1);

namespace Oksydan\IsSearchbar\Hook;

class DisplayBeforeBodyClosingTag extends AbstractDisplayHook
{
    private const TEMPLATE_FILE = 'displayBeforeBodyClosingTag.tpl';

    protected function getTemplate(): string
    {
        return self::TEMPLATE_FILE;
    }

    protected function assignTemplateVariables(array $params)
    {
        $variables = [
            'ajax_search_url' => $this->context->link->getModuleLink($this->module->name, 'ajaxSearch'),
            'search_controller_url' => $this->context->link->getPageLink('search', null, null, null, false, null, true),
        ];

        if (!array_key_exists('search_string', $this->context->smarty->getTemplateVars())) {
            $variables['search_string'] = '';
        }

        $this->context->smarty->assign($variables);
    }
}
