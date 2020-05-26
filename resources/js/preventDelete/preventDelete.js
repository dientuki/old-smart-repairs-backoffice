import Modal from 'modal-vanilla';

export function preventDelete() {
  const modalInfo = document.querySelector('#deleteModal');

  if (modalInfo === null) {
    return;
  }

  Array.from(document.querySelectorAll('.modalOpener')).forEach((form) => {
    form.addEventListener('submit', (event) => {

      const confirmModal = new Modal({
        buttons: [
          {
            attr: {
              class: 'btn btn-light',
              'data-dismiss': 'modal'
            },
            text: modalInfo.dataset.cancel,
            value: false
          },
          {
            attr: {
              class: 'btn btn-danger',
              'data-dismiss': 'modal'
            },
            text: modalInfo.dataset.confirm,
            value: true
          }
        ],
        construct: true,
        content: modalInfo.dataset.content,
        headerClose: true,
        title: modalInfo.dataset.title
      }
      );

      confirmModal.on('show', (modal) => {
        /* eslint-disable no-underscore-dangle */
        modal._html.dialog.classList.add('modal-dialog-centered');
        modal._html.header.querySelector('h4').outerHTML =
          modal._html.header.querySelector('h4').outerHTML.replace(/h4/g, 'h5');
        /* eslint-enable no-underscore-dangle */
      }).show()
        .once('dismiss', (modal, ev, button) => {
          if (button && button.value) {
            event.target.submit();
          }
        }
        );

      event.preventDefault();
    });
  });
}