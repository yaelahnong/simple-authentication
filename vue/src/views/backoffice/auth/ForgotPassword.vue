<script>
import axios from 'axios';

export default {
  name: 'ForgotPassword',
  data() {
    return {
      email: '',
      message: '',
      alert: '',
    };
  },
  methods: {
    async submitForgotPassword() {
      try {
        const res = await axios.post(`${process.env.VUE_APP_API_URL}/forgot-password`, {
          email: this.email,
        });
        if (res.data.success) {
          this.message = res.data.message;
        }
      } catch (error) {
        if (error.response.status === 401) {
          this.message = error.response.data.message;
          this.alert = error.response.data.alert;
          setTimeout(() => {
            this.message = '';
            this.alert = '';
          }, 2000);
        }
        if (error.response.status === 422) {
          const [message] = error.response.data.email;
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
        <h1>Forgot Password</h1>
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
                v-model="email"
                class="form-control"
                type="text"
                placeholder="Email"
              />
            </div>
            <div class="col-12">
              <button
                v-if="!isLoading"
                class="btn w-100 btn-primary mb-3"
                @click.prevent="submitForgotPassword"
              >
                submit
              </button>
              <button
                v-if="isLoading"
                class="btn w-100 btn-primary mb-3"
                @click.prevent
              >
                submit
              </button>
            </div>
            <div class="col-12">
              <div class="row justify-content-between">
                <div class="col-auto mb-3">
                  <router-link to="/auth">Back to login page</router-link>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
