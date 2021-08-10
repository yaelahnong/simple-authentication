<script>

import axios from 'axios';

export default {
  name: 'Authentication',
  data() {
    return {
      formLogin: {
        username: '',
        password: '',
      },
      tfaCode: '',
      message: '',
      alert: '',
    };
  },
  methods: {
    async submitAuth() {
      try {
        const res = await axios.post(`${process.env.VUE_APP_API_URL}/auth`, this.formLogin);
        const { tfa } = res.data.data;
        if (res.data.success) {
          if (tfa) {
            this.$store.tfa = true;
            this.$router.push({ name: 'Bo2FA' });
          } else {
            localStorage.setItem('logged', 'Y');
            localStorage.setItem('api_token', res.data.token);
            this.message = res.data.message;
            setTimeout(() => {
              this.message = '';
              this.$router.go('/');
            }, 1000);
          }
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
      }
    },
  },
};
</script>

<template>
  <div class="main-wrapper">
    <!-- Content Body Start -->
    <div class="content-body m-0 p-0">
      <div class="login-register-wrap">
        <div class="row">
          <div
            class="
            d-flex align-self-center justify-content-center order-2 order-lg-1 col-lg-5 col-12"
          >
            <div class="login-register-form-wrap">
              <div class="content">
                <h1>Sign in</h1>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
              </div>

              <div class="login-register-form">
                <form>
                  <div class="row">
                    <div v-if="message.length > 0" class="col-12">
                      <div :class="`alert alert-${alert || 'info'}`" role="alert">
                        {{message}}
                      </div>
                    </div>
                    <div class="col-12 mb-3">
                      <input
                        v-model="formLogin.username"
                        class="form-control"
                        type="text"
                        placeholder="Username"
                      />
                    </div>
                    <div class="col-12 mb-3">
                      <input
                        v-model="formLogin.password"
                        class="form-control"
                        type="password"
                        placeholder="Password"
                      />
                    </div>
                    <!-- <div class="col-12 mb-3">
                      <label for="remember" class="adomx-checkbox-2"
                        ><input id="remember" type="checkbox" /><i class="icon"></i>Remember.</label
                      >
                    </div> -->
                    <div class="col-12">
                      <div class="row justify-content-between">
                        <div class="col-auto mb-3">
                          <router-link to="/forgot-password">Forgot Password?</router-link>
                        </div>
                        <!-- <div class="col-auto mb-3">
                          Dont have account? <a href="register.html">Create Now.</a>
                        </div> -->
                      </div>
                    </div>
                    <div class="col-12 mt-2">
                      <button
                        class="btn btn-outline-primary"
                        @click.prevent="submitAuth"
                      >
                        sign in
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <div class="login-register-bg order-1 order-lg-2 col-lg-7 col-12">
            <div class="content">
              <h1>Sign in</h1>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Content Body End -->
  </div>
</template>
