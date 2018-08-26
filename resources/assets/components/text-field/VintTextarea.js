import autosize from 'autosize'

class VintTextarea {

  /**
   * @var {Object}
   */
  static classes = {
    COMPONENT: 'text-field--textarea',
    TEXTAREA: 'text-field__input',
  }

  /**
   * 
   * @param {HTMLElement} element 
   */
  constructor(element) {
    
    if (!element || !element.classList.contains(VintTextarea.classes.COMPONENT)) {
      return console.warn('Please, add a valid element for Textarea.')
    }
    const textarea = element.querySelector(`.${
      VintTextarea.classes.TEXTAREA
    }`)

    if (!textarea) {
      return
    }
    // Autosize.
    autosize(textarea)
  }
}

export default VintTextarea
