
<script>
  export default {
    props: ['pager'],
    computed: {
      pages() {
        return Math.ceil(this.pager.total / this.pager.per_page)
      },
    },
    methods: {
      navigate(page) {
        this.$bus.$emit('navigate', { page })
      },
    },
  }
</script>

<template>
  <div>
    <nav aria-label="Page navigation">
      <ul class="pagination">
        <li>
          <a href="#" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        <li v-for="page in pages">
          <a href="#" @click.prevent="navigate(page)">{{ page }}</a>
        </li>
        <li>
          <a href="#" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</template>
