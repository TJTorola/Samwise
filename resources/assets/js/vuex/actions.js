module.exports = {
  setEvents ({ dispatch }, count) {
    dispatch('SET_EVENTS', count)
  },
  setMessages ({ dispatch }, count) {
    dispatch('SET_MESSAGES', count)
  },
  setInvoices ({ dispatch }, count) {
    dispatch('SET_INVOICES', count)
  },
  login ({ dispatch }) {
    this.$http.get('self').then(function(response) {
      dispatch('LOGIN', response.data)
    })
  },
  logout ({ dispatch }) {
    dispatch('LOGOUT')
  }
}
