<?php

namespace Oksydan\IsSearchbar\Search\DTO;

use Oksydan\IsSearchbar\Search\Collection\ProductCollection;

class ResultDTO
{
    private ProductCollection $products;

    private int $total;

    private string $expr;

    public function __construct(
        ProductCollection $products,
        int $total,
        string $expr
    ) {
        $this->products = $products;
        $this->total = $total;
        $this->expr = $expr;
    }

    public function getProducts(): ProductCollection
    {
        return $this->products;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getExpr(): string
    {
        return $this->expr;
    }
}
