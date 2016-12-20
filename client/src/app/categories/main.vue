
<script>
  import Vue from 'vue'
  import { mapActions, mapState } from 'vuex'
  import CcPagination from 'components/general/pagination'

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

    methods: {
      edit(id) {
        this.$router.push({
          name: 'categories.edit',
          params: { id },
          query: { page: this.currentPage } })
      },
      create() {
        this.$router.push({ name: 'categories.new', query: { page: this.currentPage } })
      },
      hide() {
        this.$router.push({ name: 'categories.index', query: { page: this.currentPage } })
      },
      /**
      * Brings actions from Vuex to the scope of
      * this component
      */
      ...mapActions(['categoriesSetData', 'setFetching']),

      fetch() {
        this.fetchPaginated()
        this.fetchFullList()
      },

      /**
      * Fetch a new set of categories
      * based on the current page
      */
      fetchPaginated() {
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
        this.$http.get(`categories?page=${this.currentPage}`).then(({ data }) => {
          /**
          * Vuex action to set pagination object in
          * the Vuex Categories module
          */
          this.categoriesSetData({
            list: data.data,
            pagination: data.meta.pagination,
          })

          /**
          * Vuex action to set fetching property
          * to false, thus hiding the spinner
          * that is part of navbar.vue
          */
          this.setFetching({ fetching: false })
        })
      },

      /**
      * Differente from fetch() which always
      * return a paginated set of categories
      * this one returns the full set, which
      * is used by other components in the app.
      */
      fetchFullList() {
        this.setFetching({ fetching: true })
        this.$http.get('categories/full-list').then(({ data }) => {
          /**
          * Vuex action to set full list array in
          * the Vuex Categories module
          */
          this.categoriesSetData({
            full_list: data.data,
          })
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
        Vue.nextTick(() => this.fetchPaginated())
      },

      /**
      * Shows a confirmation dialog
      */
      askRemove(category) {
        swal({
          title: 'Are you sure?',
          text: `Category ${category.name} will be permanently removed.`,
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#DD6B55',
          confirmButtonText: 'Yes, do it!',
          closeOnConfirm: false,
        }, () => this.remove(category)) // callback executed when OK is pressed
      },

      /**
      * Makes the HTTP requesto to the API
      */
      remove(category) {
        this.$http.delete(`categories/${category.id}`).then(() => {
          /**
          * On success fetch a new set of Categories
          * based on current page number
          */
          this.fetchPaginated()

          /**
          * If we remove a category then
          * the full list must be refreshed
          */
          this.fetchFullList()

          /**
          * Shows a different dialog based on the result
          */
          swal('Done!', 'Category removed.', 'success')

          /**
          * Redirects back to the main list,
          * in case the form is open
          */
          if (this.isFormVisible) {
            this.$router.push({ name: 'categories.index', query: { page: this.currentPage } })
          }
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
        pagination: state => state.Categories.pagination,
        list: state => state.Categories.list,
      }),
      categories() {
        return this.list
      },
      currentPage() {
        return parseInt(this.$route.query.page, 10) || 1
      },
      isFormVisible() {
        return this.$route.name === 'categories.new' || this.$route.name === 'categories.edit'
      },
    },
    /**
    * Right before navigate out to another route
    * clears all event handlers, thus avoiding
    * multiple handlers to be set and the annoying
    * behaviour of multiple AJAX calls being made.
    */
    beforeRouteLeave(to, from, next) {
      this.$bus.$off('navigate')
      this.$bus.$off('category.created')
      this.$bus.$off('category.updated')
      jQuery('body').off('keyup')
      next()
    },
    mounted() {
      /**
      * Listen to pagination navigate event
      */
      this.$bus.$on('navigate', obj => this.navigate(obj))
      /**
      * Category was created or updated, refresh the list
      */
      this.$bus.$on('category.created', this.fetch)
      this.$bus.$on('category.updated', this.fetch)
      /**
      * Fetch data immediately after component is mounted
      */
      this.fetchPaginated()
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
        <h1>Category Management</h1>
      </div>
      <div class="col-md-6 text-right">
        <div class="button-within-header">
          <a href="#"
            v-show="!isFormVisible"
            @click.prevent="create"
            class="btn btn-xs btn-default"
            data-toggle="tooltip" data-placement="top"
            title="New Category">
            <i class="fa fa-fw fa-plus"></i>
          </a>
          <a href="#"
            v-show="isFormVisible"
            @click.prevent="hide"
            class="btn btn-xs btn-default"
            data-toggle="tooltip" data-placement="top"
            title="New Category">
            <i class="fa fa-fw fa-minus"></i>
          </a>
        </div>
      </div>
    </div>

    <!-- Form to create/edit will be inserted here  -->
    <!-- when navigate to /nova or /editar/{id}  -->
    <!-- see /src/modules/categories/routes.js  -->
    <transition name="fade">
      <router-view></router-view>
    </transition>

    <!-- el-table and its children comes from Element UI -->
    <!-- http://element.eleme.io/#/en-US/component/table -->
    <el-table :data="categories" stripe border style="width: 100%">
      <el-table-column prop="id" label="ID" width="80"></el-table-column>
      <el-table-column prop="name" label="Category"></el-table-column>
      <el-table-column inline-template label="Options" width="100">
        <div>
          <a href="#"
              @click.prevent="edit(category.id)"
              class="btn btn-xs btn-default"
              data-toggle="tooltip"
              data-placement="top"
              title="Edit">
              <i class="fa fa-fw fa-pencil"></i>
            </a>
            <a href="#"
              @click="askRemove(category)"
              class="btn btn-xs btn-default"
              data-toggle="tooltip"
              data-placement="top"
              title="Remove">
              <i class="fa fa-fw fa-times"></i>
            </a>
        </div>
      </el-table-column>
    </el-table>
    <div>
      <cc-pagination
        :pagination-data="pagination"
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
  .fade-enter-active, .fade-leave-active {
    transition: opacity .7s ease;
  }
  .fade-enter, .fade-leave-active {
    opacity: 0;
  }
</style>
