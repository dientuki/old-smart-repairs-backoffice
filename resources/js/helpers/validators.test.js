import * as Validators from './validators';

describe('isObject', () => {
  test('using a string', () => {
    expect(Validators.isObject('hola')).toEqual(false);
  });

  test('using a json', () => {
    expect(Validators.isObject({ a: 1 })).toEqual(true);
  });
});

describe('isValidUrl', () => {
  test('using a string', () => {
    expect(Validators.isValidUrl('hola')).toEqual(false);
  });

  test('using an URL', () => {
    expect(Validators.isValidUrl('https://www.google.com')).toEqual(true);
  });
});

describe('storageAvailable', () => {
  test('testing localStorage', () => {
    expect(Validators.storageAvailable('localStorage')).toEqual(true);
  });

  test('testing sessionStorage', () => {
    expect(Validators.storageAvailable('sessionStorage')).toEqual(true);
  });

  test('testing anotherStorage', () => {
    expect(Validators.storageAvailable('anotherStorage')).toEqual(false);
  });   
});