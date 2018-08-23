import Select from './Select'

/**
 * @return {Object}
 */
const SelectContainer = () => ({
  selector: '.mdc-select',
  init: element => Select.render(element)
})

export {
  Select,
  SelectContainer
}
