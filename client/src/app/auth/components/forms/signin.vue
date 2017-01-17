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
  <div class="well">
    <el-form ref="form">
      <el-form-item label="E-mail">
        <el-input v-model="email"></el-input>
      </el-form-item>
      <el-form-item label="Password">
        <el-input v-model="password" type="password"></el-input>
      </el-form-item>
      <el-button @click="submit">Login</el-button>
    </el-form>
  </div>
</template>
