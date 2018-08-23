import Dialog from './Dialog'

/**
 * @return {Object}
 */
const DialogContainer = () => ({
  selector: '.mdc-dialog',
  init: element => (new Dialog({
    element
  })).render()
})

export {
  Dialog,
  DialogContainer
}
