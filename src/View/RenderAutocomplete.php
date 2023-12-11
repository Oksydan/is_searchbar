<?php

namespace Oksydan\IsSearchbar\View;

use Oksydan\IsSearchbar\Presenter\ProductPresenter;
use Oksydan\IsSearchbar\Search\DTO\ResultDTO;

class RenderAutocomplete implements RenderInterface
{
    public const TYPE_DESKTOP = 'desktop';

    public const TYPE_MOBILE = 'mobile';

    private const TEMPLATE_MOBILE = 'search_result_mobile.tpl';

    private const TEMPLATE_DESKTOP = 'search_result.tpl';

    private string $type = self::TYPE_DESKTOP;

    private \Context $context;

    private ProductPresenter $productPresenter;

    public function __construct(
        \Context $context,
        ProductPresenter $productPresenter
    ) {
        $this->context = $context;
        $this->productPresenter = $productPresenter;
    }

    public function render(ResultDTO $searchResult, string $type): string
    {
        $this->assignVariables($searchResult);
        $this->assignType($type);

        return $this->renderTemplate();
    }

    private function assignType(string $type): void
    {
        if (in_array($type, [self::TYPE_DESKTOP, self::TYPE_MOBILE])) {
            $this->type = $type;
        }
    }

    private function getTemplate(): string
    {
        $template = 'module:is_searchbar/views/templates/front/';

        if ($this->type === self::TYPE_MOBILE) {
            return $template . self::TEMPLATE_MOBILE;
        }

        return $template . self::TEMPLATE_DESKTOP;
    }

    private function renderTemplate(): string
    {
        return $this->context->smarty->fetch($this->getTemplate());
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
