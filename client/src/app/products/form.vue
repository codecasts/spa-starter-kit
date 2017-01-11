
<script>
  import { mapActions, mapState } from 'vuex'

  export default {
    name: 'CcProductsForm',

    /**
    * Component's local state
    */
    data() {
      return {
        product: {
          id: 0,
          category: 1,
          name: '',
        },
      }
    },

    /**
    * Fetch product when component is first mounted
    */
    mounted() {
      this.fetch()
      this.fetchCategories()
    },

    /**
    * Also fetch product every time route changes
    */
    watch: {
      $route: 'fetch',
    },

    /**
    * Determines based on the presence of
    * product id if the current actions
    * is editing instead of creating.
    */
    computed: {
      ...mapState({
        categories: state => state.Categories.full_list,
      }),
      isEditing() {
        return this.product.id > 0
      },
      isValid() {
        this.resetMessages()
        if (this.product.name === '') {
          this.setMessage({ type: 'error', message: ['Please fill product name'] })
          return false
        }
        return true
      },
    },

    methods: {
      ...mapActions(['categoriesSetData', 'setFetching', 'resetMessages', 'setMessage']),
      /**
      * If there's an ID in the route params
      * then use it to fetch the product
      * from the server
      */
      fetch() {
        const id = this.$route.params.id
        /**
        * This same component is used for create
        * and update so we have to check if
        * ID is not undefined.
        */
        if (id !== undefined) {
          /**
          * Fetch the product from the server
          */
          this.setFetching({ fetching: true })
          this.$http.get(`products/${id}`).then((res) => {
            // http://wesbos.com/destructuring-renaming/
            const { id: _id, name, category } = res.data.data
            this.product.name = name
            this.product.id = _id
            this.product.category = category.data.id
            this.setFetching({ fetching: false })
            // debugger
            /**
            * If you're uncertain of where the data comes from
            * just uncomment the debugger instruction above
            * open Chrome Dev Tools and reload the page
            * this will give you the opportunity to
            * inspect the response and the data
            */
          })
        }
      },
      fetchCategories() {
        if (!this.categories.length) {
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
        }
      },
      submit() {
        /**
        * Pre-conditions are met
        */
        if (this.isValid) {
          /**
          * Shows the global spinner
          */
          this.setFetching({ fetching: true })

          if (this.isEditing) {
            this.update()
          } else {
            this.save()
          }
        }
      },
      save() {
        this.$http.post('products', this.product).then(() => {
          /**
          * This event will notify the world about
          * the product creation. In this case
          * the Product main component will intercept
          * the event and refresh the list.
          */
          this.$bus.$emit('product.created')

          /**
          * Hides the global spinner
          */
          this.setFetching({ fetching: false })

          /**
          * Sets the global feedback message
          */
          this.setMessage({ type: 'success', message: 'New product was created' })

          /**
          * Resets component's state
          */
          this.reset()
        })
      },
      update() {
        this.$http.put(`products/${this.product.id}`, this.product).then(() => {
          /**
          * This event will notify the world about
          * the product creation. In this case
          * the Product main component will intercept
          * the event and refresh the list.
          */
          this.$bus.$emit('product.updated')

          /**
          * Hides the global spinner
          */
          this.setFetching({ fetching: false })

          /**
          * Sets the global feedback message
          */
          this.setMessage({ type: 'success', message: 'Product was updated' })
        })
      },
      reset() {
        this.product.id = 0
        this.product.category = 1
        this.product.name = ''
      },
    },
  }
</script>

<template>
  <div class="well">
    <el-form ref="form" :model="product" label-width="120px">
      <el-form-item label="Product name">
        <el-input v-model="product.name"></el-input>
      </el-form-item>
      <el-form-item label="Category">
        <el-select v-model="product.category" placeholder="Select Category" filterable>
          <el-option
            v-for="category in categories"
            :label="category.name"
            :value="category.id">
          </el-option>
        </el-select>
        <el-button @click="submit">Save</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>
