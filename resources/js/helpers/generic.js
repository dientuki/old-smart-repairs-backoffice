/* eslint-disable prefer-const */
export function mergeObjects(defaults, custom) {
  if (typeof defaults === 'undefined') {
    throw new Error('"defaults" object must be given');
  }
  if (typeof defaults !== 'object' || (typeof custom !== 'undefined' && typeof custom !== 'object')) {
    throw new Error('Args must be an object');
  }

  let final = {},
    propertyName;

  for (propertyName in defaults) {
    final[propertyName] = defaults[propertyName];
  }

  for (propertyName in custom) {
    final[propertyName] = custom[propertyName];
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