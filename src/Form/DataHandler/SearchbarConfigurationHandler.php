<?php

declare(strict_types=1);

namespace Oksydan\IsSearchbar\Form\DataHandler;

use Oksydan\IsSearchbar\Configuration\SearchbarConfiguration;
use PrestaShop\PrestaShop\Core\Configuration\AbstractMultistoreConfiguration;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class SearchbarConfigurationHandler extends AbstractMultistoreConfiguration
{
    private const CONFIGURATION_FIELDS = [
        'perPage',
    ];

    /**
     * @return OptionsResolver
     */
    protected function buildResolver(): OptionsResolver
    {
        return (new OptionsResolver())
            ->setDefined(self::CONFIGURATION_FIELDS)
            ->setAllowedTypes('perPage', 'bool');
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration(): array
    {
        $return = [];
        $shopConstraint = $this->getShopConstraint();

        $return['perPage'] = $this->configuration->get(
            SearchbarConfiguration::IS_SEARCHBAR_PER_PAGE,
            null,
            $shopConstraint
        );

        return $return;
    }

    /**
     * {@inheritdoc}
     */
    public function updateConfiguration(array $configuration): array
    {
        $shopConstraint = $this->getShopConstraint();

        $this->updateConfigurationValue(
            SearchbarConfiguration::IS_SEARCHBAR_PER_PAGE,
            'perPage',
            $configuration,
            $shopConstraint
        );

        return [];
    }
}
