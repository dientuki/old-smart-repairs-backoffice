import { expandableItem } from './sidebar/sidebar';
__webpack_public_path__ = `${window.location.protocol}//${window.location.host}/admin/dist/`;

expandableItem(document.querySelectorAll('.must-expand'));

if (document.querySelector('.sort') !== null) {
  import(/* webpackChunkName: "orderSort" */ './order/sort').then((module) => {
    module.sort(document.querySelector('.sort'));
  });
}