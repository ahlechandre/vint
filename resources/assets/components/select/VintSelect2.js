import $ from 'jquery'
import 'select2'

class VintSelect2 {
  /**
   * @var {Object}
   */
  static classes = {
    COMPONENT: 'select--select2',
    SELECT: 'select__native-control',
  }
  
  static constants = {
    PLACEHOLDER_DATASET: 'vintSelect2Placeholder'
  }

  /**
   * 
   * @param {HTMLElement} element 
   */
  constructor(element) {

    if (!element || !element.classList.contains(VintSelect2.classes.COMPONENT)) {
      return console.warn('Please, add a valid element for Select2.')
    }

    this.state = {
      element,
      select: element.querySelector(`.${
        VintSelect2.classes.SELECT
      }`),
    }
  }
  
  /**
   * 
   * @param {null|Object} options 
   */
  render(options) {
    $(this.state.select).select2({
      ...(options || this.state.options),
      placeholder: this.state.element.dataset[VintSelect2.constants.PLACEHOLDER_DATASET]
    })
  }  
}

export default VintSelect2
