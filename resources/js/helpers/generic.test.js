import * as Generic from './generic';

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

    expect(Generic.mergeObjects(objectA, objectB)).toEqual(result);
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

    expect(Generic.mergeObjects(objectA, objectB)).toEqual(result);
  });
});