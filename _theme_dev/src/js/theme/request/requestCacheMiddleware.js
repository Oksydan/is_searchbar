/**
 * Creates a middleware for request caching.
 * @returns {Object} - An object containing cache-related functions.
 */
const requestCacheMiddleware = () => {
  /**
   * In-memory cache using a Map.
   * @type {Map}
   */
  const cache = new Map();

  /**
   * Checks if a key is present in the cache.
   * @param {string} key - The key to check in the cache.
   * @returns {boolean} - True if the key is cached, false otherwise.
   */
  const isCached = (key) => cache.has(key);

  /**
   * Retrieves the cached value associated with a key.
   * @param {string} key - The key for which to retrieve the cached value.
   * @returns {*} - The cached value or undefined if not found.
   */
  const getCache = (key) => cache.get(key);

  /**
   * Sets a key-value pair in the cache.
   * @param {string} key - The key to set in the cache.
   * @param {*} value - The value to associate with the key in the cache.
   */
  const setCache = (key, value) => cache.set(key, value);

  /**
   * Removes a key-value pair from the cache.
   * @param {string} key - The key to remove from the cache.
   */
  const removeCache = (key) => cache.delete(key);

  /**
   * Clears the entire cache, removing all key-value pairs.
   */
  const clearCache = () => cache.clear();

  /**
   * Generates a cache key based on the provided URL and payload.
   * @param {string} url - The URL used to generate the cache key.
   * @param {Object} payload - The payload used to generate the cache key.
   * @returns {string} - The generated cache key.
   */
  const getCacheKey = (url, payload) => {
    const payloadString = JSON.stringify(payload);
    return `${url}-${payloadString}`;
  };

  return {
    isCached,
    getCache,
    setCache,
    removeCache,
    clearCache,
    getCacheKey,
  };
};

export default requestCacheMiddleware;
