<template>
  <div>
    <button :class="classes" @click="subscribe">Subscribe</button>
  </div>
</template>

<script>
export default {
  props: ['isSubscribedTo'],
  computed: {
    classes() {
      return ['btn', this.isSubscribedTo ? 'btn-primary' : 'btn-outline-primary']
    }
  },
  methods: {
    subscribe() {
      axios.post(`${location.pathname}/subscriptions`).then(response => {
        this.isSubscribedTo = ! this.isSubscribedTo
      });
    }
  }
}
</script>