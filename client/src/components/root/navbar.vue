
<script>
  import { mapActions, mapGetters } from 'vuex'
  import CcSpinner from '../general/spinner'
  import { version } from '../../config'

  export default {
    components: {
      CcSpinner,
    },
    computed: {
      /**
      * See src/app/auth/vuex/getters.js
      */
      ...mapGetters(['currentUser', 'isLogged']),
      version() {
        return version
      },
    },
    watch: {
      isLogged(value) { // isLogged changes when the token changes
        if (value === false) {
          this.$router.push({ name: 'auth.signin' })
        }
      },
    },
    methods: {
      /**
      * Makes logout() action available withint this component
      * See /src/app/auth/vuex/actions.js
      */
      ...mapActions(['logout']),
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
    <cc-spinner></cc-spinner>
    <!-- el-menu and its children comes from Element UI -->
    <!-- http://element.eleme.io/#/en-US/component/menu -->
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
        <template slot="title">{{ currentUser.name }}</template>
        <el-menu-item index="logout">Logout</el-menu-item>
      </el-submenu>
    </el-menu>
    <small class="version">version {{ version }}</small>
  </div>
</template>

<style scoped>
  .cc-navigation {
    padding-left: 115px;
    padding-right: 30px;
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
