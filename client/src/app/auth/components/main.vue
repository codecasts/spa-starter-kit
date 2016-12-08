<template>
  <div class="container">
    <header class="page-header">
      <h3>Codecasts - SPA - Starter Kit</h3>
    </header>
    <div class="col-md-4">
      <ul class="nav nav-pills nav-stacked">
        <router-link tag="li" :to="{ name: 'auth.singin' }">
          <a>Sing in</a>
        </router-link>
        <router-link tag="li" :to="{ name: 'auth.singup' }">
          <a>Sing up</a>
        </router-link>
      </ul>
    </div>
    <div class="col-md-8">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
export default {
}
</script>

<style lang="css">
</style>
