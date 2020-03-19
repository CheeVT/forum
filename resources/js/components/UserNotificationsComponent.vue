<template>
    <li class="nav-item dropdown" v-if="notifications.length">
      <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
        <span class="glyphicon glyphicon-bell"></span>Notifications
      </a>

      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
        <!-- <li v-for="notification in notifications" :key="notification.id"> -->
          <a v-for="notification in notifications" :key="notification.id" :href="notification.data.link" @click="markAsRead(notification)" class="dropdown-item">
            {{ notification.data.message }}
          </a>
        <!-- </li> -->
      </div>
    </li>
</template>

<script>
export default {
  data() {
    return {
      notifications: []
    }
  },
  created() {
    axios.get(`/profiles/${window.App.user.name}/notifications`)
      .then(response => this.notifications = response.data);
  },
  methods: {
    markAsRead(notification) {
      axios.delete(`/profiles/${window.App.user.name}/notifications/${notification.id}`)
    }
  }
}
</script>