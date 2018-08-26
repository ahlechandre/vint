import { MDCDialog } from '@material/dialog'

class VintDialogContainer {

  /**
   * @var {Object}
   */
  static classes = {
    COMPONENT: 'dialog-container',
    ACTIVATION: 'dialog-container__activation',
    DIALOG: 'dialog-container__dialog',
  }


  /**
   * 
   * @param {HTMLElement} element 
   */
  constructor(element) {

    if (!element || !element.classList.contains(VintDialogContainer.classes.COMPONENT)) {
      return console.warn('Please, add a valid element for Dialog Container.')
    }    
    this.state = {
      activation: element.querySelector(`.${VintDialogContainer.classes.ACTIVATION}`),
      dialog: element.querySelector(`.${VintDialogContainer.classes.DIALOG}`)
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

export default VintDialogContainer
