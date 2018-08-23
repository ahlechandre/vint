import TextField from './TextField'

/**
 * @return {Object}
 */
const TextFieldContainer = () => ({
  selector: '.mdc-text-field',
  init: element => (new TextField({
    element
  })).render()
})

export {
  TextField,
  TextFieldContainer
}
