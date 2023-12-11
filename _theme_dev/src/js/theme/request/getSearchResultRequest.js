/**
 * Creates a search result request function using the provided URL and payload.
 * @param {string} url - The URL for the search result request.
 * @param {Object} payload - The payload to be included in the request (optional).
 * @returns {Object} - An object containing the getRequest function.
 */
import useHttpRequest from '@js/utils/http/useHttpRequest';
import requestCacheMiddleware from './requestCacheMiddleware';

/**
 * Destructures functions from requestCacheMiddleware for caching purposes.
 */
const {
  getCacheKey, isCached, setCache, getCache,
} = requestCacheMiddleware();

/**
 * Creates a search result request function.
 * @param {string} url - The URL for the search result request.
 * @param {Object} payload - The payload to be included in the request (optional).
 * @param {string} payload.type - The type of search result to retrieve (desktop or mobile).
 * @param {string} payload.s - The search query.
 * @param {string} payload.ajax - required for the request to be processed by the search controller.
 * @returns {Object} - An object containing the getRequest function.
 */
const getSearchResultRequest = (url, payload = {}) => {
  /**
   * Initializes the HTTP request using useHttpRequest.
   */
  const { request } = useHttpRequest(url);

  /**
   * Retrieves search result data or makes a new request if not cached.
   * @returns {Promise} - A promise that resolves with the search result data.
   */
  const getRequest = () => new Promise((resolve) => {
    const cacheKey = getCacheKey(url, payload);

    /**
     * Checks if the result is cached and resolves with the cached data.
     */
    if (isCached(cacheKey)) {
      resolve(getCache(cacheKey));
      return;
    }

    /**
     * Makes a new HTTP request, caches the result, and resolves with the data.
     */
    request
      .query(payload)
      .post()
      .json((resp) => {
        setCache(cacheKey, resp);
        resolve(resp);
      });
  });

  return {
    getRequest,
  };
};

export default getSearchResultRequest;
