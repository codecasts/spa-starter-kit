/**
* Components are lazy-loaded
* http://router.vuejs.org/en/advanced/lazy-loading.html
*/
export const Main = (resolve) => {
  require.ensure(['../main'], () => {
    resolve(require('../main')) // eslint-disable-line global-require
  })
}

export const Singin = (resolve) => {
  require.ensure(['../components/forms/singin'], () => {
    resolve(require('../components/forms/singin')) // eslint-disable-line global-require
  })
}

export const Singup = (resolve) => {
  require.ensure(['../components/forms/singup'], () => {
    resolve(require('../components/forms/singup')) // eslint-disable-line global-require
  })
}
