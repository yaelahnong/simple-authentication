<script>
import axios from 'axios';

export default {
  name: 'ResetPassword',
  data() {
    return {
      formResetPassword: {
        password: '',
        password_confirmation: '',
      },
      message: '',
      alert: '',
    };
  },
  mounted() {
    this.validateToken();
  },
  methods: {
    validateToken() {
      if (!this.$route.query.token) {
        this.$router.push('/auth');
      }
      axios.get(`
        ${process.env.VUE_APP_API_URL}/validate-token?token=${this.$route.query.token}
      `).catch(() => {
        this.$router.push('/auth');
      });
    },
    async submitResetPassword() {
      try {
        const res = await axios.post(`
          ${process.env.VUE_APP_API_URL}/reset-password?token=${this.$route.query.token}`, this.formResetPassword);
        if (res.data.success) {
          this.message = res.data.message;
          setTimeout(() => {
            this.$router.push('/auth');
          }, 1000);
        }
      } catch (error) {
        if (error.response.status === 422) {
          const [message] = error.response.data.password;
          this.message = message;
          this.alert = 'danger';
          setTimeout(() => {
            this.message = '';
            this.alert = '';
          }, 2000);
        }
      }
    },
  },
};
</script>

<template>
  <div class="container d-flex justify-content-center text-center my-5">
    <div class="login-register-form-wrap my-5">
      <div class="content">
        <h1>Reset Password</h1>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
      </div>

      <div class="login-register-form">
        <form>
          <div class="row">
            <div v-if="message.length > 0" class="col-12">
              <div :class="`alert alert-${alert || 'info'} text-start`" role="alert">
                {{message}}
              </div>
            </div>
            <div class="col-12 mb-3">
              <input
                v-model="formResetPassword.password"
                class="form-control"
                type="password"
                placeholder="New Password"
              />
            </div>
            <div class="col-12 mb-3">
              <input
                v-model="formResetPassword.password_confirmation"
                class="form-control"
                type="password"
                placeholder="Re-Type Password"
              />
            </div>
            <div class="col-12">
              <button
                class="btn w-100 btn-primary"
                @click.prevent="submitResetPassword"
              >
                submit
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
