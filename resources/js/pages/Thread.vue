<script>
import Replies from '../components/RepliesComponent';
import Subscribe from '../components/SubscribeComponent';
export default {
  props: ['initialRepliesCount'],
  components: { Replies, Subscribe },

  data() {
    return {
      repliesCount: this.initialRepliesCount
    }
  }
}
</script>