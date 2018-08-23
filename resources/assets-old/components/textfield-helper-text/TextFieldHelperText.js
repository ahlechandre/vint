import { MDCTextFieldHelperText } from '@material/textfield'

class TextFieldHelperText {
  /**
   * 
   * @param {Object} props 
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
    new MDCTextFieldHelperText(this.state.element)
  }
}

export default TextFieldHelperText
