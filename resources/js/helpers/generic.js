import { isObject } from './validators';

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