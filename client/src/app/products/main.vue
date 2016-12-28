
<script>
  import { mapActions, mapState } from 'vuex'

  export default {
    /**
    * Components name to be displayed on
    * Vue.js Devtools
    */
    name: 'CcProducts',

    methods: {
      edit(index) {
        const { id } = this.products[index]
        this.$router.push({
          name: 'products.edit',
          params: { id },
          query: { page: this.currentPage } })
      },
      create() {
        this.$router.push({ name: 'products.new', query: { page: this.currentPage } })
      },
      hide() {
        this.$router.push({ name: 'products.index', query: { page: this.currentPage } })
      },
      /**
      * Brings actions from Vuex to the scope of
      * this component
      */
      ...mapActions(['productsSetData', 'setFetching']),

      /**
      * Fetch a new set of products
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
        this.$http.get(`products?page=${this.currentPage}`).then(({ data }) => {
          /**
          * Vuex action to set pagination object in
          * the Vuex Products module
          */
          this.productsSetData({
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
      * Navigate to a specific page, provided in the
      * obj received by the method
      */
      navigate(page) {
        /**
        * Push the page number to the query string
        */
        this.$router.push({ name: 'products.index', query: { page } })
      },

      /**
      * Shows a confirmation dialog
      */
      askRemove(index) {
        const product = this.products[index]
        swal({
          title: 'Are you sure?',
          text: `Product ${product.name} will be permanently removed.`,
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#DD6B55',
          confirmButtonText: 'Yes, do it!',
          closeOnConfirm: false,
        }, () => this.remove(product)) // callback executed when OK is pressed
      },

      /**
      * Makes the HTTP requesto to the API
      */
      remove(product) {
        this.$http.delete(`products/${product.id}`).then(() => {
          /**
          * On success fetch a new set of Products
          * based on current page number
          */
          this.fetch()

          /**
          * Shows a different dialog based on the result
          */
          swal('Done!', 'Product removed.', 'success')

          /**
          * Redirects back to the main list,
          * in case the form is open
          */
          if (this.isFormVisible) {
            this.$router.push({ name: 'products.index', query: { page: this.currentPage } })
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

    watch: {
      // when page change, fetch new data
      currentPage: 'fetch',
    },

    /**
    * mapState will bring indicated Vuex
    * state properties to the scope of this component.
    */
    computed: {
      ...mapState({
        fetching: state => state.fetching,
        pagination: state => state.Products.pagination,
        list: state => state.Products.list,
      }),
      products() {
        return this.list
      },
      currentPage() {
        return parseInt(this.$route.query.page, 10) || 1
      },
      isFormVisible() {
        return this.$route.name === 'products.new' || this.$route.name === 'products.edit'
      },
    },
    /**
    * Right before navigate out to another route
    * clears all event handlers, thus avoiding
    * multiple handlers to be set and the annoying
    * behaviour of multiple AJAX calls being made.
    */
    beforeRouteLeave(to, from, next) {
      this.$bus.$off('product.created')
      this.$bus.$off('product.updated')
      jQuery('body').off('keyup')
      next()
    },
    mounted() {
      /**
      * Product was created or updated, refresh the list
      */
      this.$bus.$on('product.created', () => this.fetch())
      this.$bus.$on('product.updated', () => this.fetch())

      /**
      * Fetch data immediately after component is mounted
      */
      this.fetch()
    },
  }
</script>

<template>
  <div>
    <div class="row">
      <div class="col-md-6">
        <h1>Product Management</h1>
      </div>
      <div class="col-md-6 text-right">
        <div class="button-within-header">
          <el-button
            @click="create"
            v-show="!isFormVisible"
            type="default"
            icon="plus"
            size="mini"></el-button>
          <el-button
            @click="hide"
            v-show="isFormVisible"
            type="default"
            icon="minus"
            size="mini"></el-button>
        </div>
      </div>
    </div>

    <!-- Form to create/edit will be inserted here  -->
    <!-- when navigate to /create or /edit/{id}  -->
    <!-- see /src/modules/products/routes.js  -->
    <transition name="fade">
      <router-view></router-view>
    </transition>

    <!-- el-table and its children comes from Element UI -->
    <!-- http://element.eleme.io/#/en-US/component/table -->
    <el-table v-loading.body="fetching" :data="products" stripe border style="width: 100%">
      <el-table-column prop="id" label="ID" width="80"></el-table-column>
      <el-table-column prop="name" label="Product"></el-table-column>
      <el-table-column inline-template label="Options" width="100">
        <div>
          <el-button @click="edit($index)" type="default" icon="edit" size="mini"></el-button>
          <el-button @click="askRemove($index)" type="default" icon="delete" size="mini"></el-button>
        </div>
      </el-table-column>
    </el-table>
    <div class="pagination">
      <el-pagination
        @current-change="navigate"
        :current-page="pagination.current_page"
        :page-size="pagination.per_page"
        layout="total, prev, pager, next, jumper"
        :total="pagination.total">
      </el-pagination>
    </div>
  </div>
</template>

<style scoped>
  .pagination {
    float: right;
    margin-top: 20px;
  }
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
