class LinearProgressGlobal {

  static classes = {
    ACTIVE: 'linear-progress--active',
  }

  /**
   * 
   * @return {undefined}
   */
  constructor(props) {
    this.state = {
      element: props.element
    }
  }

  /**
   * 
   * @return {undefined}
   */
  setActive() {
    this.state.element.classList.add(
      LinearProgressGlobal.classes.ACTIVE
    )
  }

  /**
   * 
   * @return {undefined}
   */
  setInactive() {
    this.state.element.classList.remove(
      LinearProgressGlobal.classes.ACTIVE
    )
  }

  /**
   * 
   * @return {undefined}
   */
  render() {
    return this
  }
}

export default LinearProgressGlobal
