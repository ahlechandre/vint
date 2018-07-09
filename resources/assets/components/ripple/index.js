import Ripple from './Ripple'

/**
 * @return {Object}
 */
const RippleContainer = () => ({
  selector: '.mdc-ripple-surface',
  init: element => Ripple.render(element)
})

export {
  Ripple,
  RippleContainer
}
