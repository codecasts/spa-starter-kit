
<script>
  import { mapState, mapActions } from 'vuex'
  import { isEmpty } from 'lodash'

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
        return !isEmpty(this.messages.validation)
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
  <div>

    <!-- Success messages -->
    <div class="alert alert-success" v-show="hasSuccessMessage">
      <button type="button" class="close" aria-label="Close" @click="dismiss('success')">
        <span aria-hidden="true">&times;</span>
      </button>
      {{ messages.success }}
    </div>

    <!-- Error messages -->
    <div class="alert alert-danger" v-show="hasErrorMessages">
      <button type="button" class="close" aria-label="Close" @click="dismiss('error')">
        <span aria-hidden="true">&times;</span>
      </button>
      <ul>
        <li v-for="error in messages.error">{{ error }}</li>
      </ul>
    </div>

    <!-- Validation messages -->
    <div class="alert alert-danger" v-show="hasValidationMessages">
      <button type="button" class="close" aria-label="Close" @click="dismiss('validation')">
        <span aria-hidden="true">&times;</span>
      </button>
      <ul>
        <li v-for="error in messages.validation">{{ error[0] }}</li>
      </ul>
    </div>

  </div>
</template>
