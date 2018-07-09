import Snackbar from './Snackbar'

const SnackbarContainer = () => ({
  selector: '.mdc-snackbar',
  init: element => (new Snackbar({
    element
  })).render()
})

export {
  Snackbar,
  SnackbarContainer
}
