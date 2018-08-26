import components from './components'

const getDefaultHeaders = () => ({
  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
  'X-Requested-With': 'XMLHttpRequest',
})

const vint = () => {
  const autoInit = () => {
    const elements = document.querySelectorAll('[data-vint-auto-init]')

    for (let i = 0; i < elements.length; i++) {
      const componentName = elements[i].dataset['vintAutoInit']

      if (components[componentName]) {
        Object.defineProperty(elements[i], componentName, {
          value: new components[componentName](elements[i]),
          writable: false,
          enumerable: false
        })
      }
    }
  }

  // Define o objeto "vint" como global.
  Object.defineProperty(window, 'vint', {
    value: {
      ...components,
      autoInit,
      request: {
        getDefaultHeaders
      }
    },
    writable: false,
    enumerable: false
  })
}

const app = () => {
  // Inicia a aplicação do VINT.
  vint()

  // Auto inicializa os componentes MDC.
  window.mdc.autoInit()

  // Auto inicializa os componentes do VINT.
  window.vint.autoInit()
}

window.addEventListener('load', app)
