<div class="search-result__content search-result__content--offcanvas js-search-result-content">
  {if $products}
    <div class="search-result__products">
      {foreach from=$products item=$product}
        {include file="module:is_searchbar/views/templates/front/product.tpl"}
      {/foreach}
    </div>

    {if !empty($moreResultsCount) && $moreResultsCount > 0}
      <div class="search-result__bottom search-result__bottom--offcanvas">
        <a href="{$moreResults}" class="btn d-block w-100 text-center btn-outline-secondary">
          {l
            s='Show the remaining %qty% products'
            sprintf=[
              '%qty%' => $moreResultsCount
            ]
            d='Modules.Issearchbar.Searchresult'
          }
        </a>
      </div>
    {/if}
  {else}
    <div class="search-result__not-result">
      {l s='There are no matching results' d='Modules.Issearchbar.Searchresult'}
    </div>
  {/if}
</div>
