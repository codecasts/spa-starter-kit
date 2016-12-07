
<script>
  import { mapActions } from 'vuex'

  export default {
    name: 'CcProductsForm',

    /**
    * Component's local state
    */
    data() {
      return {
        product: {
          id: 0,
          name: '',
        },
      }
    },

    /**
    * Fetch product when component is first mounted
    */
    mounted() {
      this.fetch()
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
      ...mapActions(['setFetching', 'resetMessages', 'setMessage']),

      /**
      * If there's an ID in the route params
      * then use it to fetch the product
      * from the server
      */
      fetch() {
        this.$refs.firstInput.focus()

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
            const { id: _id, name } = res.data.product // http://wesbos.com/destructuring-renaming/
            this.product.id = _id
            this.product.name = name
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
        this.$http.post('products', { name: this.product.name }).then(() => {
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
        this.product.name = ''
      },
    },
  }
</script>

<template>
  <form @submit.prevent="submit" class="well">
    <div class="form-group">
      <label for="name" class="control-label">Product Name</label>
      <input ref="firstInput" type="text" id="name" class="form-control" v-model="product.name">
    </div>
    <button class="btn btn-primary btn-xs" type="submit">Salvar</button>
  </form>
</template>
