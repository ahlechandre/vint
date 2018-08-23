import UserForm from './UserForm'
import UserAffiliatesForm from './UserAffiliatesForm'

export const UserFormContainer = () => ([
  {
    selector: '#form-user',
    init: element => (new UserForm({
      element
    })).render(),
  },
  {
    selector: '#form-user-affiliates',
    init: element => (new UserAffiliatesForm({
      element
    })).render(),
  }
])
