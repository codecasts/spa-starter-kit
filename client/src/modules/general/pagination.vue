
<script>
  export default {
    props: ['pager', 'current-page'],
    computed: {
      pages() {
        return Math.ceil(this.pager.total / this.pager.per_page)
      },
      isLast() {
        return this.currentPage === this.pages
      },
      isFirst() {
        return this.currentPage === 1
      },
    },
    methods: {
      navigate(page) {
        if (page !== this.currentPage) {
          this.dispatch(page)
        }
      },
      navigatePrevious() {
        if (!this.isFirst) {
          this.dispatch(this.currentPage - 1)
        }
      },
      navigateNext() {
        if (!this.isLast) {
          this.dispatch(this.currentPage + 1)
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
        <li :class="{ disabled: isFirst }">
          <a href="#" aria-label="Previous" @click.prevent="navigatePrevious()">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        <li v-for="page in pages" :class="{ active: currentPage === page }">
          <a href="#" @click.prevent="navigate(page)">{{ page }}</a>
        </li>
        <li :class="{ disabled: isLast }">
          <a href="#" aria-label="Next" @click.prevent="navigateNext()">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</template>
