
<script>
  import { mapActions } from 'vuex'

  export default {
    name: 'CcCategoriesForm',
    data() {
      return {
        name: '',
      }
    },
    mounted() {
      this.$refs.firstInput.focus()
    },
    methods: {
      ...mapActions(['setFetching', 'setMessage']),

      submit() {
        /**
        * Shows the global spinner
        */
        this.setFetching({ fetching: true })

        this.$http.post('categorias/nova', { name: this.name }).then(() => {
          /**
          * This event will notify the world about
          * the category creation. In this case
          * the Category main component will intercept
          * the event and refresh the list.
          */
          this.$bus.$emit('category.created')

          /**
          * Hides the global spinner
          */
          this.setFetching({ fetching: false })

          /**
          * Sets the global feedback message
          */
          this.setMessage({ type: 'success', message: 'Categoria criada com sucesso' })

          /**
          * Resets component's state
          */
          this.reset()
        })
      },
      reset() {
        this.name = ''
      },
    },
  }
</script>

<template>
  <form @submit.prevent="submit" class="well">
    <div class="form-group">
      <label for="name" class="control-label">Nome</label>
      <input ref="firstInput" type="text" id="name" class="form-control" v-model="name">
    </div>
    <button class="btn btn-primary btn-xs" type="submit">Salvar</button>
  </form>
</template>
