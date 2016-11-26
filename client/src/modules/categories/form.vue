
<script>
  export default {
    name: 'CcCategoriesForm',
    methods: {
      submit() {

      },
      cancel() {
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
      <input type="text" id="name" class="form-control">
    </div>
    <a href="#" @click.prevent="cancel" class="btn btn-default btn-xs">Cancelar</a>
    <button class="btn btn-primary btn-xs" type="submit">Salvar</button>
  </form>
</template>
