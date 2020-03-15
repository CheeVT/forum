<template>
<div>
  <div v-if="loggedIn" class="reply-store">
    <div class="form-group">
      <label for="body">Add reply</label>
      <textarea 
        name="body" 
        id="body" 
        rows="10" 
        class="form-control" 
        placeholder="If you have something to say, fill in and submit :-)"
        required
        v-model="body">
      </textarea>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-primary" @click="addReply">Add</button>
    </div>
  </div>

  <div v-else>
     <p>Please <a href="/login">log in</a> if you want to reply to this topic!</p>
  </div>
</div>
</template>

<script>
export default {
  props: ['endpoint'],
  data() {
    return {
      body: ''
    }
  },
  computed: {
    loggedIn() {
      return window.App.loggedIn;
    }
  },
  methods: {
    addReply() {
      axios.post(this.endpoint, {body: this.body}).then(response => {
        this.body = '';
        flashMessage('Reply has been created!');
        this.$emit('created', response.data)
      });
    }
  }
}
</script>