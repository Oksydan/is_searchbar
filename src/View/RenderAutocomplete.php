<?php

namespace Oksydan\IsSearchbar\View;

use Oksydan\IsSearchbar\Search\DTO\ResultDTO;
use Oksydan\IsSearchbar\Presenter\ProductPresenter;

class RenderAutocomplete implements RenderInterface
{
    private \Context $context;

    private ProductPresenter $productPresenter;

    private const TEMPLATE = 'module:is_searchbar/views/templates/front/search_result.tpl';

    public function __construct(
        \Context $context,
        ProductPresenter $productPresenter
    ) {
        $this->context = $context;
        $this->productPresenter = $productPresenter;
    }

    public function render(ResultDTO $searchResult): string
    {
        $this->assignVariables($searchResult);

        return $this->renderTemplate();
    }

    private function renderTemplate(): string
    {
        return $this->context->smarty->fetch(self::TEMPLATE);
    }

    private function assignVariables(ResultDTO $searchResult): void
    {
        $productsPresented = [];
        $moreResults = null;
        $moreResultsCount = 0;

        foreach ($searchResult->getProducts() as $product) {
            $productsPresented[] = $this->productPresenter->present($product);
        }

        if (iterator_count($searchResult->getProducts()) > 0) {
            $moreResults = $this->context->link->getPageLink('search', true, null, ['s' => $searchResult->getExpr()]);
            $moreResultsCount = $searchResult->getTotal() - iterator_count($searchResult->getProducts());
        }

        $this->context->smarty->assign([
            'products' => $productsPresented,
            'moreResults' => $moreResults,
            'moreResultsCount' => $moreResultsCount,
        ]);
    }
}
