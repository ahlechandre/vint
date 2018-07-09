import { MDCSnackbar } from '@material/snackbar';

class Snackbar {

  /**
   * @static {Object}
   */
  static datasets = {
    'MESSAGE': 'snackbarMessage',
    'ACTION_TEXT': 'snackbarActionText',
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
   * 
   * @return {null|string}
   */
  getMessage() {
    return this.state.element.dataset[
      Snackbar.datasets['MESSAGE']
    ]
  }

  /**
   * 
   * @return {null|string}
   */
  getActionText() {
    return this.state.element.dataset[
      Snackbar.datasets['ACTION_TEXT']
    ]
  }

  /**
   * 
   * @return {undefined}
   */
  render() {
    // Instancia o novo componente.
    const snackbar = new MDCSnackbar(this.state.element);
    snackbar.show({
      message: this.getMessage(),
      actionText: this.getActionText(),
      actionHandler: () => {},
    });
  }
}

export default Snackbar
