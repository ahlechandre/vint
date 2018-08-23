import { MDCDialog } from '@material/dialog'

class Dialog {
  /**
   * @static
   */
  static datasets = {
    ACTIVATION: 'dialogActivation'
  }

  /**
   * @param {Object} props
   * @return {undefined}
   */
  constructor(props) {
    const dialog = new MDCDialog(props.element)
    
    this.state = {
      element: props.element,
      dialog
    }
    this.onActivate = this.onActivate.bind(this)
  }

  /**
   * @return {null|HTMLElement}
   */
  getActivation() {
    return document.querySelector(`#${
      this.state.element.dataset[Dialog.datasets.ACTIVATION]
    }`)
  }

  /**
   * @param {Event} event
   * @return {undefined}
   */
  onActivate(event) {
    event.preventDefault()
    this.state.dialog.lastFocusedTarget = event.target
    this.state.dialog.show()
  }

  /**
   * @return {undefined}
   */
  render() {
    // Instanciando o componente.
    const activation = this.getActivation()

    if (!activation) {
      return
    }
    activation.addEventListener('click', this.onActivate)
  }
}
export default Dialog
