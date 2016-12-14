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
      ...mapActions(['attemptLogin', 'setMessage']),

      /**
      * Handle form's submit event
      */
      submit() {
        const { email, password } = this // http://wesbos.com/destructuring-objects/
        this.attemptLogin({ email, password }) // this is a Vuex action
          .then(() => {
            this.setMessage({ type: 'error', message: [] }) // this is a Vuex action
            this.$router.push({ name: 'dashboard.index' })
          })
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
</template>
