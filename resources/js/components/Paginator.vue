<template>
  <div v-if="shouldPaginate">
    <ul class="pagination mt-2">
      <li v-show="prevUrl" class="page-item">
        <a @click.prevent="page--" class="page-link" href="#" aria-label="Previous">
          <span aria-hidden="true">&laquo; Previous</span>
        </a>
      </li>
      <!-- <li class="page-item"><a class="page-link" href="#">1</a></li>
      <li class="page-item"><a class="page-link" href="#">2</a></li>
      <li class="page-item"><a class="page-link" href="#">3</a></li> -->
      <li v-show="nextUrl" class="page-item">
        <a @click.prevent="page++" class="page-link" href="#" aria-label="Next">
          <span aria-hidden="true">Next &raquo;</span>
        </a>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  props: ['dataSet'],
  data() {
    return {
      page: 1,
      prevUrl: false,
      nextUrl: false
    }
  },
  watch: {
    dataSet() {
      this.page = this.dataSet.current_page;
      this.prevUrl = this.dataSet.prev_page_url;
      this.nextUrl = this.dataSet.next_page_url;
    },

    page() {
      this.broadcast().updateUrl();
    }
  },
  computed: {
    shouldPaginate() {
      return !!this.prevUrl || !!this.nextUrl
    }
  },
  methods: {
    broadcast() {
      return this.$emit('fetchByPage', this.page)
    },

    updateUrl() {
      history.pushState(null, null, '?page=' + this.page)
    }
  }
}
</script>