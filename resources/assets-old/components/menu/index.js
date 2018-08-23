import Menu from './Menu'

/**
 * @return {Object}
 */
const MenuContainer = () => ({
  selector: '.mdc-menu-anchor',
  init: element => (new Menu({
    element
  })).render()
})

export {
  Menu,
  MenuContainer
}
