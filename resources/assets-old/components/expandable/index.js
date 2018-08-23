import Expandable from './Expandable'

const ExpandableContainer = () => ({
  selector: '.expandable',
  init: element => (new Expandable({
    element
  })).render(),
})

export {
  Expandable,
  ExpandableContainer
}
