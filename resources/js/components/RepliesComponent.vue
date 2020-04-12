<template>
  <div>
    <div v-for="(reply, index) in items" :key="reply.id">
      <reply :data-reply="reply" @deleted="remove(index)"></reply>
    </div>

    <paginator :dataSet="dataSet" @fetchByPage="fetch"></paginator>

    <new-reply :endpoint="endpoint" @created="add"></new-reply>
  </div>
</template>

<script>
import Paginator from './Paginator';
import Reply from './ReplyComponent';
import NewReply from './NewReplyComponent';
import collection from '../mixins/collection';
export default {
  props: ['repliesstore'],
  components: { Reply, NewReply, Paginator },
  mixins: [collection],
  data() {
    return {
      dataSet: false,
      items: [],
      endpoint: this.repliesstore
    }
  },
  created() {
    this.fetch();
  },
  methods: {
    fetch(page) {
      axios.get(this.url(page))
        .then(this.refresh);
    },

    url(page) {
      if(!page) {
        let queryPage = location.search.match(/page=(\d+)/);
        page = queryPage ? queryPage[1] : 1;
      }
      return `${location.pathname}/replies?page=${page}`;
    },

    refresh(response) {
      this.dataSet = response.data;
      this.items = response.data.data;

      window.scrollTo(0, 0);
    }
  }
}
</script>