<script>
import CcNavBar from './modules/general/navbar'
import CcAlerts from './modules/general/alerts'

export default {
  name: 'Application',
  components: {
    CcNavBar,
    CcAlerts,
  },
  computed: {
    shouldShowNavigation() {
      return this.$route.name !== 'login.index'
    },
  },
}
</script>

<template>
  <div id="app">
    <cc-nav-bar v-show="shouldShowNavigation"></cc-nav-bar>
    <cc-alerts></cc-alerts>
    <div class="container">
      <router-view></router-view>
    </div>
  </div>
</template>

<style lang="sass" src="assets/sass/app.scss"></style>
