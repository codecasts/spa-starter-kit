
<script>
  import { mapActions, mapState } from 'vuex'
  import CcPagination from '../general/pagination'

  export default {
    /**
    * Components name to be displayed on
    * Vue.js Devtools
    */
    name: 'Categories',

    /**
    * Components registered with
    * this component
    */
    components: {
      CcPagination,
    },

    /**
    * mapActions will bring indicated Vuex
    * actions to the scope of this component.
    */
    methods: {
      ...mapActions(['categoriesSetPager']),
      fetch() {
        this.$http.get(`categorias?page=${this.currentPage}`).then((response) => {
          this.categoriesSetPager({ pager: response.data.pager })
        })
      },
      navigate(obj) {
        this.$router.push({ name: 'categories.index', query: { page: obj.page } })
        this.fetch()
      },
    },

    /**
    * mapState will bring indicated Vuex
    * state properties to the scope of this component.
    */
    computed: {
      ...mapState({
        pager: state => state.Categories.pager,
      }),
      categories() {
        return this.pager.data
      },
      currentPage() {
        return this.$route.query.page
      },
    },
    mounted() {
      /**
      * Listen to pagination navigate event
      */
      this.$bus.$on('navigate', obj => this.navigate(obj))
      /**
      * We only fetch data the first time
      * component is mounted. We can set
      * up a timer to fetch new data
      * from time to time
      */
      if (this.pager.data === undefined) {
        this.fetch()
      }
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
    <div class="text-center">
      <cc-pagination :pager="pager"></cc-pagination>
    </div>
  </div>
</template>
