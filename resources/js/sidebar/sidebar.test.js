import { expandableItem } from './sidebar';

describe('expandableItem', () => {
  test('returns false if null is given', () => {
    expect(expandableItem(document.querySelectorAll('iframe'))).toBe(false);
  });

  test('open & close', () => {
    const div = document.createElement('div'),
      li = document.createElement('div');

    div.classList.add('must-expand');
    li.classList.add('main-nav__item');

    li.appendChild(div);
    document.body.appendChild(li);

    expandableItem(document.querySelectorAll('.must-expand'));

    div.click();
    expect(li.classList.contains('expanded')).toBe(true);

    div.click();
    expect(li.classList.contains('expanded')).toBe(false);
  });

});