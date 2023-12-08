<?php

declare(strict_types=1);

namespace Oksydan\IsSearchbar\Form\Provider;

use Oksydan\IsSearchbar\Form\DataHandler\SearchbarConfigurationHandler;
use PrestaShop\PrestaShop\Core\Form\FormDataProviderInterface;

class SearchbarConfigurationFormDataProvider implements FormDataProviderInterface
{
    /**
     * @var SearchbarConfigurationHandler
     */
    private SearchbarConfigurationHandler $searchbarConfigurationDataConfiguration;

    /**
     * @param SearchbarConfigurationHandler $searchbarConfigurationDataConfiguration
     */
    public function __construct(SearchbarConfigurationHandler $searchbarConfigurationDataConfiguration)
    {
        $this->searchbarConfigurationDataConfiguration = $searchbarConfigurationDataConfiguration;
    }

    public function getData(): array
    {
        return $this->searchbarConfigurationDataConfiguration->getConfiguration();
    }

    public function setData(array $data)
    {
        $this->searchbarConfigurationDataConfiguration->updateConfiguration($data);
    }
}
