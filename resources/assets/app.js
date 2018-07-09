import { DrawerContainer } from './components/drawer'
import { TextFieldContainer } from './components/textfield'
import { TextFieldHelperTextContainer } from './components/textfield-helper-text'
import { ButtonContainer} from './components/button'
import { TopAppBarContainer } from './components/top-app-bar'
import { SnackbarContainer } from './components/snackbar'
import { RippleContainer } from './components/ripple'
import { SelectContainer } from './components/select'
import { ChartContainer } from './components/chart'
import { TabBarScrollerContainer } from './components/tab-bar-scroller'
import { ExpandableContainer } from './components/expandable'
import { DialogContainer } from './components/dialog'
// Forms
import { AffiliateFormContainer } from './forms/affiliate'
import { UserFormContainer } from './forms/users'
import { LocalizationFormContainer } from './forms/localization'
import { FreightFormContainer } from './forms/freight'
import { TravelFormContainer } from './forms/travel'

/**
 * Inicializa automaticamente todos os componentes indicados.
 * 
 * @return {undefined} 
 */
const autoInit = () => {
  new window.mdc.autoInit();  
  // Lista de containers de componentes a serem inicializados automaticamente.
  const containers = [
    DrawerContainer,  
    // TextFieldContainer,
    TextFieldHelperTextContainer,
    ButtonContainer,
    TopAppBarContainer,
    SnackbarContainer,
    RippleContainer,
    SelectContainer,
    ChartContainer,
    TabBarScrollerContainer,
    ExpandableContainer,
    DialogContainer
  ]
  // Inicializa os componentes.
  containers.map(container => {
    let i = 0
    const elements = document.querySelectorAll(container().selector)
  
    for (i; i < elements.length; i++) {
      container().init(elements[i])
    }  
  })
  const formsContainer = [
    AffiliateFormContainer,
    UserFormContainer,
    LocalizationFormContainer,
    FreightFormContainer,
    TravelFormContainer
  ]
  // Inicializa os formulários.
  formsContainer.map(forms => {
    forms().map(form => {
      const element = document.querySelector(form.selector)

      if (!element) {
        return
      }
  
      form.init(element)
    })
  })
}

const app = () => {
  // Inicializa os componentes.
  autoInit()
}

window.addEventListener('load', app);