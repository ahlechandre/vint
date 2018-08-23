import Chart from './Chart'

const csrfTokenElement = document.querySelector('meta[name="csrf-token"]')
const csrfToken = csrfTokenElement ? csrfTokenElement.getAttribute('content') : null

const requestOptions = {
  headers: {
    'Accept': 'application/json',
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': csrfToken
  },
  credentials: 'include',
}  

const ChartContainer = () => {

  return {
    selector: '.chart',
    init: element => {
      const component = new Chart({
        element,
        requestOptions
      });

      component.render()
    } 
  }
}

export {
  ChartContainer
}
