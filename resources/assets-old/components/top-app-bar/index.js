import TopAppBar from './TopAppBar'

/**
 * @return {Object}
 */
const TopAppBarContainer = () => ({
  selector: '.mdc-top-app-bar',
  init: element => (new TopAppBar({
    element
  })).render()
})

export {
  TopAppBar,
  TopAppBarContainer
}
