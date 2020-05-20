export function expandableItem(elements) {
  if (elements.lenght === 0) {
    return;
  }

  Array.from(elements).forEach((element) => {
    element.addEventListener('click', (event) => {
      if (event.target.closest('.active') === null) {
        event.target.closest('.main-nav__item').classList.toggle('expanded');
      }
    });
  });
}