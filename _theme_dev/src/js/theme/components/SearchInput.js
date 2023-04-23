function SearchInput({
  searchUrl,
  input,
  onType,
  onResult,
  beforeSend,
  onRemoveResult,
  perPage,
  appendTo,
  min,
  timeout,
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

  const getInputString = () => this.input.value;

  const handleResultIfStringMatchMinLength = (str) => str.length >= this.min;

  const resetResultIfExits = () => {
    if (this.resultBox) {
      this.onRemoveResult();
      this.resultBox.remove();
    }
  };

  const displayResult = (data, str) => {
    resetResultIfExits();

    const element = document.createElement('div');
    element.classList.add(resultBoxClass);
    element.innerHTML = data.content;

    this.appendTo.appendChild(element);
    this.resultBox = document.querySelector(`.${resultBoxClass}`);

    this.onResult({
      input: this.input,
      appendTo: this.appendTo,
      s: str,
      data,
    });
  };

  const handleAjax = (str) => {
    this.beforeSend({
      input: this.input,
      appendTo: this.appendTo,
      s: str,
    });

    if (typeof cache[str] !== 'undefined') {
      displayResult(cache[str], str);

      return;
    }

    let data = {
      s: str,
      perPage: this.perPage,
      ajax: 1,
    };

    data = Object.keys(data).map((key) => `${encodeURIComponent(key)}=${encodeURIComponent(data[key])}`).join('&');

    fetch(this.searchUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: data,
    })
    /// ISSUE WITH RESPONSE.JSON() AND HTML CONTENT INSIDE JSON
      .then((response) => response.text())
      .then((responseData) => {
        responseData = JSON.parse(responseData);
        cache[str] = responseData;

        displayResult(responseData, str);
      })
      .catch((err) => console.error(err)); // eslint-disable-line
  };

  this.removeResults = () => {
    resetResultIfExits();
  };

  this.input.addEventListener('keyup', () => {
    if (typeTimeout) {
      clearTimeout(typeTimeout);
    }

    const str = getInputString();

    this.onType({
      input: this.input,
      appendTo: this.appendTo,
      s: str,
    });

    if (!handleResultIfStringMatchMinLength(str)) {
      resetResultIfExits();
      return;
    }

    typeTimeout = setTimeout(() => {
      handleAjax(str);
    }, this.timeout);
  });

  return this;
}

export default SearchInput;
