<script>
import Replies from '../components/RepliesComponent';
import Subscribe from '../components/SubscribeComponent';
export default {
  props: ['initialRepliesCount', 'thread'],
  components: { Replies, Subscribe },

  data() {
    return {
      repliesCount: this.thread_replies_count,
      locked: this.thread.locked
    }
  },
  methods: {
    toggleLock() {
      axios[this.locked ? 'delete' : 'post'](`/locked-threads/${this.thread.slug}`);

      this.locked = ! this.locked;
    }
  }
}
</script>