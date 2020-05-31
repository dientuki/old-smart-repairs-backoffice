import { sort } from './sort';

describe('sort', () => {
  test('returns false if null is given', () => {
    expect(sort(null)).toBe(false);
  });

  /*
  test('change order', () => {
    const select = document.createElement('select'),
      asc = document.createElement('option'),
      desc = document.createElement('option');

    sinon.stub(window.location, 'assign');

    select.classList.add('sort');
    select.dataset.param = 'order';

    asc.value = 'asc';
    desc.value = 'desc';

    select.appendChild(asc);
    select.appendChild(desc);

    document.body.appendChild(select);

    sort(document.querySelector('.sort'));

    select.dispatchEvent(new Event('change'));
  });
  */
});