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