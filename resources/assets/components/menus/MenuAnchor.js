import { MDCMenu } from '@material/menu'

class MenuAnchor {

  /**
   * @var {Object}
   */
  static classes = {
    COMPONENT: 'menu-anchor',
    BUTTON: 'menu-anchor__button',
    MENU: 'menu-anchor__menu',
  }

  /**
   * @var {Object}
   */
  static constants = {
    COMPONENT_NAME: 'MenuAnchor'
  }

  /**
   * 
   * @param {HTMLElement} element 
   */
  constructor(element) {
    this.state = {
      button: element.querySelector(`.${MenuAnchor.classes.BUTTON}`),
      menu: element.querySelector(`.${MenuAnchor.classes.MENU}`)
    }

    if (!this.state.button || !this.state.menu) {
      return
    }
    this.state = {
      ...this.state,
      mdcMenu: new MDCMenu(this.state.menu)
    }

    this.state.button.addEventListener('click', event => {
      this.state.mdcMenu.open = !this.state.mdcMenu.open
    })
  }
}

export default MenuAnchor
