import TabBarScroller from './TabBarScroller'

const TabBarScrollerContainer = () => ({
  selector: '.mdc-tab-bar-scroller',
  init: element => (new TabBarScroller({
    element
  })).render()
})

export {
  TabBarScroller,
  TabBarScrollerContainer
}
