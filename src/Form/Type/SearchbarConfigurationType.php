<?php

declare(strict_types=1);

namespace Oksydan\IsSearchbar\Form\Type;

use Oksydan\IsSearchbar\Configuration\SearchbarConfiguration;
use Oksydan\IsSearchbar\Translations\TranslationDomains;
use PrestaShopBundle\Form\Admin\Type\MultistoreConfigurationType;
use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Contracts\Translation\TranslatorInterface;

class SearchbarConfigurationType extends TranslatorAwareType
{
    public function __construct(
        TranslatorInterface $translator,
        array $locales
    ) {
        parent::__construct($translator, $locales);
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $min = 1;
        $max = 100;
        $invalidMessage = $this->trans(
            'This field value have to be between %min% and %max%.',
            TranslationDomains::TRANSLATION_DOMAIN_ADMIN,
            [
                '%min%' => $min,
                '%max%' => $max,
            ]
        );

        $builder
            ->add('perPage', TextType::class, [
                'attr' => ['class' => 'col-md-4 col-lg-2'],
                'label' => $this->trans(
                    'Number of products to display in automcomplete',
                    TranslationDomains::TRANSLATION_DOMAIN_ADMIN
                ),
                'constraints' => [
                    new Range([
                        'min' => $min,
                        'max' => $max,
                        'invalidMessage' => $invalidMessage,
                        'maxMessage' => $invalidMessage,
                        'minMessage' => $invalidMessage,
                    ]),
                ],
                'multistore_configuration_key' => SearchbarConfiguration::IS_SEARCHBAR_PER_PAGE,
            ]);
    }

    /**
     * {@inheritdoc}
     *
     * @see MultistoreConfigurationTypeExtension
     */
    public function getParent(): string
    {
        return MultistoreConfigurationType::class;
    }
}
