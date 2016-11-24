
<script>
  export default {
    props: ['pager', 'current-page', 'max-items'],
    computed: {
      pages() {
        return this.generatePagesArray(
          this.currentPage, this.pager.total, this.pager.per_page, this.maxItems)
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
      generatePagesArray(currentPage, collectionLength, rowsPerPage, maxItems) {
        const pages = []
        const totalPages = Math.ceil(collectionLength / rowsPerPage)
        const halfWay = Math.ceil(maxItems / 2)
        const ellipsesNeeded = maxItems < totalPages
        let position

        if (currentPage <= halfWay) {
          position = 'start'
        } else if (totalPages - halfWay < currentPage) {
          position = 'end'
        } else {
          position = 'middle'
        }

        let i = 1
        while (i <= totalPages && i <= maxItems) {
          const pageNumber = this.calculatePageNumber(i, currentPage, maxItems, totalPages)
          const openingEllipsesNeeded = (i === 2 && (position === 'middle' || position === 'end'))
          const closingEllipsesNeeded = (i === maxItems - 1 && (position === 'middle' || position === 'start'))
          if (ellipsesNeeded && (openingEllipsesNeeded || closingEllipsesNeeded)) {
            pages.push('...')
          } else {
            pages.push(pageNumber)
          }
          i += 1
        }
        return pages
      },
      calculatePageNumber(i, currentPage, maxItems, totalPages) {
        const halfWay = Math.ceil(maxItems / 2)

        if (i === maxItems) {
          return totalPages
        } else if (i === 1) {
          return i
        } else if (maxItems < totalPages) {
          if (totalPages - halfWay < currentPage) {
            return (totalPages - maxItems) + i
          } else if (halfWay < currentPage) {
            return (currentPage - halfWay) + i
          }
          return i
        }
        return i
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
