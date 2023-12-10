<?php

declare(strict_types=1);

namespace Oksydan\IsSearchbar\Search;

use Oksydan\IsSearchbar\Search\DTO\ResultDTO;
use Oksydan\IsSearchbar\Search\DTO\SearchDTO;

interface FinderInterface
{
    /**
     * @param SearchDTO $searchDTO
     *
     * @return ResultDTO
     */
    public function find(SearchDTO $searchDTO): ResultDTO;
}
