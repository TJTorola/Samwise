module.exports = {
  setEvents: ({ dispatch }, count) => dispatch('SET_EVENTS', count),
  setMessages: ({ dispatch }, count) => dispatch('SET_MESSAGES', count),
  setInvoices: ({ dispatch }, count) => dispatch('SET_INVOICES', count)
}
