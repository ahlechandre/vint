import LinearProgressGlobal from './LinearProgressGlobal'

// Instancia o componente de progresso global.
const linearProgressGlobal = new LinearProgressGlobal({
  element: document.querySelector('.linear-progress--global')
}).render()

export {
  linearProgressGlobal
}