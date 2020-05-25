import { expandableItem } from './sidebar/sidebar';
__webpack_public_path__ = `${window.location.protocol}//${window.location.host}/admin/dist/`;

expandableItem(document.querySelectorAll('.must-expand'));

if (document.querySelector('.sort') !== null) {
  import(/* webpackChunkName: "orderSort" */ './order/sort').then((module) => {
    module.sort(document.querySelector('.sort'));
  });
}

// Load the preventDelete modal
if (document.querySelectorAll('.modalOpener').length > 0) {
  import(/* webpackChunkName: "preventDelete" */ './preventDelete/preventDelete').then((module) => {
    module.preventDelete();
  });
}