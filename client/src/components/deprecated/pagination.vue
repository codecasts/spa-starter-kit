
<script>
  export default {
    // https://vuejs.org/v2/guide/components.html#Prop-Validation
    props: {
      paginationData: Object,
      currentPage: {
        type: Number,
        default: 1,
      },
      maxItems: {
        type: Number,
        default: 10,
      },
    },
    mounted() {
      this.enableKeyboardNavigation()
    },
    computed: {
      hasData() {
        return this.paginationData.total !== undefined
      },
      pages() {
        /**
        * The generatePagesArray method will calculate
        * the need of ellipsis (...) in case of a super
        * big array of records
        */
        return this.generatePagesArray(
          this.currentPage,
          this.paginationData.total,
          this.paginationData.per_page,
          parseInt(this.maxItems, 10))
      },
      isLast() {
        return this.currentPage === this.paginationData.total_pages
      },
      isFirst() {
        return this.currentPage === 1
      },
      isOutOfRange() {
        /**
        * ?page= not presente in the URL or present but empty
        */
        if (isNaN(this.currentPage) || this.currentPage === null) {
          return true
        }

        /**
        * ?page=0 or higher than the total number of pages
        */
        return this.currentPage > this.paginationData.total_pages || this.currentPage < 1
      },
      currentRange() {
        let firstItem = (this.paginationData.per_page * (this.currentPage - 1)) + 1
        let lastItem = (this.paginationData.per_page * this.currentPage)

        if (this.paginationData.total < lastItem) {
          lastItem = this.paginationData.total
        }
        if (this.totalPages === 1) {
          firstItem = 1
        }
        if (this.totalPages === 0) {
          firstItem = 0
        }
        return `${firstItem} a ${lastItem}`
      },
    },
    methods: {
      enableKeyboardNavigation() {
        jQuery('body').on('keyup', ({ keyCode }) => {
          if (keyCode === 37) {
            this.navigatePrevious()
          }
          if (keyCode === 39) {
            this.navigateNext()
          }
        })
      },
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
        if (this.isOutOfRange) {
          this.navigate(1)
          return false
        }
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
    <div class="row" v-if="hasData">
      <div class="col-md-6">
        <p class="rangeInformation">Showing {{ currentRange }} of {{ paginationData.total }}</p>
      </div>
      <div class="col-md-6 text-right">
        <nav aria-label="Page navigation">
          <ul class="pagination">
            <li :class="{ disabled: isFirst }">
              <a href="#" aria-label="Previous" @click.prevent="navigatePrevious()">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            <li v-for="page in pages" :class="{ active: currentPage === page }">
              <a v-if="page !== '...'" href="#" @click.prevent="navigate(page)">{{ page }}</a>
              <span v-if="page === '...'">{{ page }}</span>
            </li>
            <li :class="{ disabled: isLast }">
              <a href="#" aria-label="Next" @click.prevent="navigateNext()">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</template>

<style scoped>
  .rangeInformation {
    margin-top: 28px;
  }
</style>
