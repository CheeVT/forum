<template>
  <button :class="classes" @click="toggleFavorite">
    <span class="glyphicon glyphicon-heart"></span>
    <span v-text="count"></span>
  </button>
</template>

<script>
export default {
  props: ['reply'],
  data() {
    return {
      count: this.reply.favoritesCount,
      isFavorited: this.reply.isFavorited
    }
  },

  computed: {
    classes() {
      return [
        'btn',
        this.isFavorited ? 'btn-warning' : 'btn-outline-primary'
      ]
    },

    endpoint() {
      return `/replies/${this.reply.id}/favorites`;
    }
  },

  methods: {
    toggleFavorite() {
      this.isFavorited ? this.unfavorite() : this.favorite();
    },

    favorite() {
      axios.post(this.endpoint).then(response => {
        this.isFavorited = true;
        this.count++;
        flashMessage('Reply has been favorited!');
      })
    },

    unfavorite() {
      axios.delete(this.endpoint).then(response => {
        this.isFavorited = false;
        this.count--;
        flashMessage('Reply has been unfavorited!');
      })
    }
  }
}
</script>