import { MDCDialog } from '@material/dialog'

class DialogActivation {

  /**
   * @var {Object}
   */
  static classes = {
    COMPONENT: 'dialog-activation',
    DIALOG: 'dialog',
  }

  /**
   * @var {Object}
   */
  static constants = {
    COMPONENT_NAME: 'DialogActivation',
    DIALOG_ACTIVATION_DATASET: 'dialogActivation'
  }

  /**
   * 
   * @param {HTMLElement} element 
   */
  constructor(element) {
    const dialogId = element.dataset[DialogActivation.constants.DIALOG_ACTIVATION_DATASET]
    this.state = {
      dialog: document.querySelector(`.${DialogActivation.classes.DIALOG}#${dialogId}`)
    }

    if (!this.state.dialog) {
      return
    }
    this.state = {
      ...this.state,
      mdcDialog: new MDCDialog(this.state.dialog)
    }

    element.addEventListener('click', event => {
      this.state.mdcDialog.lastFocusedTarget = event.target;
      this.state.mdcDialog.show();
    })
  }
}

export default DialogActivation
