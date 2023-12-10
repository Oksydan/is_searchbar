<?php

namespace Oksydan\IsSearchbar\Presenter;

use Oksydan\IsSearchbar\Search\DTO\ProductDTO;
use PrestaShop\PrestaShop\Adapter\Presenter\Product\ProductLazyArray;

interface PresenterInterface
{
    public function present(ProductDTO $product): ProductLazyArray;
}
