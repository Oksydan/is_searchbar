<div class="header-top__block header-top__block--search col">

	<div class="d-none d-md-block">
		<form
      class="search-form js-search-form"
      data-search-controller-url="{$ajax_search_url}"
      method="get"
      action="{$search_controller_url}"
      autocomplete="off"
    >
			<div class="search-form__form-group">
				<input type="hidden" name="controller" value="search">
				<input class="js-search-input search-form__input form-control"
					   placeholder="{l s='Enter what you are looking for' d='Modules.Issearchbar.Form'}"
					   type="text"
					   name="s"
               autocomplete="off"
					   value="{$search_string}"
        >
				<button type="submit" class="search-form__btn btn">
					<span class="material-icons d-block">search</span>
				</button>
			</div>

      <div class="js-search-result search-result"></div>
		</form>
	</div>

	<a
    href="#search_dialog"
    role="button"
    class="search-toggler header-top__link d-md-none"
    data-bs-toggle="offcanvas"
    data-bs-target="#search_dialog"
  >
		<div class="header-top__icon-container">
			<span class="header-top__icon material-icons">search</span>
		</div>
	</a>

</div>
