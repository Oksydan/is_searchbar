<?php

namespace Oksydan\IsSearchbar\View;

use Oksydan\IsSearchbar\Search\DTO\ResultDTO;

interface RenderInterface
{
    public function render(ResultDTO $searchResult): string;
}
