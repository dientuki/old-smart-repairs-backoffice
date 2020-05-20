export function sort(element) {
  if (element === null) {
    return;
  }

  element.addEventListener('change', (e) => {
    const url = new URL(window.location);

    url.searchParams.set(e.target.dataset.param, e.target.value);
    window.location.href = url.href;
  });
}