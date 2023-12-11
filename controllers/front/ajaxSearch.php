<?php

use Oksydan\IsSearchbar\Configuration\SearchbarConfiguration;
use Oksydan\IsSearchbar\Search\DTO\SearchDTO;
use Oksydan\IsSearchbar\Search\ProductFinder;
use Oksydan\IsSearchbar\View\RenderAutocomplete;

class Is_searchbarAjaxSearchModuleFrontController extends ModuleFrontController
{
    public $search_string;

    public function init()
    {
        parent::init();

        $this->search_string = Tools::getValue('s');
        $this->type = Tools::getValue('type', RenderAutocomplete::TYPE_DESKTOP);
    }

    public function initContent()
    {
        parent::initContent();

        $this->ajax = true;

        try {
            $content = $this->renderResults();

            $this->ajaxRender(json_encode([
                'success' => true,
                'content' => $content,
            ]));
        } catch (\Exception $e) {
            $this->ajaxRender(json_encode([
                'success' => false,
                'content' => $e->getMessage(),
            ]));
        }
    }

    private function renderResults()
    {
        $searchConfiguration = $this->get(SearchbarConfiguration::class);

        $searchDTO = new SearchDTO(
            $this->context->language->id,
            $this->search_string,
            $searchConfiguration->getPerPage()
        );

        $finder = $this->get(ProductFinder::class);
        $result = $finder->find($searchDTO);
        $viewRender = $this->get(RenderAutocomplete::class);

        return $viewRender->render($result, $this->type);
    }
}
