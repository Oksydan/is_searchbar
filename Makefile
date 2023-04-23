build-module-zip: build-composer build-zip

build-zip:
	rm -rf is_searchbar.zip
	cp -Ra $(PWD) /tmp/is_searchbar
	rm -rf /tmp/is_searchbar/config_*.xml
	rm -rf /tmp/is_searchbar/_theme_dev/node_modules
	rm -rf /tmp/is_searchbar/.github
	rm -rf /tmp/is_searchbar/.gitignore
	rm -rf /tmp/is_searchbar/.php-cs-fixer.cache
	rm -rf /tmp/is_searchbar/.git
	mv -v /tmp/is_searchbar $(PWD)/is_searchbar
	zip -r is_searchbar.zip is_searchbar
	rm -rf $(PWD)/is_searchbar

build-composer:
	composer install --no-dev -o

