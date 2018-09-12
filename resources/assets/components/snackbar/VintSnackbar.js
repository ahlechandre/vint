import { MDCSnackbar } from '@material/snackbar'

export default class VintSnackbar {

  static constants = {
    MESSAGE_DATASET: 'vintSnackbarMessage',
    ACTION_TEXT_DATASET: 'vintSnackbarActionText',
  }

  constructor(element) {
    this.state = {
      element,
      message: element.dataset[VintSnackbar.constants.MESSAGE_DATASET],
      actionText: element.dataset[VintSnackbar.constants.ACTION_TEXT_DATASET],
    }
    this.render()
  } 

  render() {
    const {
      message,
      actionText,
      element
    } = this.state
    const snackbar = new MDCSnackbar(element)    
    snackbar.show({
      message,
      actionText,
      actionHandler: () => {}
    })
  } 
}
