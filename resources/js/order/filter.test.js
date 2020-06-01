import { filter } from './filter';

describe('filter', () => {
  test('returns false if null is given', () => {
    expect(filter(document.querySelectorAll('div'))).toBe(false);
  });
});