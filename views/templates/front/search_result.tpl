{if $products}
  {foreach from=$products item=$product}
    {$product.name|var_dump}<br>
  {/foreach}

  {if $moreResults}
    <a href="{$moreResults}">
      {$moreResultsCount} prod more
    </a>
  {/if}
{else}
  NO RESULTS
{/if}

