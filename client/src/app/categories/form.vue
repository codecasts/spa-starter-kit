
<script>
  import { mapActions } from 'vuex'

  export default {
    name: 'CcCategoriesForm',

    /**
    * Component's local state
    */
    data() {
      return {
        category: {
          id: 0,
          name: '',
        },
      }
    },

    /**
    * Fetch category when component is first mounted
    */
    mounted() {
      this.fetch()
    },

    /**
    * Also fetch category every time route changes
    */
    watch: {
      $route: 'fetch',
    },

    /**
    * Determines based on the presence of
    * category id if the current actions
    * is editing instead of creating.
    */
    computed: {
      isEditing() {
        return this.category.id > 0
      },
      isValid() {
        this.resetMessages()
        if (this.category.name === '') {
          this.setMessage({ type: 'error', message: ['Please fill category name'] })
          return false
        }
        return true
      },
    },

    methods: {
      ...mapActions(['setFetching', 'resetMessages', 'setMessage']),

      /**
      * If there's an ID in the route params
      * then use it to fetch the category
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
          * Fetch the category from the server
          */
          this.setFetching({ fetching: true })
          this.$http.get(`categories/${id}`).then((res) => {
            const { id: _id, name } = res.data.data // http://wesbos.com/destructuring-renaming/
            this.category.id = _id
            this.category.name = name
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
        this.$http.post('categories', { name: this.category.name }).then(() => {
          /**
          * This event will notify the world about
          * the category creation. In this case
          * the Category main component will intercept
          * the event and refresh the list.
          */
          this.$bus.$emit('category.created')

          /**
          * Hides the global spinner
          */
          this.setFetching({ fetching: false })

          /**
          * Sets the global feedback message
          */
          this.setMessage({ type: 'success', message: 'New category was created' })

          /**
          * Resets component's state
          */
          this.reset()
        })
      },
      update() {
        this.$http.put(`categories/${this.category.id}`, this.category).then(() => {
          /**
          * This event will notify the world about
          * the category creation. In this case
          * the Category main component will intercept
          * the event and refresh the list.
          */
          this.$bus.$emit('category.updated')

          /**
          * Hides the global spinner
          */
          this.setFetching({ fetching: false })

          /**
          * Sets the global feedback message
          */
          this.setMessage({ type: 'success', message: 'Category was updated' })
        })
      },
      reset() {
        this.category.id = 0
        this.category.name = ''
      },
    },
  }
</script>

<template>
  <div class="well">
    <el-form ref="form" :model="category" label-width="120px">
      <el-form-item label="Category name">
        <el-input v-model="category.name"></el-input>
      </el-form-item>
      <el-button @click="submit">Save</el-button>
    </el-form>
  </div>
</template>
