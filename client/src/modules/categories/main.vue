
<script>
  import Vue from 'vue'
  import { mapActions, mapState } from 'vuex'
  import CcPagination from '../general/pagination'

  export default {
    /**
    * Components name to be displayed on
    * Vue.js Devtools
    */
    name: 'CcCategories',

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
      ...mapActions(['categoriesSetPager', 'setFetching']),
      fetch() {
        this.setFetching({ fetching: true })
        this.$http.get(`categorias?page=${this.currentPage}`).then((response) => {
          this.categoriesSetPager({ pager: response.data.pager })
          this.setFetching({ fetching: false })
        })
      },
      navigate(obj) {
        this.$router.push({ name: 'categories.index', query: { page: obj.page } })
        Vue.nextTick(() => this.fetch())
      },
    },

    /**
    * mapState will bring indicated Vuex
    * state properties to the scope of this component.
    */
    computed: {
      ...mapState({
        fetching: state => state.fetching,
        pager: state => state.Categories.pager,
      }),
      categories() {
        return this.pager.data
      },
      currentPage() {
        return parseInt(this.$route.query.page, 10)
      },
    },
    mounted() {
      /**
      * Listen to pagination navigate event
      */
      this.$bus.$on('navigate', obj => this.navigate(obj))
    },
    created() {
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
    /**
    * This hook is called every time DOM
    * gets updated.
    */
    updated() {
      /**
      * start Bootstrap Tooltip
      */
      jQuery('[data-toggle="tooltip"]').tooltip()
    },
  }
</script>

<template>
  <div>
    <div class="row">
      <div class="col-md-6">
        <h1>Gerenciamento de Categorias</h1>
      </div>
      <div class="col-md-6 text-right">
        <div class="button-within-header">
          <a href="#" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Nova Categoria">
            <i class="fa fa-fw fa-plus"></i>
          </a>
        </div>
      </div>
    </div>
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th colspan="2">Nome</th>
        </tr>
      </thead>
      <tbody :class="{ blur: fetching }">
        <tr v-for="category in categories">
          <td width="1%" nowrap>{{ category.id }}</td>
          <td>{{ category.name }}</td>
          <td width="1%" nowrap="nowrap">
            <a href="#" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Editar">
              <i class="fa fa-fw fa-pencil"></i>
            </a>
            <a href="#" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Excluir">
              <i class="fa fa-fw fa-times"></i>
            </a>
          </td>
        </tr>
      </tbody>
    </table>
    <div>
      <cc-pagination
        :pager="pager"
        :current-page="currentPage"
        :max-items="12">
      </cc-pagination>
    </div>
  </div>
</template>

<style scoped>
  .button-within-header {
    margin-top: 32px;
  }
  .blur {
    filter: blur(7px);
  }
</style>
