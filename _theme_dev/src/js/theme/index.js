import { DOMReady } from '@js/utils/DOM/DOMHelpers';
import useAutocomplete from './components/useAutocomplete';
import getSearchResultRequest from './request/getSearchResultRequest';

const getAjaxUrlFromElement = (el) => (el && el.length ? el.getAttribute('data-search-controller-url') : null);

const calcResultContentHeight = (content) => {
  const { top, height } = content.getBoundingClientRect();
  const windowHeight = window.innerHeight;

  if (top + height > windowHeight) {
    content.style.height = `${windowHeight - top}px`;
  } else {
    content.style.height = 'auto';
  }
};

const initDesktopSearch = () => {
  const searchInput = document.querySelector('.js-search-input');
  const searchResult = document.querySelector('.js-search-result');

  if (!searchInput || !searchResult) {
    return;
  }

  const ajaxUrl = getAjaxUrlFromElement(document.querySelector('[data-search-controller-url]'));

  const {
    init: initSearch,
    appendResult,
    showResult,
  } = useAutocomplete(
    searchInput,
    searchResult,
    {
      onSearch: async () => {
        const { getRequest } = getSearchResultRequest(ajaxUrl, {
          s: searchInput.value,
          ajax: 1,
          type: 'desktop',
        });

        try {
          const data = await getRequest();
          appendResult(data.content);
          showResult();
        } catch (e) {
          throw new Error(e);
        }
      },
      onOpenResult: (input, resultElement) => {
        document.body.classList.add('search-result-open');
        const resultContent = resultElement.querySelector('.js-search-result-content');

        if (resultContent instanceof HTMLElement) {
          calcResultContentHeight(resultContent);
        }
      },
      onCloseResult: () => {
        document.body.classList.remove('search-result-open');
      },
    },
  );

  initSearch();
};

const initMobileSearch = () => {
  const searchInput = document.querySelector('.js-search-input-mobile');
  const searchResult = document.querySelector('.js-search-result-mobile');
  const offcanvas = document.querySelector('.js-search-offcanvas');

  if (!searchInput || !searchResult) {
    return;
  }

  const ajaxUrl = getAjaxUrlFromElement(document.querySelector('[data-search-controller-url]'));

  const {
    init: initSearch,
    appendResult,
    hideResult,
    showResult,
  } = useAutocomplete(
    searchInput,
    searchResult,
    {
      hideOnBlur: false,
      onSearch: async () => {
        const { getRequest } = getSearchResultRequest(ajaxUrl, {
          s: searchInput.value,
          ajax: 1,
          type: 'mobile',
        });

        try {
          const data = await getRequest();
          appendResult(data.content);
          showResult();
        } catch (e) {
          throw new Error(e);
        }
      },
    },
  );

  if (offcanvas) {
    offcanvas.addEventListener('hidden.bs.offcanvas', () => {
      searchInput.value = '';
      hideResult();
    });
  }

  initSearch();
};

const init = () => {
  initDesktopSearch();
  initMobileSearch();
};

DOMReady(init);
