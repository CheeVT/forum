<template>
  <div :id="`reply-${reply.id}`" class="card">
    <div class="card-header article-header">
      <div class="article-header--title">
        <a :href="`/profiles/${reply.user.name}`" v-text="reply.user.name"></a> - 
        {{ reply.created_at }}
      </div>
      <!-- @if(Auth::check())
       <div>
        <favorite :reply="{{ $reply }}"></favorite>
      </div>
      @endif -->
    </div>
    <div class="card-body">
      <div v-if="editing">
        <div class="form-group">
          <textarea v-model="body" class="form-control"></textarea>
        </div>
        <button class="btn btn-xs btn-primary" @click="update">Update</button>
        <button class="btn btn-xs btn-link" @click="editing = false">Cancel</button>
      </div>
      <div v-else v-text="body"></div>
    </div>
    <!-- @can ('delete', $reply) -->
      <div class="panel-footer panel-footer--reply">
          <button class="btn btn-sm mr-1" @click="editing = true">Edit</button>
          <button class="btn btn-sm btn-danger mr-1" @click="destroy">Delete</button>
      </div>
    <!-- @endcan -->
  </div>
</template>
<script>

import FavoriteComponent from './FavoriteComponent';

export default {
  props: ['data'],
  components: { FavoriteComponent },
  data() {
    return {
      editing: false,
      body: this.data.body,
      reply: this.data
    };
  },
  methods: {
    update() {
      axios.patch(`/replies/${this.data.id}`, {
        body: this.body
      });

      this.editing = false;

      flashMessage('Reply has been updated!');
    },
    destroy() {
      axios.delete(`/replies/${this.data.id}`).then(response => {
        this.$emit('deleted', this.data.id);
        /*if(response.status == 200) {
          $(this.$el).fadeOut(300, function() {
            flashMessage('Reply has been deleted!');
          })
        }*/
      })
    }
  }
}
</script>