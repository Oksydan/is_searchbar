
<div class="search-product">
  <a href="{$product.url}" class="text-reset">
    <div class="search-product__row row align-items-center">
      <div class="search-product__col search-product__col--img col-auto">
        {images_block webpEnabled=$webpEnabled}
          <img
            {if $product.default_image}
              data-full-size-image-url="{$product.default_image.large.url}"
              {generateImagesSources image=$product.default_image size='cart_default'}
              alt="{if !empty($product.default_image.legend)}{$product.default_image.legend}{else}{$product.name|truncate:30:'...'}{/if}"
              width="{$product.default_image.bySize.cart_default.width}"
              height="{$product.default_image.bySize.cart_default.height}"
            {else}
              src="{$urls.no_picture_image.bySize.cart_default.url}"
              alt="{$product.name|truncate:30:'...'}"
              width="{$urls.no_picture_image.bySize.cart_default.width}"
              height="{$urls.no_picture_image.bySize.cart_default.height}"
            {/if}
            class="img-fluid rounded"
          />
        {/images_block}
      </div>
      <div class="search-product__col search-product__col--content col">
        <p class="search-product__title h6 mb-1">
          {$product.name|escape:'htmlall':'UTF-8'}
        </p>

        {if $product.show_price}
          <div class="text-end">
            {if $product.has_discount}
              <span class="price price--sm price--regular me-1" aria-label="{l s='Regular price' d='Shop.Theme.Catalog'}">{$product.regular_price}</span>
            {/if}

            <span class="price price--sm" aria-label="{l s='Price' d='Shop.Theme.Catalog'}">{$product.price}</span>
          </div>
        {/if}
      </div>
    </div>
  </a>
</div>
