class VintFormPublication {
  
  static constansts = {
    PROJECTS_API_URL: '/api/projects-for-user',
    MEMBERS_API_URL: '/api/members-for-user',
    PROJECTS_SELECT_ID: 'select-publication-projects',
    MEMBERS_SELECT_ID: 'select-publication-members',
    PER_PAGE: 15,
  }

  constructor(element) {
    this.state = {
      element,
      projectsSelectEl: element.querySelector(`#${
        VintFormPublication.constansts.PROJECTS_SELECT_ID
      }`),
      membersSelectEl: element.querySelector(`#${
        VintFormPublication.constansts.MEMBERS_SELECT_ID
      }`)
    }
    this.renderProjectsSelect()
    this.renderMembersSelect()
  }

  renderProjectsSelect() {
    new window.vint
      .VintSelect2(this.state.projectsSelectEl)
      .render({
        ajax: {
            url: VintFormPublication.constansts.PROJECTS_API_URL,
            headers: window.vint.request.getDefaultHeaders(),
            processResults: response => ({
                results: response.data.map(item => ({
                    id: item.id,
                    text: `${item.name} / ${item.group.name}`,
                })),
            }),
            data: params => ({
                q: params.term,
                'per-page': VintFormPublication.constansts.PER_PAGE
            })
        }
    }) 
  }

  renderMembersSelect() {
    new window.vint
      .VintSelect2(this.state.membersSelectEl)
      .render({
        ajax: {
            url: VintFormPublication.constansts.MEMBERS_API_URL,
            headers: window.vint.request.getDefaultHeaders(),
            processResults: response => ({
                results: response.data.map(member => ({
                    id: member.user_id,
                    text: `${member.user.name} <${member.user.email}>`,
                })),
            }),
            data: params => ({
                q: params.term,
                'per-page': VintFormPublication.constansts.PER_PAGE
            })
        }
    }) 
  }  
}

export default VintFormPublication
