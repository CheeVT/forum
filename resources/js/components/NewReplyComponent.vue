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
import Tribute from "tributejs";
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
  mounted() {
    let tribute = new Tribute({
      values: function (text, cb) {
        remoteSearch(text, function(users) {
          cb(users)
        })
      },
      lookup: 'name',
      fillAttr: 'name'
    });

    tribute.attach(document.getElementById("body"));

    function remoteSearch(text, cb) {
        var URL = "data.php";
        console.log('TEXT', text)
        axios.get('/api/users?query=' + text).then(response => {
         console.log('response', response)
         if (response.status === 200) {
            var data = response.data;
            console.log('DATA', data)
            cb(data);
          } 
        })
        //xhr = new XMLHttpRequest();
        /*xhr.onreadystatechange = function () {
          if (xhr.readyState === 4) {
            if (xhr.status === 200) {
              var data = JSON.parse(xhr.responseText);
              console.log('DATA', data)
              cb(data);
            } else if (xhr.status === 403) {
              cb([]);
            }
          }
        };*/
        //xhr.open("GET", URL + "?q=" + text, true);
        //xhr.send();        
      }
  },
  methods: {
    addReply() {
      axios.post(this.endpoint, {body: this.body}).then(response => {
        this.body = '';
        flashMessage('Reply has been created!');
        this.$emit('created', response.data)
      }).catch(error => {
        flashMessage(error.response.data, 'danger');
      });
    },
    
  }
}
</script>