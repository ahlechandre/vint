import { MDCTopAppBar } from '@material/top-app-bar/index';

class TopAppBar {

  static classes = {
    WITH_SEARCH: 'top-app-bar--with-search',
    WITH_SEARCH_ACTIVE: 'top-app-bar--with-search-active',
    OPEN_SEARCH_BUTTON: 'top-app-bar__action-open-search',
    CLOSE_SEARCH_BUTTON: 'top-app-bar__action-close-search',
    INPUT_SEARCH: 'top-app-bar__input-search',
  }

  /**
   * 
   * @param {Object} props 
   */
  constructor(props) {
    this.state = {
      element: props.element
    }

    if (!this.isWithSearch()) {
      return
    }
    const buttonOpenSearch = this.state.element.querySelector(`.${
      TopAppBar.classes.OPEN_SEARCH_BUTTON
    }`)
    const buttonCloseSearch = this.state.element.querySelector(`.${
      TopAppBar.classes.CLOSE_SEARCH_BUTTON
    }`)
    const inputSearch = this.state.element.querySelector(`.${
      TopAppBar.classes.INPUT_SEARCH
    }`)

    if (!buttonOpenSearch) {
      throw new Error(`Please, provide a open search action (.${
        TopAppBar.classes.OPEN_SEARCH_BUTTON
      })`)
    }

    if (!buttonCloseSearch) {
      throw new Error(`Please, provide a close search action (.${
        TopAppBar.classes.CLOSE_SEARCH_BUTTON
      })`)
    }

    if (!inputSearch) {
      throw new Error(`Please, provide a input search (.${
        TopAppBar.classes.INPUT_SEARCH
      })`)
    }
    this.state = {
      ...this.state,
      elements: {
        buttonOpenSearch,
        buttonCloseSearch,
        inputSearch,
      }
    }    
    this.onOpenSearch = this.onOpenSearch.bind(this)
    this.onCloseSearch = this.onCloseSearch.bind(this)
    this.onKeyUp = this.onKeyUp.bind(this)
    this.onBlurSearch = this.onBlurSearch.bind(this)
  }

  /**
   * @return {boolean}
   */
  isWithSearch() {
    return this.state.element.classList.contains(
      TopAppBar.classes.WITH_SEARCH
    )
  }

  /**
   * @param {Event} event
   * @return {undefined}
   */
  onOpenSearch(event) {
    event.preventDefault()
    this.state.element.classList.add(
      TopAppBar.classes.WITH_SEARCH_ACTIVE
    )
    this.state.elements.inputSearch.focus()
  }

  /**
   * @return {undefined}
   */
  onCloseSearch() {

    this.state.element.classList.remove(
      TopAppBar.classes.WITH_SEARCH_ACTIVE
    )
    this.state.elements.inputSearch.value = ''
  }

  /**
   * @param {Event} event
   * @return {undefined}
   */
  onKeyUp(event) {
    // Desativa a busca ao pressionar "esc".
    if (event.keyCode === 27) {
      this.onCloseSearch()
    }
  }

  /**
   * 
   * @return {undefined}
   */
  onBlurSearch() {
    this.onCloseSearch()
  }

  /**
   * 
   * @return {undefined}
   */
  render() {
    // Instancia o novo componente.
    new MDCTopAppBar(this.state.element)

    if (!this.isWithSearch()) {
      return
    }
    this.state.elements.inputSearch.addEventListener('blur', this.onBlurSearch)
    this.state.elements.buttonOpenSearch.addEventListener('click', this.onOpenSearch)
    this.state.elements.buttonCloseSearch.addEventListener('click', this.onCloseSearch)     
    this.state.element.addEventListener('keyup', this.onKeyUp)     
  }
}

export default TopAppBar
