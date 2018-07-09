import TextFieldHelperText from './TextFieldHelperText'

/**
 * @return {Object}
 */
const TextFieldHelperTextContainer = () => ({
  selector: '.mdc-text-field-helper-text',
  init: element => (new TextFieldHelperText({
    element
  })).render()
})

export {
  TextFieldHelperText,
  TextFieldHelperTextContainer
}
