import { MDCTemporaryDrawer, MDCPersistentDrawer } from '@material/drawer'

class DrawerActivation {

  /**
   * @var {Object}
   */
  static classes = {
    COMPONENT: 'drawer-activation',
    DRAWER: 'drawer',
    DRAWER_TEMPORARY: 'mdc-drawer--temporary',
    DRAWER_PERSISTENT: 'mdc-drawer--persistent'
  }

  /**
   * @var {Object}
   */
  static constants = {
    COMPONENT_NAME: 'DrawerActivation',
    DRAWER_ACTIVATION_DATASET: 'drawerActivation'
  }

  /**
   * 
   * @param {HTMLElement} element 
   */
  constructor(element) {
    const drawerId = element.dataset[DrawerActivation.constants.DRAWER_ACTIVATION_DATASET]
    const drawer = document.querySelector(`.${DrawerActivation.classes.DRAWER}#${drawerId}`)
    this.state = {
      drawer,
      isPersistent: drawer.classList.contains(DrawerActivation.classes.DRAWER_PERSISTENT),
      isTemporary: drawer.classList.contains(DrawerActivation.classes.DRAWER_TEMPORARY)
    }

    if (!this.state.drawer) {
      return
    }
    this.state = {
      ...this.state,
      mdcDrawer: this.state.isPersistent ?
        new MDCPersistentDrawer(this.state.drawer) :
        new MDCTemporaryDrawer(this.state.drawer)
    }

    element.addEventListener('click', () => {
      this.state.mdcDrawer.open = !this.state.mdcDrawer.open
    })
  }
}

export default DrawerActivation
