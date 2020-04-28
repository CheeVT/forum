<script>
import Replies from '../components/RepliesComponent';
import Subscribe from '../components/SubscribeComponent';
export default {
  props: ['initialRepliesCount', 'thread'],
  components: { Replies, Subscribe },

  data() {
    return {
      repliesCount: this.thread_replies_count,
      locked: this.thread.locked,
      title: this.thread.title,
      body: this.thread.body,
      form: {},
      editing: false,
    }
  },
  created() {
    this.resetForm();
  },
  methods: {
    toggleLock() {
      axios[this.locked ? 'delete' : 'post'](`/locked-threads/${this.thread.slug}`);

      this.locked = ! this.locked;
    },

    update() {
      let uri = `/threads/${this.thread.board.slug}/${this.thread.slug}`;

      axios.patch(uri, this.form).then(() => {
        this.editing = false;
        this.title = this.form.title;
        this.body = this.form.body;

        flashMessage('Your thread has been updated!');
      })
    },

    resetForm() {
      this.form = {
        title: this.thread.title,
        body: this.thread.body
      };

      this.editing = false;
    }
  }
}
</script>