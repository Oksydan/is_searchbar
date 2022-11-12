const init = () => {
    const searchInput = document.querySelector('.js-search-input');
    const getAjaxUrlFromElement = (el) => (el && el.length ? el.getAttribute('data-search-controller-url') : null);
    const ajaxUrl = getAjaxUrlFromElement(document.querySelector('[data-search-controller-url]'));
    const body = document.querySelector('body');
    const inputForm = searchInput.closest('.js-search-form');
    const backdrop = document.createElement('div');
    backdrop.classList.add('search-backdrop');
    body.appendChild(backdrop);

    if (!ajaxUrl) {
        return;
    }

    const Search = new SearchInput({
        searchUrl: ajaxUrl,
        input: searchInput,
        appendTo: '.js-search-form',
        perPage: 6,
        onResult: (e) => {
            body.classList.add('search-result-open');
            prestashop.pageLazyLoad.update();
        },
        onRemoveResult: (e) => {
            body.classList.remove('search-result-open');
        },
        beforeSend: (e) => {
            // console.log('BEFORE SEND ' + e);
        },
        onType: (e) => {
            // console.log('ON TYPE ' + e);
        }
    });

    body.addEventListener('click', ({ target }) => {
        if (body.classList.contains('search-result-open') && target != inputForm && !target.closest('.js-search-form')) {
            body.classList.remove('search-result-open');
            Search.removeResults();
        }
    })

};


const SearchInput = function({
    searchUrl,
    input,
    onType,
    onResult,
    beforeSend,
    onRemoveResult,
    perPage,
    appendTo,
    min,
    timeout
}) {
    this.searchUrl = searchUrl;
    this.input = input;
    this.appendTo = document.querySelector(appendTo);
    this.onType = onType || (() => {});
    this.onResult = onResult || (() => {});
    this.onRemoveResult = onRemoveResult || (() => {});
    this.beforeSend = beforeSend || (() => {});
    this.min = min || 3;
    this.perPage = perPage || 10;
    this.timeout = timeout || 300;
    this.resultBox = null;

    const cache = {};

    let typeTimeout = null;
    const resultBoxClass = 'js-search-result';

    this.input.addEventListener('keyup', () => {
        if(typeTimeout) {
            clearTimeout(typeTimeout);
        }

        const str = getInputString();

        this.onType({
            input: this.input,
            appendTo: this.appendTo,
            s: str
        })

        if(!handleResultIfStringMatchMinLength(str)) {
            resetResultIfExits();
            return;
        }

        typeTimeout = setTimeout(function() {
            handleAjax(str);
        }, this.timeout)
    })

    const displayResult = (data, str) => {
        resetResultIfExits();

        const element = document.createElement('div');
        element.classList.add(resultBoxClass);
        element.innerHTML = data.content;

        this.appendTo.appendChild(element);
        this.resultBox = document.querySelector('.' + resultBoxClass);

        this.onResult({
            input: this.input,
            appendTo: this.appendTo,
            s: str,
            data: data
        });
    }

    const handleAjax = (str) => {
        this.beforeSend({
            input: this.input,
            appendTo: this.appendTo,
            s: str
        });

        if (typeof cache[str] !== 'undefined') {
            displayResult(cache[str], str);

            return;
        }

        let data = {
            s: str,
            perPage: this.perPage,
            ajax: 1,
        }

        data = Object.keys(data).map(key => encodeURIComponent(key) + '=' + encodeURIComponent(data[key])).join('&')

        fetch(this.searchUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: data,
        })
        ///ISSUE WITH RESPONSE.JSON() AND HTML CONTENT INSIDE JSON
        .then(response => response.text())
        .then(data => {
            data = JSON.parse(data);
            cache[str] = data;

            displayResult(data, str);
        })
        .catch(err => console.error(err))
    }

    const handleResultIfStringMatchMinLength = (str) => {
        return str.length >= this.min;
    }

    const getInputString = () => {
        return this.input.value;
    }

    this.removeResults = () => {
        resetResultIfExits();
    }

    const resetResultIfExits = () => {
        if(this.resultBox) {
            this.onRemoveResult();
            this.resultBox.remove();
        }
    }
}

document.addEventListener('DOMContentLoaded', init);
