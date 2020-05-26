export function alertClose(element) {
  if (element !== null) {
    element.addEventListener('click', (e) => {
      const animated = e.target.closest('.animated');
      animated.classList.remove(animated.dataset['open'])
      animated.classList.add(animated.dataset['close']);
    });
  }
}