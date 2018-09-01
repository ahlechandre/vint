import { MDCDrawer } from '@material/drawer'

class VintDrawerActivation {

  /**
   * @var {Object}
   */
  static classes = {
    COMPONENT: 'drawer-activation',
    DRAWER: 'drawer',
    DRAWER_MODAL: 'mdc-drawer--modal',
  }

  /**
   * @var {Object}
   */
  static constants = {
    DRAWER_ACTIVATION_DATASET: 'drawerActivation'
  }

  /**
   * 
   * @param {HTMLElement} element 
   */
  constructor(element) {

    if (!element || !element.classList.contains(VintDrawerActivation.classes.COMPONENT)) {
      return console.warn('Please, add a valid element for Drawer Activation.')
    }
    const drawerId = element.dataset[VintDrawerActivation.constants.DRAWER_ACTIVATION_DATASET]
    const drawer = document.querySelector(`.${VintDrawerActivation.classes.DRAWER}#${drawerId}`)
    this.state = {
      drawer,
      isModal: drawer.classList.contains(VintDrawerActivation.classes.DRAWER_MODAL)
    }

    if (!this.state.drawer) {
      return
    }
    this.state = {
      ...this.state,
      mdcDrawer: this.state.isModal ?
        new MDCDrawer(this.state.drawer) :
        null
    }

    element.addEventListener('click', () => {
      this.state.mdcDrawer.open = !this.state.mdcDrawer.open
    })
  }
}

export default VintDrawerActivation
