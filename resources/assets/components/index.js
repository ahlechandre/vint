import DialogContainer from './dialog/DialogContainer'
import DialogActivation from './dialog/DialogActivation'
import MenuAnchor from './menu/MenuAnchor'
import DrawerActivation from './drawer/DrawerActivation';

const Components = () => {
  const components = [
    DialogActivation,
    DialogContainer,
    DrawerActivation,
    MenuAnchor
  ]

  components.map(component => {
    const elements = document.querySelectorAll(`.${component.classes.COMPONENT}`)

    for (let i = 0; i < elements.length; i++) {
      Object.defineProperty(elements[i], component.constants.COMPONENT_NAME, {
        value: new component(elements[i]),
        writable: false,
        enumerable: false
      })
    }
  })
}

export default Components
