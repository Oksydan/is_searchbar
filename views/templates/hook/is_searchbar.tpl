<div class="header-top__block header-top__block--search col">

	<div id="_desktop_search_from" class="d-none d-md-block">
		<form class="search-form js-search-form" data-search-controller-url="{$ajax_search_url}" method="get" action="{$search_controller_url}">
			<div class="search-form__form-group">
				<input type="hidden" name="controller" value="search">
				<input class="js-search-input search-form__input form-control"
					   placeholder="{l s='Enter what you are looking for' d='Modules.Issearchbar.Form'}"
					   type="text"
					   name="s"
					   value="{$search_string}">
				<button type="submit" class="search-form__btn btn">
					<span class="material-icons">search</span>
				</button>
			</div>
		</form>
	</div>

	<a role="button" class="search-toggler header-top__link d-block d-md-none" data-toggle="modal" data-target="#saerchModal">
		<div class="header-top__icon-container">
			<span class="header-top__icon material-icons">search</span>
		</div>
	</a>

</div>
