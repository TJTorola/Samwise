<template>
<input type="button" name="name" value="Login" @click="login">
</template>

<script>
module.exports = {
  methods: {
    login () {
      this.$http.headers.common.Authorization = 'Bearer foo'
    }
  }
}
</script>
