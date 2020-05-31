import { alertClose } from './alertClose';

describe('alertClose', () => {
  test('returns false if null is given', () => {

    expect(alertClose(null)).toBe(false);
  });

  test('close alert', () => {
    const button = document.createElement('button'),
      wrapper = document.createElement('div');

    wrapper.dataset.open = 'pulse';
    wrapper.dataset.close = 'backOutUp';
    wrapper.classList.add('animated', wrapper.dataset.open);
    button.classList.add('alert-close');

    wrapper.appendChild(button);
    document.body.appendChild(wrapper);

    alertClose(document.querySelector('.alert-close'));

    button.click();
    expect(wrapper.className).toBe(`animated ${wrapper.dataset.close}`);
  });
});