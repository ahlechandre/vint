class VintTopAppBarWithSearch {

  static constants = {
    SEARCH_VISIBLE_CLASS: 'top-app-bar--with-search-visible',
    OPEN_SEARCH_CLASS: 'top-app-bar__open-search',
    CLOSE_SEARCH_CLASS: 'top-app-bar__close-search',
    TEXT_FIELD_CLASS: 'top-app-bar__text-field'
  }

  constructor(element) {
    const openSearchElements = element.querySelectorAll(`.${
      VintTopAppBarWithSearch.constants.OPEN_SEARCH_CLASS
    }`)
    const closeSearchElements = element.querySelectorAll(`.${
      VintTopAppBarWithSearch.constants.CLOSE_SEARCH_CLASS
    }`)
    const textFieldElement = element.querySelector(`.${
      VintTopAppBarWithSearch.constants.TEXT_FIELD_CLASS
    }`) 

    this.state = {
      element,
      openSearchElements,
      closeSearchElements,
      textFieldElement,
    }
    this.closeSearch = this.closeSearch.bind(this)
    this.openSearch = this.openSearch.bind(this)
    this.render()
  }

  closeSearch() {
    this.state.element.classList.remove(
      VintTopAppBarWithSearch.constants.SEARCH_VISIBLE_CLASS
    )
  }

  openSearch() {
    this.state.element.classList.add(
      VintTopAppBarWithSearch.constants.SEARCH_VISIBLE_CLASS
    )
    this.setInputFocus()
  }

  setInputFocus() {
    this.state.textFieldElement.focus()
    this.state.textFieldElement.setSelectionRange(this.state.textFieldElement.value.length, this.state.textFieldElement.value.length)    
  }

  render() {
    for (let i = 0; i < this.state.openSearchElements.length; i++) {
      this.state.openSearchElements[i].addEventListener('click', this.openSearch)
    }

    for (let i = 0; i < this.state.closeSearchElements.length; i++) {
      this.state.closeSearchElements[i].addEventListener('click', this.closeSearch)
    }
    // this.state.textFieldElement.addEventListener('blur', this.closeSearch)
    this.state.element.addEventListener('keyup', event => {
      // Esc.
      if (event.keyCode === 27) {
        this.closeSearch()
      }
    })
    this.setInputFocus()
  }
}

export default VintTopAppBarWithSearch
