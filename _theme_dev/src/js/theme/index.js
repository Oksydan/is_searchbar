import SearchInput from './components/SearchInput';

const init = () => {
  const searchInput = document.querySelector('.js-search-input');

  if (!searchInput) {
    return;
  }

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
    onResult: () => {
      body.classList.add('search-result-open');
      prestashop.pageLazyLoad.update();
    },
    onRemoveResult: () => {
      body.classList.remove('search-result-open');
    },
    beforeSend: () => {
      // console.log('BEFORE SEND ' + e);
    },
    onType: () => {
      // console.log('ON TYPE ' + e);
    },
  });

  body.addEventListener('click', ({ target }) => {
    if (body.classList.contains('search-result-open') && target !== inputForm && !target.closest('.js-search-form')) {
      body.classList.remove('search-result-open');
      Search.removeResults();
    }
  });
};

document.addEventListener('DOMContentLoaded', init);
