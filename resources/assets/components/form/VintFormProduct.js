class VintFormProduct {
  
  static constansts = {
    PROJECTS_API_URL: '/api/projects-for-user',
    PROJECTS_SELECT_ID: 'select-product-projects',
    PER_PAGE: 15,
  }

  constructor(element) {
    this.state = {
      element,
      projectsSelectEl: element.querySelector(`#${
        VintFormProduct.constansts.PROJECTS_SELECT_ID
      }`)
    }
    this.renderProjectsSelect()
  }

  renderProjectsSelect() {
    new window.vint
      .VintSelect2(this.state.projectsSelectEl)
      .render({
        ajax: {
            url: VintFormProduct.constansts.PROJECTS_API_URL,
            headers: window.vint.request.getDefaultHeaders(),
            processResults: response => ({
                results: response.data.map(item => ({
                    id: item.id,
                    text: `${item.name} / ${item.group.name}`,
                })),
            }),
            data: params => ({
                q: params.term,
                'per-page': VintFormProduct.constansts.PER_PAGE
            })
        }
    }) 
  }
}

export default VintFormProduct
