export default {
  data() {
    return {
      items: []
    }
  },
  methods: {
    add(items) {
      console.log('ITEMMM', items)
      this.items.push(items);
      console.log('ADDD', this.items)
      this.$emit('added');
    },
    remove(index) {
      this.items.splice(index, 1);

      this.$emit('removed');

      flashMessage('Reply has been deleted!');
    }
  }
}