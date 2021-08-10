<script>
import axios from 'axios';

export default {
  name: 'Dashboard',
  data() {
    return {
      user: {},
    };
  },
  methods: {
    handleLogout() {
      if (window.confirm('Are you sure?')) {
        localStorage.clear();
        alert('Session end, please login');
        this.$router.go('/auth');
      }
    },
    async getDetailUser() {
      try {
        const res = await axios.get(`
          ${process.env.VUE_APP_API_URL}/bo/user?api_token=${localStorage.getItem('api_token')}`);
        if (res.data.success) {
          this.user = res.data.data;
        }
      } catch (error) {
        if (error.response.status === 401) {
          localStorage.removeItem('logged');
          this.$router.go('/auth');
        }
      }
    },
  },
  mounted() {
    this.getDetailUser();
  },
};
</script>

<template>
  <Fragment>
    <h1>Hello {{user.bu_name}} !</h1>
    <button @click.prevent="handleLogout">Logout</button>
  </Fragment>
</template>
