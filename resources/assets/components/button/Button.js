import { MDCRipple } from '@material/ripple'

class Button {

  /**
   * @param {Object} props
   * @return {undefined}
   */
  constructor(props) {
    this.state = {
      element: props.element,
    }
  }

  /**
   * @return {undefined}
   */
  render() {
    // Instanciando o componente.
    new MDCRipple(this.state.element)
  }
}

export default Button
