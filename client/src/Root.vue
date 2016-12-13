<script>
import { mapGetters } from 'vuex'
import CcNavBar from './components/root/navbar'
import CcAlerts from './components/general/alerts'

export default {
  name: 'Codecasts',
  components: {
    CcNavBar,
    CcAlerts,
  },
  computed: {
    ...mapGetters(['shouldShowNavigation']),
  },
}
</script>

<template>
  <div id="app">
    <cc-nav-bar v-show="shouldShowNavigation"></cc-nav-bar>
    <div class="container">
      <cc-alerts></cc-alerts>
      <router-view></router-view>
    </div>
  </div>
</template>

<style lang="sass" src="assets/sass/app.scss"></style>
