import Modal from 'modal-vanilla';

export function preventDelete() {
  const modalInfo = document.querySelector('#deleteModal');

  if (modalInfo === null) {
    return;
  }

  Array.from(document.querySelectorAll('.modalOpener')).forEach((form) => {
    form.addEventListener('submit', (event) => {
      
      const confirmModal = new Modal({
          title:  modalInfo.dataset.title,
          content: modalInfo.dataset.content,
          construct: true,
          headerClose: true,
          buttons: [
            {text: modalInfo.dataset.cancel,
              value: false,
              attr: {
                'class': 'btn btn-info',
                'data-dismiss': 'modal'
              }
            },
            {text: modalInfo.dataset.confirm,
              value: true,
              attr: {
                'class': 'btn btn-danger',
                'data-dismiss': 'modal'
              }
            }
          ]
        }
      );
      confirmModal.on('show', function(confirmModal, event) {
        console.log(confirmModal._html)
        confirmModal._html.dialog.classList.add('modal-dialog-centered');
        confirmModal._html.header.querySelector('h4').outerHTML = confirmModal._html.header.querySelector('h4').outerHTML.replace(/h4/g,"h5");
      }).show().once('dismiss', function(modal, ev, button) {
        if (button && button.value) {
          event.target.submit();
        }
      });

      event.preventDefault();
    });
  });
}