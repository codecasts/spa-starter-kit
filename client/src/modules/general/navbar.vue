
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
            <li>
              <router-link :to="{ name: 'dashboard.index' }">Dashboard</router-link>
            </li>
            <li>
              <router-link :to="{ name: 'categories.index' }">Categorias</router-link>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </div>
</template>
