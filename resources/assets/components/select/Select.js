import { MDCSelect } from '@material/select'

class Select {

  /**
   * @param element
   * @return {undefined}
   */
  static render(element) {
    // Instanciando o componente.
    new MDCSelect(element)
  }
}

export default Select
