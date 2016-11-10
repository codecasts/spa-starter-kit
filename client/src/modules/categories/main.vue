
<script>
  import { mapActions, mapState } from 'vuex'

  export default {
    name: 'Categories',
    methods: {
      ...mapActions(['categoriesSetList']),
    },
    computed: {
      ...mapState({
        categories: state => state.Categories.list,
      }),
    },
    mounted() {
      this.$http.get('categorias').then((response) => {
        this.categoriesSetList({ list: response.data.categories })
      })
    },
  }
</script>

<template>
  <div>
    <h1>Gerenciamento de Categorias</h1>
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="category in categories">
          <td width="1%" nowrap>{{ category.id }}</td>
          <td>{{ category.name }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
