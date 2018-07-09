class Expandable {
  /**
   * @var {Object}
   */
  static classes = {
    EXPANDABLE__ACTIVATION: 'expandable__activation',
    EXPANDABLE__ACTIVATED: 'expandable--activated'
  }

  /**
   * @param {Object} props
   * @return {undefined}
   */
  constructor(props) {
    const expandableActivationEl = props.element.querySelector(`.${
      Expandable.classes.EXPANDABLE__ACTIVATION
    }`)

    this.state = {
      element: props.element,
      activation: expandableActivationEl
    }
    this.onActivationClick = this.onActivationClick.bind(this)
  }

  /**
   * 
   * @param {Event} event 
   */
  onActivationClick(event) {
    event.preventDefault()
    const isActivated = this.state.element.classList.contains(
      Expandable.classes.EXPANDABLE__ACTIVATED
    )

    if (isActivated) {
      return this.state.element.classList.remove(
        Expandable.classes.EXPANDABLE__ACTIVATED
      )
    }

    return this.state.element.classList.add(
      Expandable.classes.EXPANDABLE__ACTIVATED
    ) 
  }

  /**
   * @return {undefined}
   */
  render() {
    this.state.activation.addEventListener('click', this.onActivationClick)
  }
}

export default Expandable
