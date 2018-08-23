import Components from './components'

const app = () => {
  // Auto inicializa os componentes MDC.
  window.mdc.autoInit()

  // Inicializa os componentes do VINT.
  Components()
}

window.addEventListener('load', app)
