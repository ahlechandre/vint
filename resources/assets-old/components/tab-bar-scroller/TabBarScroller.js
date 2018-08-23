import { MDCTabBarScroller } from '@material/tabs';

class TabBarController {

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
   * 
   * @return {undefined}
   */
  render() {
    // Instancia o novo componente.
    new MDCTabBarScroller(this.state.element);
  }
}

export default TabBarController
