import { MDCTemporaryDrawer } from '@material/drawer'

class DrawerTemporary {
  
  /**
   * @var {Object}
   */
  static constants = {
    TOGGLE_BUTTON_ID: 'top-app-bar-menu',
  }

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
   * @return {HTMLElement}
   */
  getToggleButtonElements() {
    return document.querySelectorAll(`#${
      DrawerTemporary.constants.TOGGLE_BUTTON_ID
    }`) 
  }
  
  /**
   * @return {undefined}
   */
  render() {
    // Instancia o componente.
    const drawer = new MDCTemporaryDrawer(this.state.element)
    const toggleButtons = this.getToggleButtonElements()

    if (!toggleButtons) {
      return
    }

    for (let i = 0; i < toggleButtons.length; i++) {
      toggleButtons[i].addEventListener('click', event => {
        event.preventDefault()
        drawer.open = !drawer.open
      })      
    }
  }
}

export default DrawerTemporary
