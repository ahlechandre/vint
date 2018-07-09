import { MDCTextField } from '@material/textfield'

class TextField {

  /**
   * @param {Object} props
   * @return {undefined}
   */
  constructor(props) {
    this.state = {
      element: props.element
    }
  }

  /**
   * @return {undefined}
   */
  render() {
    // Instanciando o componente.
    new MDCTextField(this.state.element)
  }
}
export default TextField
