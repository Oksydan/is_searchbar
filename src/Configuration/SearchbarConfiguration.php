<?php

declare(strict_types=1);

namespace Oksydan\IsSearchbar\Configuration;

class SearchbarConfiguration
{
    public const IS_SEARCHBAR_PER_PAGE = 'IS_SEARCHBAR_PER_PAGE';

    public function getPerPage(): int
    {
        return (int) \Configuration::get(self::IS_SEARCHBAR_PER_PAGE);
    }
}
