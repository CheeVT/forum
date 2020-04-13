<template>
    <button :class="classes" @click="subscribe">Subscribe</button>
</template>

<script>
export default {
  props: ['isSubscribedTo'],
  data() {
    return {
      isSubTo: this.isSubscribedTo
    }
  },
  computed: {
    classes() {
      return ['btn', this.isSubTo ? 'btn-primary' : 'btn-outline-primary']
    }
  },
  methods: {
    subscribe() {
      let requestType = this.isSubTo ? 'delete' : 'post';
      axios[requestType](`${location.pathname}/subscriptions`).then(response => {
        this.isSubTo = ! this.isSubTo
        this.isSubTo ? flashMessage('Subscribed to thread!') : flashMessage('Unsubscribed from thread!')
      });
    }
  }
}
</script>