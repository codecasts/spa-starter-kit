
<script>
  import { mapActions, mapGetters } from 'vuex'
  import { version } from '../../config'
  import CcSpinner from '../general/spinner'

  export default {
    components: {
      CcSpinner,
    },
    computed: {
      ...mapGetters(['currentUser', 'isLogged']),
      version() {
        return version
      },
    },
    watch: {
      isLogged(value) {
        if (value === false) {
          this.$router.push({ name: 'auth.singin' })
        }
      },
    },
    methods: {
      ...mapActions(['logout']),
    },
  }
</script>

<template>
  <div>
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header spacer">
          <a class="navbar-brand" href="http://www.codecasts.com.br/">
            Codecasts.com.br
          </a><br>
          <small class="version">version {{ version }}</small>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <router-link tag="li" :to="{ name: 'dashboard.index' }" exact>
              <a>Dashboard</a>
            </router-link>
            <router-link tag="li" :to="{ name: 'categories.index', query: { page: 1 } }">
              <a>Categories</a>
            </router-link>
            <router-link tag="li" :to="{ name: 'products.index', query: { page: 1 } }">
              <a>Products</a>
            </router-link>
          </ul>
          <div class="nav navbar-form navbar-right">
            <cc-spinner></cc-spinner>
            <span class="username">{{ currentUser.name }}</span>
            <button class="btn btn-default btn-sm" @click="logout">Logout</button>
          </div>
        </div>
      </div>
    </nav>
  </div>
</template>

<style scoped>
  .spacer {
    margin-left: 120px;
  }
  .username {
    padding: 6px 20px;
    border-radius: 20px;
    background-color: #ddd;
    display: inline-block;
  }
  .version {
    position: absolute;
    right: 15px;
    top: 58px;
  }
</style>
