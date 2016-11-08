<script>
import NavBar from './modules/general/navbar.vue'
export default {
  name: 'Codecasts',
  components: {
    NavBar
  },
  computed: {
      shouldShowNavigation () {
        return this.$route.name !== 'login.index'
      }
  },
}
</script>

<template>
  <div id="app">
    <nav-bar v-show="shouldShowNavigation"></nav-bar>
    <div class="container">
      <router-view></router-view>
    </div>
  </div>
</template>

<style lang="sass" src="assets/sass/app.scss"></style>
