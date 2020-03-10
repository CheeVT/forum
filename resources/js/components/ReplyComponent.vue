<template>

</template>
<script>
export default {
  props: ['attributes'],
  data() {
    return {
      editing: false,
      body: this.attributes.body
    };
  },
  methods: {
    update() {
      axios.patch(`/replies/${this.attributes.id}`, {
        body: this.body
      });

      this.editing = false;

      flashMessage('Reply has been updated!');
    },
    destroy() {
      axios.delete(`/replies/${this.attributes.id}`).then(response => {
        if(response.status == 200) {
          $(this.$el).fadeOut(300, function() {
            flashMessage('Reply has been deleted!');
          })
        }
      })
    }
  }
}
</script>