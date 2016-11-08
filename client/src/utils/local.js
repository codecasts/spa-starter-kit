
/* eslint-disable no-undef */
export function localStorageSetItem(label, obj) {
  window.localStorage.setItem(label, JSON.stringify(obj))
}

export function localStorageGetItem(label) {
  const string = window.localStorage.getItem(label)
  return JSON.parse(string)
}
