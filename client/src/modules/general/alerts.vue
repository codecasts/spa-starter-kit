
<script>
  import { mapState, mapActions } from 'vuex'

  export default {
    computed: {
      ...mapState(['messages']),
      hasSuccessMessage() {
        return this.messages.success !== ''
      },
    },
    methods: {
      ...mapActions(['setMessage']),
      dismiss(type) {
        this.setMessage({ type, message: '' })
      },
    },
  }
</script>

<template>
  <div>
    <div class="alert alert-success" v-show="hasSuccessMessage">
      <button type="button" class="close" aria-label="Close" @click="dismiss('success')">
        <span aria-hidden="true">&times;</span>
      </button>
      {{ messages.success }}
    </div>
  </div>
</template>

<style scoped>
  .alert {
    margin-top: -25px;
  }
</style>
