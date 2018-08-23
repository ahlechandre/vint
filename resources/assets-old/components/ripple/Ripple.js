import { MDCRipple } from '@material/ripple'

class Ripple {

  /**
   * @param element
   * @return {undefined}
   */
  static render(element) {
    // Instanciando o componente.
    new MDCRipple(element)
  }
}

export default Ripple
