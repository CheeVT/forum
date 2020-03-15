<template>
  <div>
    <div v-for="(reply, index) in items" :key="reply.id">
      <reply :data="reply" @deleted="remove(index)"></reply>
    </div>

    <new-reply :endpoint="endpoint" @created="add"></new-reply>
  </div>
</template>

<script>
import Reply from './ReplyComponent';
import NewReply from './NewReplyComponent';
export default {
  props: ['data', 'threadId'],
  components: { Reply, NewReply },
  data() {
    return {
      items: this.data,
      endpoint: `/threads/${this.threadId}/replies`
    }
  },
  methods: {
    add(reply) {
      this.items.push(reply);

      this.$emit('added');
    },
    remove(index) {
      this.items.splice(index, 1);

      this.$emit('removed');

      flashMessage('Reply has been deleted!');
    }
  }
}
</script>