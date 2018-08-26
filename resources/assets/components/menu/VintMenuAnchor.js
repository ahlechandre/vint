import { MDCMenu } from '@material/menu'

class VintMenuAnchor {

  /**
   * @var {Object}
   */
  static classes = {
    COMPONENT: 'menu-anchor',
    BUTTON: 'menu-anchor__button',
    MENU: 'menu-anchor__menu',
  }

  /**
   * 
   * @param {HTMLElement} element 
   */
  constructor(element) {

    if (!element || !element.classList.contains(VintMenuAnchor.classes.COMPONENT)) {
      return console.warn('Please, add a valid element for Menu Anchor.')
    }    
    this.state = {
      button: element.querySelector(`.${VintMenuAnchor.classes.BUTTON}`),
      menu: element.querySelector(`.${VintMenuAnchor.classes.MENU}`)
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

export default VintMenuAnchor
