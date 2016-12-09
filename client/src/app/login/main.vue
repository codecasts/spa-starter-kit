
<script>
  import { mapActions } from 'vuex'

  export default {
    /**
    * Component's local state
    */
    data() {
      return {
        email: 'happy.developer@vuejsisawesome.com',
        password: '123456',
      }
    },
    methods: {
      /**
      * Map the actions from Vuex to this component.
      * https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/Spread_operator
      */
      ...mapActions(['setToken', 'setUser', 'setMessage']),

      /**
      * Handle form's submit event
      */
      submit() {
        const payload = { email: this.email, password: this.password }
        this.$http.post('auth/token/issue', payload).then((response) => {
          this.handleResponse(response)
        })
      },

      /**
      * Handle success response from AJAX call
      */
      handleResponse(response) {
        this.setToken(response.data.token) // this is a Vuex action
        this.setUser(response.data.user) // this is a Vuex action
        this.setMessage({ type: 'error', message: [] }) // this is a Vuex action
        this.$router.push({ name: 'dashboard.index' })
      },

      /**
      * Reset component's local state
      */
      reset() {
        this.email = ''
        this.password = ''
      },
    },
  }
</script>

<template>
  <div class="container">
    <h3 class="text-center">Codecasts - SPA - Starter Kit</h3>
    <form class="well" @submit.prevent="submit">
      <div class="form-group">
        <label for="email" class="control-label">E-mail</label>
        <input type="email" class="form-control" id="email" v-model="email">
      </div>
      <div class="form-group">
        <label for="password" class="control-label">Password</label>
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
