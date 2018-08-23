import { MDCMenu } from '@material/menu'

class Menu {
  /**
   * @param {Object} props
   * @return {undefined}
   */
  constructor(props) {

    this.state = {
      element: props.element,
    }
  }

  /**
   * @return {undefined}
   */
  render() {
    const menuEl = this.state.element.querySelector('.mdc-menu')
    const menu = new MDCMenu(menuEl)
    const button = this.state.element.querySelector('button')
    button.addEventListener('click', event => {
      menu.open = !menu.open
    })
  }
}
export default Menu
