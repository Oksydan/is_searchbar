<?php

namespace Oksydan\IsSearchbar\Presenter;

use Oksydan\IsSearchbar\Search\DTO\ProductDTO;
use PrestaShop\PrestaShop\Adapter\Presenter\Product\ProductLazyArray;

class ProductPresenter implements PresenterInterface
{
    protected \Context $context;

    public function __construct(
        \Context $context
    ) {
        $this->context = $context;
    }

    private function presenterFactory(): \ProductPresenterFactory
    {
        return new \ProductPresenterFactory($this->context);
    }

    public function present(ProductDTO $product): ProductLazyArray
    {
        $presenterFactory = $this->presenterFactory();
        $presenter = $presenterFactory->getPresenter();

        return $presenter->present(
            $presenterFactory->getPresentationSettings(),
            (new \ProductAssembler($this->context))->assembleProduct($product->toArray()),
            $this->context->language
        );
    }
}
