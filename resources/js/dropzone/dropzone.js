import Dropzone from 'dropzone';
import { storageAvailable } from '../helpers/validators';

export default class DropzoneMiddleware {

  constructor(query) {
    const previewTemplate = document.querySelector('.template-dropzone').content.cloneNode(true);

    Dropzone.autoDiscover = false;
    DropzoneMiddleware.loadOlds();

    this.element = document.querySelector(query);

    this.config = {
      clickable: '.fileinput-button',
      maxFiles: this.element.dataset.maxfiles === undefined ? null : parseInt(this.element.dataset.maxfiles, 10),
      // max file size in MB
      maxFilesize: 2,
      parallelUploads: 1,
      previewTemplate: previewTemplate.querySelector('.template').outerHTML,
      previewsContainer: '#previews',
      url: this.element.dataset.url
    };

    this.setHeader();
    this.setEvents();
    DropzoneMiddleware.removeDB();

    setTimeout(() => {
      if (this.config.maxFiles !== null) {
        if (document.querySelectorAll('.db-image').length === this.config.maxFiles) {
          window.dropzone.removeEventListeners();
        }
        if (document.querySelectorAll('.old-image').length === this.config.maxFiles) {
          window.dropzone.removeEventListeners();
        }
      }
    }, 100);

    return new Dropzone(document.body, this.config);
  }

  setHeader() {
    const form = this.element.closest('form');

    this.config.headers = { 'X-CSRF-TOKEN': form.querySelector('input[name=_token]').value };
  }

  setEvents() {

    this.config.success = (file, response) => {
      file.previewTemplate.querySelector('input.image').setAttribute('value', response.name);
      window.requestAnimationFrame(() => {
        if (storageAvailable('localStorage') === true) {
          localStorage.setItem(response.name, file.dataURL);
        }
      });
    };

    this.config.maxfilesreached = () => {
      window.dropzone.removeEventListeners();
    };

    this.config.removedfile = (file) => {
      if (file.previewElement !== null && file.previewElement.parentNode !== null) {
        file.previewElement.parentNode.removeChild(file.previewElement);
        window.dropzone.setupEventListeners();
      }

      // eslint-disable-next-line no-underscore-dangle
      return window.dropzone._updateMaxFilesReachedClass();
    };
  }

  static loadOlds() {
    if (storageAvailable('localStorage') === false) {
      return;
    }

    window.requestAnimationFrame(() => {
      document.querySelectorAll('.old-image').forEach((element) => {
        const image = localStorage.getItem(element.querySelector('input').value);

        element.querySelector('.thumbnail').setAttribute('src', image);
        element.querySelector('.delete').addEventListener('click', () => {
          element.remove();
          window.dropzone.setupEventListeners();
        });
      });
    });
  }

  static removeDB() {
    document.querySelectorAll('.db-image').forEach((element) => {
      element.querySelector('.delete').addEventListener('click', () => {
        const input = document.createElement('INPUT');

        input.setAttribute('name', 'delete[]');
        input.setAttribute('type', 'hidden');
        input.setAttribute('value', element.querySelector('input').value);

        window.requestAnimationFrame(() => {
          element.parentNode.append(input);
          element.remove();
          window.dropzone.setupEventListeners();
        });
      });
    });
  }

}