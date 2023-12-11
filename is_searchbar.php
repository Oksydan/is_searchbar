<?php

declare(strict_types=1);

if (!defined('_PS_VERSION_')) {
    exit;
}

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

use Oksydan\IsSearchbar\Hook\HookInterface;
use PrestaShop\PrestaShop\Adapter\SymfonyContainer;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class Is_Searchbar extends Module
{
    public function __construct()
    {
        $this->name = 'is_searchbar';
        $this->author = 'Igor Stępień';
        $this->version = '4.0.0';
        $this->need_instance = 0;

        parent::__construct();

        $this->displayName = $this->trans('Search bar', [], 'Modules.Issearchbar.Admin');
        $this->description = $this->trans('Adds a quick search field to your website.', [], 'Modules.Issearchbar.Admin');

        $this->ps_versions_compliancy = ['min' => '8.1.0', 'max' => _PS_VERSION_];
    }

    public function isUsingNewTranslationSystem()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function install(): bool
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }

        return parent::install()
            && $this->registerHook('displayTop')
            && $this->registerHook('displayBeforeBodyClosingTag')
            && $this->registerHook('displaySearch')
            && Configuration::updateGlobalValue(SearchbarConfiguration::IS_SEARCHBAR_PER_PAGE, 8)
        ;
    }

    /**
     * @return bool
     */
    public function uninstall(): bool
    {
        return parent::uninstall();
    }

    /** @param string $methodName */
    public function __call($methodName, array $arguments)
    {
        if (str_starts_with($methodName, 'hook') && $hook = $this->getHookObject($methodName)) {
            return $hook->execute(...$arguments);
        } else {
            return null;
        }
    }

    /**
     * @param string $methodName
     *
     * @return HookInterface|null
     */
    private function getHookObject($methodName)
    {
        $serviceName = sprintf(
            'Oksydan\IsSearchbar\Hook\%s',
            ucwords(str_replace('hook', '', $methodName))
        );

        $hook = $this->getService($serviceName);

        return $hook instanceof HookInterface ? $hook : null;
    }

    /**
     * @template T
     *
     * @param class-string<T>|string $serviceName
     *
     * @return T|object|null
     */
    public function getService($serviceName)
    {
        try {
            return $this->get($serviceName);
        } catch (ServiceNotFoundException $exception) {
            return null;
        }
    }

    public function getContent(): void
    {
        \Tools::redirectAdmin(SymfonyContainer::getInstance()->get('router')->generate('is_searchbar_controller'));
    }
}
