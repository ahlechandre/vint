import Button from './Button'

const ButtonContainer = () => ({
  selector: '.button',
  init: element => (new Button({
    element
  })).render(),
})

export {
  Button,
  ButtonContainer
}
