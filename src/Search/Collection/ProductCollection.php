<?php

namespace Oksydan\IsSearchbar\Search\Collection;

use Oksydan\IsSearchbar\Search\DTO\ProductDTO;

class ProductCollection implements \IteratorAggregate
{
    /** @var ProductDTO[] */
    private array $products = [];

    public function add(ProductDTO $product): void
    {
        $this->products[] = $product;
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->products);
    }
}
