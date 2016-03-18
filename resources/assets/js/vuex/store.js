var Vue = require('vue')
var Vuex = require('vuex')

Vue.use(Vuex)

const state = {
  status: {
    notifications: [],
    messages: 0,
    invoices: 0,
    events: 0
  },
  page: {
    name: "",
    description: "",
    crumbs: []
  },
  user: {},
  cart: {
    items: []
  }
}

const mutations = {
  SET_MESSAGES (state, count) {
    state.status.messages = count
  },

  SET_INVOICES (state, count) {
    state.status.invoices = count
  },

  SET_EVENTS (state, count) {
    state.status.events = count
  },

  LOGIN (state, user) {
    state.user = user
  },

  LOGOUT (state) {
    state.user = {}
  },

  PUSH_NOTIFICATION (state, type, title, message) {
    var uid = 0

    for (var i = 0; i < state.status.notifications.length; i++) {
      if (state.status.notifications[i].id >= uid) {
        uid = state.status.notifications[i].id + 1
      }
    }

    state.status.notifications.push({
      id: uid,
      type: type,
      name: name,
      message: message
    })

    return uid
  },

  DELETE_NOTIFICATION (state, id) {
    for (var i = state.status.notifications.length - 1; i >= 0; i--) {
      if (state.status.notifications[i].id == id) {
        state.status.notifications.splice(i, 1)
      }
    }
  },

  SET_PAGE (state, name, description) {
    state.page.name = name
    state.page.description = description
  }
}

module.exports = new Vuex.Store({
  state,
  mutations
})
