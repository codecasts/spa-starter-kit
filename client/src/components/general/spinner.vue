
<script>
  import { mapState } from 'vuex'

  export default {
    computed: {
      ...mapState(['fetching']),
    },
  }
</script>

<template>
  <div class="container">
    <i class="fa fa-fw fa-lg fa-circle-o-notch fa-spin" v-show="fetching"></i>
  </div>
</template>

<style scoped>
  .container {
    display: inline-block;
    width: 40px;
    color: #fff;
    position: absolute;
    z-index: 1;
    right: 18px;
    top: 18px;
  }
</style>
