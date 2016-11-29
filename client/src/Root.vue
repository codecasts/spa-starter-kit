<script>
import CcNavBar from './components/root/navbar'
import CcAlerts from './components/general/alerts'

export default {
  name: 'Codecasts',
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
      <transition name="fade">
        <router-view></router-view>
      </transition>
    </div>
  </div>
</template>

<style lang="sass" src="assets/sass/app.scss"></style>

<style scoped>
  .fade-enter-active, .fade-leave-active {
    transition: opacity .5s ease;
  }
  .fade-enter, .fade-leave-active {
    opacity: 0;
  }
</style>
