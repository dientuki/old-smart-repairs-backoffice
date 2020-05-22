export function filter(elements) {
  if (elements.length === 0) {
    return;
  }

  elements.forEach((element) => {
    element.addEventListener('change', (e) => {

      /* eslint-disable sort-vars */
      const url = new URL(window.location),
        param = e.target.dataset.param,
        params = url.searchParams,
        value = e.target.value;

      if (value === 'reset') {
        params.delete(param);
      } else {
        params.set(param, value);
      }

      window.location.href = url.href;
    });
  });

}