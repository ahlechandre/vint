import fetch from 'cross-fetch'

class Chart {
  /**
   * @type {Object}
   */
  static classes = {
    'CHART': 'chart',
    'CONTAINER': 'chart__container',
    'TOOLTIP': 'chart__tooltip',
  }

  /**
   * @type {Object}
   */
  static datasets = {
    'API': 'chartApi',
  }

  /**
   * 
   * @param {Object} props
   */
  constructor(props) {
    this.state = {
      ...props,
      plugins: [
        Chartist.plugins.tooltip({
          class: Chart.classes['TOOLTIP']
        })
      ]
    }
  }

  /**
   * 
   * @return HTMLElement
   */
  getContainerElement() {
    return this.state.element.querySelector(
      `.${Chart.classes['CONTAINER']}`
    )
  }

  /**
   * @return string
   */
  getApi() {
    return this.state.element.dataset[
      Chart.datasets['API']
    ];
  }

  static clearContainer(container) {
    
    while (container.firstChild) {
      container.removeChild(
        container.firstChild
      )
    }
  }

  draw(payload) {  
    const container = this.getContainerElement()

    if (!container) {
      return
    }
    // Remove a barra de progresso.
    Chart.clearContainer(container)
    const options = {
      plugins: this.state.plugins
    }

    // Cria um novo gráfico com os dados gerados no servidor.
    switch (payload.type) {
      case 'bar': {
        return new Chartist.Bar(container, payload.data, options)
      }
      case 'line': {
        return new Chartist.Line(container, payload.data, {
          ...options,
          low: 0,
          showArea: true
        })
      }
      case 'pie': {
        const total = payload.data
          .series
          .reduce((a, b) => a + b.value, 0)
        
        return new Chartist.Pie(container, {
          series: payload.data.series
        }, {
          ...options,
          labelInterpolationFnc: value => `${
            ((value / total) * 100).toFixed(1)
          }%`,
        })
      }
      default: {
        return
      }
    }
  }

  render() {
    const api = this.getApi()
    const onSuccess = payload => this.draw(payload)

    fetch(api, this.state.requestOptions)
      .then(response => response.json())
      .then(onSuccess)
      .catch(error => console.error(error))
  }
}

export default Chart
