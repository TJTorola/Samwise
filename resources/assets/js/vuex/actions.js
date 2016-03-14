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

      // activate newly revealed adminLTE controls
      this.$nextTick(function() {
        $.AdminLTE.pushMenu.activate("[data-toggle='offcanvas']")
        $.AdminLTE.controlSidebar.activate()
      })
    })
  },
  logout ({ dispatch }) {
    dispatch('LOGOUT')
  }
}
