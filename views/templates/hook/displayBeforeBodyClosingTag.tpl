{extends file='components/offcanvas.tpl'}

{block name='offcanvas_extra_attribues'}id="search_dialog"{/block}
{block name='offcanvas_extra_class'}js-search-offcanvas search-offcanvas offcanvas-start{/block}
{block name='offcanvas_title'}{l s='Search for product' d='Shop.Falcon.Global'}{/block}
{block name='offcanvas_header_extra_class'}border-bottom{/block}
{block name='offcanvas_body_extra_class'}p-0 overflow-hidden d-flex flex-column{/block}
{block name='offcanvas_body'}
  <form class="search-form js-search-form-mobile"
        data-search-controller-url="{$ajax_search_url}"
        method="get"
        action="{$search_controller_url}"
        autocomplete="off"
  >
    <div class="search-form__form-group search-form__form-group--offcanvas">
      <input type="hidden" name="controller" value="search">
      <input class="js-search-input-mobile search-form__input form-control"
             placeholder="{l s='Enter what you are looking for' d='Modules.Issearchbar.Form'}"
             type="text"
             name="s"
             autocomplete="off"
             value="{$search_string}">
      <button type="submit" class="search-form__btn btn">
        <span class="material-icons d-block">search</span>
      </button>
    </div>

  </form>
  <div class="js-search-result-mobile search-result overflow-auto"></div>
{/block}
