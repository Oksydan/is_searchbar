import useToggleDisplay from '@js/utils/display/useToggleDisplay';

/**
 * Creates an autocomplete functionality for an input element.
 * @param {HTMLElement} input - The input element to attach autocomplete functionality.
 * @param {HTMLElement} resultElement - The element where autocomplete results will be displayed.
 * @param {Object} options - Additional options for customizing the autocomplete behavior (optional).
 * @param {number} options.timeout - The delay in milliseconds before triggering a search.
 * @param {number} options.minLength - The minimum length of input to trigger a search.
 * @param {boolean} options.hideOnBlur - Flag to hide results on blur.
 * @param {Function} options.onSearch - Callback function triggered on search.
 * @param {Function} options.onOpenResult - Callback function triggered when results are displayed.
 * @param {Function} options.onCloseResult - Callback function triggered when results are hidden.
 * @throws Will throw an error if input or resultElement is not an instance of HTMLElement.
 * @returns {Object} - An object containing functions for initializing, destroying, and interacting with the autocomplete.
 */
const useAutocomplete = (input, resultElement, options = {}) => {
  /**
   * Default options and merging with user-provided options.
   * @type {Object}
   * @property {number} timeout - The delay in milliseconds before triggering a search.
   * @property {number} minLength - The minimum length of input to trigger a search.
   * @property {boolean} hideOnBlur - Flag to hide results on blur.
   * @property {Function} onSearch - Callback function triggered on search.
   * @property {Function} onOpenResult - Callback function triggered when results are displayed.
   * @property {Function} onCloseResult - Callback function triggered when results are hidden.
   */
  const _options = {
    timeout: 300,
    minLength: 3,
    hideOnBlur: true,
    onSearch: () => {},
    onOpenResult: () => {},
    onCloseResult: () => {},
    ...options,
  };

  // Input and resultElement validation
  if (!(input instanceof HTMLElement)) {
    throw new Error('input must be an instance of HTMLElement');
  }

  if (!(resultElement instanceof HTMLElement)) {
    throw new Error('resultElement must be an instance of HTMLElement');
  }

  let timeout = null;
  const { show, hide } = useToggleDisplay();

  /**
   * Checks if the autocomplete results should be displayed based on the input value.
   * @param {string} value - The input value.
   * @returns {boolean} - True if results should be displayed, false otherwise.
   */
  const shouldDisplayResult = (value) => value.length >= _options.minLength;

  /**
   * Displays the autocomplete results.
   */
  const showResult = () => {
    show(resultElement);
    _options.onOpenResult(input, resultElement);
  };

  /**
   * Hides the autocomplete results.
   */
  const hideResult = () => {
    hide(resultElement);
    _options.onCloseResult(input, resultElement);
  };

  /**
   * Handles the keyup event on the input element.
   * @param {Event} event - The keyup event.
   */
  const handleKeyUp = (event) => {
    clearTimeout(timeout);
    const { value } = event.target;

    if (!shouldDisplayResult(value)) {
      hideResult();
      return;
    }

    timeout = setTimeout(() => {
      _options.onSearch(hideResult);
    }, _options.timeout);
  };

  /**
   * Appends content to the result element.
   * @param {string} content - The content to be appended.
   */
  const appendResult = (content) => {
    resultElement.innerHTML = content;
  };

  /**
   * Removes content from the result element and hides the results.
   */
  const removeResult = () => {
    resultElement.innerHTML = '';
    hideResult();
  };

  /**
   * Handles the blur event on the input element.
   */
  const handleBlur = () => {
    if (!_options.hideOnBlur) {
      return;
    }

    setTimeout(() => {
      hideResult();
    }, 100);
  };

  /**
   * Handles the focus event on the input element.
   * @param {Event} event - The focus event.
   */
  const handleFocus = (event) => {
    const { value } = event.target;

    if (shouldDisplayResult(value)) {
      showResult();
    }
  };

  /**
   * Initializes the autocomplete functionality by attaching event listeners.
   */
  const init = () => {
    input.addEventListener('keyup', handleKeyUp);
    input.addEventListener('blur', handleBlur);
    input.addEventListener('focus', handleFocus);
    hideResult();
  };

  /**
   * Destroys the autocomplete functionality by removing event listeners and hiding results.
   */
  const destroy = () => {
    input.removeEventListener('keyup', handleKeyUp);
    input.removeEventListener('blur', handleBlur);
    input.removeEventListener('focus', handleFocus);
    hideResult();
  };

  return {
    init,
    destroy,
    appendResult,
    removeResult,
    showResult,
    hideResult,
  };
};

export default useAutocomplete;
