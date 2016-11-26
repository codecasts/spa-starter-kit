
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
      /**
      * Navigates to the URL to show
      * the form to create new category
      */
      formNew() {
        this.$router.push({ name: 'categories.new', query: { page: this.currentPage } })
      },
      /**
      * Brings actions from Vuex to the scope of
      * this component
      */
      ...mapActions(['categoriesSetPager', 'setFetching']),

      /**
      * Fetch a new set of categories
      * based on the current page
      */
      fetch() {
        /**
        * Vuex action to set fetching property
        * to true, thus showing the spinner
        * that is part of navbar.vue
        */
        this.setFetching({ fetching: true })

        /**
        * Makes the HTTP request to the API
        * $http is a Vue.js plugins exposing
        * an Axios object.
        * See /src/plugins/http.js
        */
        this.$http.get(`categorias?page=${this.currentPage}`).then((response) => {
          /**
          * Vuex action to set pager object in
          * the Vuex Categories module
          */
          this.categoriesSetPager({ pager: response.data.pager })

          /**
          * Vuex action to set fetching property
          * to false, thus hiding the spinner
          * that is part of navbar.vue
          */
          this.setFetching({ fetching: false })
        })
      },

      /**
      * Navigate to a specific page, provided in the
      * obj received by the method
      */
      navigate(obj) {
        /**
        * Push the page number to the query string
        */
        this.$router.push({ name: 'categories.index', query: { page: obj.page } })

        /**
        * Fetch a new set of Categories based on
        * current page number. Mind the nextTick()
        * which delays a the request a fraction
        * of a second. This ensures the currentPage
        * property is set before making the request.
        */
        Vue.nextTick(() => this.fetch())
      },

      /**
      * Shows a confirmation dialog
      */
      askRemove(category) {
        swal({
          title: 'Tem certeza',
          text: `A categoria ${category.name} será permanentemente removida.`,
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#DD6B55',
          confirmButtonText: 'Sim, remova!',
          closeOnConfirm: false,
        }, () => this.remove(category)) // callback executed when OK is pressed
      },

      /**
      * Makes the HTTP requesto to the API
      */
      remove(category) {
        this.$http.delete(`categorias/${category.id}/remover`).then(() => {
          /**
          * On success fetch a new set of Categories
          * based on current page number
          */
          this.fetch()

          /**
          * Shows a differente dialog based on the result
          */
          swal('Removido!', 'Registro removido com sucesso.', 'success')
        })
        .catch((error) => {
          /**
          * Just shows the result in a form or error.
          * The general error message is displayed by
          * the action dispatched by the interceptor.
          * See /src/plugins/http.js
          */
          swal('Falha!', error.response.data.messages[0], 'error')
        })
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
          <a href="#" @click.prevent="formNew" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Nova Categoria">
            <i class="fa fa-fw fa-plus"></i>
          </a>
        </div>
      </div>
    </div>

    <!-- Form to create/edit will be inserted here  -->
    <!-- when navigate to /nova or /editar/{id}  -->
    <!-- see /src/modules/categories/routes.js  -->
    <router-view></router-view>

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
            <a href="#"
              @click="askRemove(category)"
              class="btn btn-xs btn-default"
              data-toggle="tooltip"
              data-placement="top"
              title="Excluir">
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
