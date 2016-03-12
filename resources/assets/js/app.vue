<template>
<div class="wrapper">
  <div class="notification-layer">
    <div class="box box-solid" :class="'box-'+notification.type" v-for="notification in status.notifications" transition="slide-in">
      <div class="box-header with-border">
        <h3 class="box-title" v-if="notification.title">{{ notification.title }}</h3>
        <h3 class="box-title" v-else>{{ notification.type | capitalize }}</h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" @click="status.notifications.splice($index, 1)"><i class="fa fa-times"></i></button>
        </div><!-- /.box-tools -->
      </div><!-- /.box-header -->
      <div class="box-body">
        {{{ notification.message }}}
      </div><!-- /.box-body -->
    </div>
  </div>

  <header class="main-header">
    <a href="/" :class="(loaded)?'logo':'u-full logo'">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <!-- // TODO: add variable short titles -->
      <span class="logo-mini"><b>P</b>4x4</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Admin P</b>4x4</span>
    </a>

    <nav class="navbar navbar-static-top" role="navigation" v-if="loaded">
      <!-- Sidebar toggle button-->
      <a class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
      </div>
    </nav>
  </header>
</div>
</template>

<script>
module.exports = {
  data () {
    return {
      loaded: false,
      status: {
    		notifications: [],
    		messages: 0,
    		invoices: 0,
    		events: 0
    	}
    }
  },

  events: {},
  methods: {},
}
</script>
