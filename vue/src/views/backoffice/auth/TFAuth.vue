<script>
import axios from 'axios';

export default {
  name: 'Bo2FA',
  data() {
    return {
      tfaCode: '',
      message: '',
      alert: '',
    };
  },
  mounted() {
    console.log(this.$store.tfa);
  },
  methods: {
    async submit2fa() {
      try {
        const res = await axios.post(
          `${process.env.VUE_APP_API_URL}/two-factor`,
          { tfaCode: this.tfaCode },
        );
        if (res.data.success) {
          localStorage.setItem('logged', 'Y');
          localStorage.setItem('api_token', res.data.token);
          this.message = res.data.message;
          setTimeout(() => {
            this.message = '';
            this.$router.go('/');
          }, 1000);
        }
        console.log(res);
      } catch (error) {
        if (error.response.status === 401) {
          this.message = error.response.data.message;
          this.alert = error.response.data.alert;
          setTimeout(() => {
            this.message = '';
            this.alert = '';
          }, 2000);
        }
      }
    },
  },
  watch: {
    tfaCode(v) {
      this.tfaCode = v.replace(/([^0-9]+)+/i, '');
    },
  },
};
</script>

<template>
  <div class="container d-flex justify-content-center text-center my-5">
      <div class="login-register-form-wrap my-5">
        <div class="content">
          <h1>Two Factor Authentication</h1>
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
                  v-model="tfaCode"
                  class="form-control"
                  type="text"
                  placeholder="6 digit code"
                  maxlength="6"
                />
              </div>
              <div class="col-12">
                <button
                  v-if="!isLoading"
                  class="btn w-100 btn-primary mb-3"
                  @click.prevent="submit2fa"
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
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Content Body End -->
</template>
