import MDCAutocomplete from './Autocomplete'

/**
 * @return {Object}
 */
const MDCAutocompleteContainer = () => ({
  selector: '.async-select',
  init: element => (new MDCAutocomplete({
    element
  })).render()
})

export {
  MDCAutocomplete,
  MDCAutocompleteContainer
}
