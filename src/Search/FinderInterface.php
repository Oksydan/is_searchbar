<?php

declare(strict_types=1);

namespace Oksydan\IsSearchbar\Search;

use Oksydan\IsSearchbar\Search\DTO\SearchDTO;
use Oksydan\IsSearchbar\Search\DTO\ResultDTO;

interface FinderInterface
{
    /**
     * @param SearchDTO $searchDTO
     *
     * @return ResultDTO
     */
    public function find(SearchDTO $searchDTO): ResultDTO;
}
