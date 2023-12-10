<?php

declare(strict_types=1);

namespace Oksydan\IsSearchbar\Search;

use Oksydan\IsSearchbar\Search\Collection\ProductCollection;
use Oksydan\IsSearchbar\Search\DTO\ProductDTO;
use Oksydan\IsSearchbar\Search\DTO\ResultDTO;
use Oksydan\IsSearchbar\Search\DTO\SearchDTO;

class ProductFinder implements FinderInterface
{
    protected int $total = 0;

    protected ProductCollection $collection;

    public function __construct()
    {
        $this->collection = new ProductCollection();
    }

    public function find(SearchDTO $searchDTO): ResultDTO
    {
        $result = \Search::find(
            $searchDTO->getIdLang(),
            $searchDTO->getExpr(),
            1,
            $searchDTO->getPerPage(),
        );

        $this->total = (int) $result['total'];

        foreach ($result['result'] as $product) {
            $this->collection->add(new ProductDTO((int) $product['id_product']));
        }

        return new ResultDTO(
            $this->collection,
            $this->total,
            $searchDTO->getExpr()
        );
    }
}
