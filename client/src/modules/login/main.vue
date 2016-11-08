
<script>
  export default {
    data () {
        return {
          email: '',
          password: '',
        }
    },
    methods: {
        submit () {

        },
        reset () {
            this.email = ''
            this.password = ''
        },
    },
  }
</script>

<template>
  <div class="container">
    <h3 class="text-center">Codecasts - SPA - Boilerplate</h3>
    <form class="well" @submit.prevent="submit">
      <div class="form-group">
        <label for="email" class="control-label">E-mail</label>
        <input type="email" class="form-control" id="email" v-model="email">
      </div>
      <div class="form-group">
        <label for="password" class="control-label">Senha</label>
        <input type="password" class="form-control" id="password" v-model="password">
      </div>
      <button class="btn btn-primary btn-block" type="submit">Login</button>
    </form>
  </div>
</template>

<style scoped>
  .container {
    width: 400px;
    margin: 100px auto;
  }
</style>
