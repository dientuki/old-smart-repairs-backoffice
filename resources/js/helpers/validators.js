export function storageAvailable(type) {
  try {
    const storage = window[type],
      x = '__storage_test__';

    storage.setItem(x, x);
    storage.removeItem(x);
    return true;
  } catch (e) {
    return false;
  }
}

export function isValidUrl(url) {
  try {
    // eslint-disable-next-line no-unused-vars
    const test = new URL(url);

    return true;
  } catch (_) {
    return false;
  }
}

/* eslint-disable no-mixed-operators */
/**
 * Check if a var is an object
 * Taken from https://github.com/jashkenas/underscore/blob/master/underscore.js#L1354
 * @param obj
 * @returns {boolean}
 */
export function isObject(obj) {
  const type = typeof obj;

  return type === 'function' || type === 'object' && Boolean(obj);
}