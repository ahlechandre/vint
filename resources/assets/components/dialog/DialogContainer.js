import { MDCDialog } from '@material/dialog'

class DialogContainer {

  /**
   * @var {Object}
   */
  static classes = {
    COMPONENT: 'dialog-container',
    ACTIVATION: 'dialog-container__activation',
    DIALOG: 'dialog-container__dialog',
  }

  /**
   * @var {Object}
   */
  static constants = {
    COMPONENT_NAME: 'DialogContainer'
  }

  /**
   * 
   * @param {HTMLElement} element 
   */
  constructor(element) {
    this.state = {
      activation: element.querySelector(`.${DialogContainer.classes.ACTIVATION}`),
      dialog: element.querySelector(`.${DialogContainer.classes.DIALOG}`)
    }

    if (!this.state.activation || !this.state.dialog) {
      return
    }
    this.state = {
      ...this.state,
      mdcDialog: new MDCDialog(this.state.dialog)
    }

    this.state.activation.addEventListener('click', event => {
      this.state.mdcDialog.lastFocusedTarget = event.target;
      this.state.mdcDialog.show();
    })
  }
}

export default DialogContainer
