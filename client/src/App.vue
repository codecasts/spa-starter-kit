<script>
import NavBar from './modules/general/navbar'
import CcAlerts from './modules/general/alerts'

export default {
  name: 'Codecasts',
  components: {
    NavBar,
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
    <nav-bar v-show="shouldShowNavigation"></nav-bar>
    <cc-alerts></cc-alerts>
    <div class="container">
      <router-view></router-view>
    </div>
  </div>
</template>

<style lang="sass" src="assets/sass/app.scss"></style>
