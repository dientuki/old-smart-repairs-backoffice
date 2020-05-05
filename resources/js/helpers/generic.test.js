import { isObject, mergeObjects } from './generic';

describe('isObject', () => {
  test('using a string', () => {
    expect(isObject('hola')).toEqual(false);
  });

  test('using a json', () => {
    expect(isObject({ a: 1 })).toEqual(true);
  });
});

describe('mergeObjects', () => {
  test('returns a simple merged object', () => {
    const objectA = {
        a: 1,
        b: 1
      },
      objectB = {
        b: 2,
        c: 3
      },
      result = {
        a: 1,
        b: 2,
        c: 3
      };

    expect(mergeObjects(objectA, objectB)).toEqual(result);
  });

  test('returns a complex merged object', () => {
    const objectA = {
        a: 1,
        b: {
          a: 1,
          b: 2
        }
      },
      objectB = {
        b: { j: 3 },
        c: 3
      },
      result = {
        a: 1,
        b: {
          a: 1,
          b: 2,
          j: 3
        },
        c: 3
      };

    expect(mergeObjects(objectA, objectB)).toEqual(result);
  });
});