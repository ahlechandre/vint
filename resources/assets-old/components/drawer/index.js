import DrawerTemporary from './DrawerTemporary'

const DrawerContainer = () => ({
  selector: '.mdc-drawer--temporary',
  init: element => (new DrawerTemporary({
    element,
  })).render()
})

export {
  DrawerTemporary,
  DrawerContainer
}
