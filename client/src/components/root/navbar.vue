
<script>
  import { mapActions, mapState } from 'vuex'
  import CcSpinner from '../general/spinner'
  import { version } from '../../config'

  export default {
    components: {
      CcSpinner,
    },
    computed: {
      ...mapState({
        user: state => state.Auth.user,
      }),
      version() {
        return version
      },
    },
    methods: {
      ...mapActions(['setToken', 'setUser']),
      logout() {
        this.setToken('')
        this.setUser({})
        this.$router.push({ name: 'login.index' })
      },
      /* eslint-disable no-undef */
      navigate(name) {
        switch (name) {
          case 'codecasts':
            window.location = 'https://codecasts.com.br/'
            break;
          case 'logout':
            this.logout()
            break;
          default:
            this.$router.push({ name })
            break;
        }
      },
    },
  }
</script>

<template>
  <div>
    <el-menu theme="dark" default-active="1" class="cc-navigation"
      mode="horizontal" @select="navigate">
      <el-menu-item index="codecasts" class="brand">Codecasts.com.br</el-menu-item>
      <el-menu-item index="dashboard.index">Dashboard</el-menu-item>
      <el-submenu index="menu-modules">
        <template slot="title">Modules</template>
        <el-menu-item index="categories.index">Categories</el-menu-item>
        <el-menu-item index="products.index">Products</el-menu-item>
      </el-submenu>
      <el-submenu index="menu-user" class="logout-button">
        <template slot="title">{{ user.name }}</template>
        <el-menu-item index="logout">Logout</el-menu-item>
      </el-submenu>
    </el-menu>
    <small class="version">version {{ version }}</small>
  </div>
</template>

<style scoped>
  .cc-navigation {
    padding-left: 115px;
  }
  .brand {
    font-size: 1.2em;
  }
  .logout-button {
    float: right;
  }
  .version {
    position: absolute;
    right: 15px;
    top: 65px;
  }
</style>
