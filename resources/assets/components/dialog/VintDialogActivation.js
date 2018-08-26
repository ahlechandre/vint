import { MDCDialog } from '@material/dialog'

class VintDialogActivation {

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
    DIALOG_ACTIVATION_DATASET: 'dialogActivation'
  }

  /**
   * 
   * @param {HTMLElement} element 
   */
  constructor(element) {

    if (!element || !element.classList.contains(VintDialogActivation.classes.COMPONENT)) {
      return console.warn('Please, add a valid element for Dialog Activation.')
    }
    const dialogId = element.dataset[VintDialogActivation.constants.DIALOG_ACTIVATION_DATASET]
    this.state = {
      dialog: document.querySelector(`.${VintDialogActivation.classes.DIALOG}#${dialogId}`)
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

export default VintDialogActivation
