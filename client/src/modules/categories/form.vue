
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
      ...mapActions(['setMessage']),
      submit() {
        this.$http.post('categorias/nova', { name: this.name }).then(() => {
          this.setMessage({ type: 'success', message: 'Categoria criada com sucesso!' })
          this.$bus.$emit('category.created')
          this.back()
        })
      },
      back() {
        const { query } = this.$route // http://wesbos.com/destructuring-objects/
        this.$router.push({ name: 'categories.index', query })
      },
    },
  }
</script>

<template>
  <form @submit.prevent="submit" class="well">
    <div class="form-group">
      <label for="name" class="control-label">Nome</label>
      <input ref="firstInput" autofocus type="text" id="name" class="form-control" v-model="name">
    </div>
    <button class="btn btn-primary btn-xs" type="submit">Salvar</button>
  </form>
</template>
