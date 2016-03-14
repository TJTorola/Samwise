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

        <div v-else class="login-form">
          <div class="input-wrapper">
            <span class='fa fa-envelope'></span>
            <input type='text' name='email' placeholder="E-Mail" v-model="email">
          </div>

          <div class="input-wrapper">
            <span class='fa fa-key'></span>
            <input type='password' name='password' placeholder="*******" v-model="password">
          </div>

          <div class="submit-placeholder" v-if="!validLogin">
            ENTER VALID {{ (validEmail)?'PASSWORD':'EMAIL' }}
          </div>
          <input type='submit' value='SUBMIT LOGIN' @click="postLogin" v-else>
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
  data () {
    return {
      email: "",
      password: ""
    }
  },

  computed: {
    loggedIn () {
      return Boolean(this.user.name)
    },
    validEmail () {
      var regex = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
      return regex.test(this.email)
    },
    validPassword () {
      return this.password.length >= 8
    },
    validLogin () {
      return this.validEmail && this.validPassword
    }
  },

  methods: {
    postLogin () {
      var request = {
        email: this.email,
        password: this.password
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

<style>
.login-form {
  width: 280px;
  left: 50%;
  top: 50%;
  position: fixed;
  -webkit-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
}

.login-form span {
  background-color: #AAA;
  border-radius: 3px 0px 0px 3px;
  color: #f7f7f7;
  display: block;
  float: left;
  height: 50px;
  line-height: 50px;
  text-align: center;
  width: 50px;
}

.login-form input {
  height: 50px;
  line-height: 1.5em;
  border: none;
}

.login-form input[type=text], .login-form input[type=password] {
  background-color: #FFF;
  border-radius: 0px 3px 3px 0px;
  margin-bottom: 1em;
  padding: 0 16px;
  width: 230px;
}

.submit-placeholder {
  height: 50px;
  line-height: 50px;
  text-align: center;
  border-radius: 3px;
  -moz-border-radius: 3px;
  -webkit-border-radius: 3px;
  background-color: #AAA;
  color: #FFF;
  font-weight: bold;
  margin-bottom: 2em;
  text-transform: uppercase;
  width: 280px;
}

.login-form input[type=submit] {
  border-radius: 3px;
  -moz-border-radius: 3px;
  -webkit-border-radius: 3px;
  background: #367FA9;
  color: #FFF;
  font-weight: bold;
  margin-bottom: 2em;
  text-transform: uppercase;
  width: 280px;
}
</style>
