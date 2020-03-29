<template>
  <div :id="`reply-${reply.id}`" class="card">
    <div class="card-header article-header">
      <div class="article-header--title">
        <a :href="`/profiles/${reply.user.name}`" v-text="reply.user.name"></a> - 
        <span v-text="createdAt"></span>
      </div>

       <div v-if="loggedIn">
        <favorite :reply="reply"></favorite>
      </div>

    </div>
    <div class="card-body">
      <div v-if="editing">
        <form @submit.prevent="update">
          <div class="form-group">
            <textarea v-model="body" class="form-control" required></textarea>
          </div>
          <button class="btn btn-xs btn-primary">Update</button>
          <button class="btn btn-xs btn-link" @click="editing = false" type="button">Cancel</button>
        </form>
      </div>
      <div v-else v-text="body"></div>
    </div>
    <!-- @can ('delete', $reply) -->
      <div class="panel-footer panel-footer--reply" v-if="canUpdate">
          <button class="btn btn-sm mr-1" @click="editing = true">Edit</button>
          <button class="btn btn-sm btn-danger mr-1" @click="destroy">Delete</button>
      </div>
    <!-- @endcan -->
  </div>
</template>
<script>

import FavoriteComponent from './FavoriteComponent';
import moment from 'moment';

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
  computed: {
    loggedIn() {
      return window.App.loggedIn;
    },
    canUpdate() {
      return this.authorize(user => this.data.user_id == user.id);
    },
    createdAt() {
      return moment(this.data.created_at).fromNow();
    }
  },
  methods: {
    update() {
      axios.patch(`/replies/${this.data.id}`, {
        body: this.body
      }).then(response => {
        this.editing = false;

        flashMessage('Reply has been updated!');
      }).catch(error => {
        flashMessage(error.response.data, 'danger');
      })

      
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