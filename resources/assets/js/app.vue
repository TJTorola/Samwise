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
    <a v-link="{ path: '/' }" :class="(loggedIn)?'logo':'u-full logo'">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <!-- // TODO: add variable short titles -->
      <span class="logo-mini"><b>P</b>4x4</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Admin P</b>4x4</span>
    </a>

    <nav class="navbar navbar-static-top" role="navigation" v-if="loggedIn">
      <!-- Sidebar toggle button-->
      <a class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
      </div>
    </nav>
  </header>

  <div class="page">
    <!-- Content Wrapper. Contains page content -->
    <div id="vue-page" :class="(loggedIn)?'content-wrapper':'u-no-margin content-wrapper'">

      <!-- Content Header (Page header) -->
      <section class="content-header" v-if="loggedIn">
        <h1>
          <span class="fa fa-home"></span>
          page.title
          <small>page.description</small>
        </h1>
        <ol class="breadcrumb">
          <!-- <li><a href="javascript:;" onclick="renderPage('<?=$crumb['link']?>');"><?=$crumb['title']?></a></li> -->
          <li class="active">page.title</li>
        </ol>
      </section>

      <section class='content'>

        <router-view v-if="loggedIn"></router-view>
        <div v-else>
          <input type="button" name="name" value="Login" @click="postLogin">
        </div>

      </section>
    </div><!-- /.content-wrapper -->
  </div>
</div>
</template>

<script>
var store = require('./vuex/store.js')
var actions = require('./vuex/actions.js')

module.exports = {
  computed: {
    loggedIn () {
      return Boolean(this.user.name)
    }
  },

  methods: {
    postLogin () {
      var request = {
        email: 'tjtorola@gmail.com',
        password: 'password'
      }
      this.$http.post('auth', request)
    }
  },

  store,

  vuex: {
    getters: {
      status: state => state.status,
      user: state => state.user
    },
    actions
  }
}
</script>
