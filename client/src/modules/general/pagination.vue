
<script>
  export default {
    props: ['pager', 'current-page'],
    computed: {
      pages() {
        return Math.ceil(this.pager.total / this.pager.per_page)
      },
    },
    methods: {
      navigate(page) {
        if (page !== this.currentPage) {
          this.dispatch(page)
        }
      },
      navigatePrevious() {
        if (this.currentPage > 1) {
          const page = this.currentPage - 1
          this.dispatch(page)
        }
      },
      navigateNext() {
        if (this.currentPage < this.pages) {
          const page = this.currentPage + 1
          this.dispatch(page)
        }
      },
      dispatch(page) {
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
          <a href="#" aria-label="Previous" @click.prevent="navigatePrevious()">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        <li v-for="page in pages" :class="{ active: currentPage === page }">
          <a href="#" @click.prevent="navigate(page)">{{ page }}</a>
        </li>
        <li>
          <a href="#" aria-label="Next" @click.prevent="navigateNext()">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</template>
