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

/* eslint-disable prefer-const */
/**
 * Merge two objects
 * @param defaults
 * @param custom
 * @returns {{}}
 */
export function mergeObjects(defaults, custom) {
  let final = {},
    propertyName;

  for (propertyName in defaults) {
    final[propertyName] = defaults[propertyName];
  }

  for (propertyName in custom) {
    if (isObject(custom[propertyName]) && final[propertyName] !== undefined) {
      final[propertyName] = mergeObjects(defaults[propertyName], custom[propertyName]);
    } else {
      final[propertyName] = custom[propertyName];
    }
  }

  return final;
}

export function killBubling(e, tag) {
  let element = e;

  while (element.parentNode) {
    element = element.parentNode;
    if (element.tagName === tag) {
      return element;
    }
  }
  return null;
}