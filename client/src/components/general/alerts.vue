
<script>
  import { mapState, mapActions } from 'vuex'

  export default {
    computed: {
      ...mapState(['messages']),
      hasSuccessMessage() {
        return this.messages.success !== ''
      },
      hasErrorMessages() {
        return this.messages.error.length > 0
      },
      hasValidationMessages() {
        return this.messages.validation.length > 0
      },
      formatedErrorMessage() {
        return this.messages.error.map(msg => `&bull; ${msg}`).join('<br>')
      },
      formatedValidationMessage() {
        return this.messages.validation.map(msg => `&bull; ${msg}`).join('<br>')
      },
    },
    methods: {
      ...mapActions(['setMessage']),
      dismiss(type) {
        let obj
        if (type === 'error') {
          obj = { type, message: [] }
        } else if (type === 'validation') {
          obj = { type, message: {} }
        } else {
          obj = { type, message: '' }
        }
        this.setMessage(obj)
      },
    },
  }
</script>

<template>
  <div class="alerts-container">
    <el-alert
      :title="messages.success"
      v-show="hasSuccessMessage"
      type="success"
      @close="dismiss('success')"
      show-icon></el-alert>

    <el-alert
      :title="formatedErrorMessage"
      v-show="hasErrorMessages"
      type="error"
      @close="dismiss('error')"
      show-icon></el-alert>

    <el-alert
      :title="formatedErrorMessage"
      v-show="hasValidationMessages"
      type="warning"
      @close="dismiss('validation')"
      show-icon></el-alert>

  </div>
</template>

<style scoped>
  .alerts-container {
    padding-top: 16px;
  }
</style>
