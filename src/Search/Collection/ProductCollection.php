<?php

namespace Oksydan\IsSearchbar\Search\Collection;

use ArrayIterator;
use IteratorAggregate;
use Oksydan\IsSearchbar\Search\DTO\ProductDTO;
use Traversable;

class ProductCollection implements IteratorAggregate
{
    /** @var ProductDTO[] */
    private array $products = [];

    public function add(ProductDTO $product): void
    {
        $this->products[] = $product;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->products);
    }
}
