<script>
export default {
}
</script>

<template>
  <div class="container">
    <header class="page-header">
      <h1>CODECASTS - SPA - Starter Kit</h1>
    </header>
    <div class="row">
      <div class="col-md-4">
        <ul class="nav nav-pills nav-stacked">
          <router-link tag="li" :to="{ name: 'auth.singin' }">
            <a>Entrar</a>
          </router-link>
          <router-link tag="li" :to="{ name: 'auth.singup' }">
            <a>Cadastro</a>
          </router-link>
        </ul>
      </div>
      <div class="col-md-8">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>
