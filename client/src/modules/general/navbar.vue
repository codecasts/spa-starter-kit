
<template>
  <div>
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="/">
            Codecasts
          </a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <router-link tag="li" :to="{ name: 'dashboard.index' }" exact>
              <a>Dashboard</a>
            </router-link>
            <router-link tag="li" :to="{ name: 'categories.index' }">
              <a>Categorias</a>
            </router-link>
          </ul>
        </div>
      </div>
    </nav>
  </div>
</template>
