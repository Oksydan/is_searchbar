<?php

namespace Oksydan\IsSearchbar\Search\DTO;

class ProductDTO
{
    private int $idProduct;

    public function __construct(int $idProduct)
    {
        $this->idProduct = $idProduct;
    }

    public function getIdProduct(): int
    {
        return $this->idProduct;
    }

    public function toArray(): array
    {
        return [
            'id_product' => $this->idProduct,
        ];
    }
}
