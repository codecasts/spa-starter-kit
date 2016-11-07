<script>
import NavBar from './modules/general/navbar.vue'
export default {
  name: 'Codecasts',
  components: {
    NavBar
  }
}
</script>

<template>
  <div id="app">
    <nav-bar></nav-bar>
    <div class="container">
      <router-view></router-view>
    </div>
  </div>
</template>

<style lang="sass" src="assets/sass/app.scss"></style>
