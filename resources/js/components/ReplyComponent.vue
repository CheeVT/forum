<template>
  <div :id="`reply-${reply.id}`" class="card" :class="isBest ? 'text-white bg-info' : ''">
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
            <!-- <textarea v-model="body" class="form-control" required></textarea> -->
            <wysiwyg v-model="body"></wysiwyg>
          </div>
          <button class="btn btn-xs btn-primary">Update</button>
          <button class="btn btn-xs btn-link" @click="editing = false" type="button">Cancel</button>
        </form>
      </div>
      <div v-else v-html="body"></div>
    </div>
    <!-- @can ('delete', $reply) -->
      <div class="panel-footer panel-footer--reply" v-if="authorize('owns', reply) || authorize('owns', reply.thread)">
        <button class="btn btn-sm btn-primary ml-1 mr-a" @click="markBestReply" v-show="authorize('owns', reply.thread) && ! isBest">Best Reply?</button>

        <div v-if="authorize('owns', reply)">
          <button class="btn btn-sm mr-1" @click="editing = true">Edit</button>
          <button class="btn btn-sm btn-danger mr-1" @click="destroy">Delete</button>
        </div>
          
      </div>
    <!-- @endcan -->
  </div>
</template>
<script>

import FavoriteComponent from './FavoriteComponent';
import moment from 'moment';

export default {
  props: ['dataReply'],
  components: { FavoriteComponent },
  data() {
    return {
      editing: false,
      body: this.dataReply.body,
      isBest: this.dataReply.isBest,
      reply: this.dataReply
    };
  },
  computed: {
    /*loggedIn() {
      return window.App.loggedIn;
    },
    canUpdate() {
      return this.authorize(user => this.data.user_id == user.id);
    },*/
    createdAt() {
      return moment(this.dataReply.created_at).fromNow();
    }
  },
  created() {
    window.events.$on('best-reply-selected', id => {
      this.isBest = (id === this.reply.id);
    });
  },
  methods: {
    update() {
      axios.patch(`/replies/${this.dataReply.id}`, {
        body: this.body
      }).then(response => {
        this.editing = false;

        flashMessage('Reply has been updated!');
      }).catch(error => {
        flashMessage(error.response.dataReply, 'danger');
      })

      
    },
    destroy() {
      axios.delete(`/replies/${this.dataReply.id}`).then(response => {
        this.$emit('deleted', this.dataReply.id);
        /*if(response.status == 200) {
          $(this.$el).fadeOut(300, function() {
            flashMessage('Reply has been deleted!');
          })
        }*/
      })
    },
    markBestReply() {
      axios.post(`/replies/${this.dataReply.id}/best`);

      window.events.$emit('best-reply-selected', this.dataReply.id);
    }
  }
}
</script>