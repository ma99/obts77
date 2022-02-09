<template>
  <div class="login-box">
    <div class="login-logo">
      <a href="../../index2.html"><b>Admin</b>LTE</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form action="../../index3.html" method="post">
          <div class="input-group mb-3">
            <input v-model="form.phone" type="phone" name="phone" class="form-control" placeholder="Phone" required autofocus>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-phone"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input v-model="form.password" type="password" name="password" class="form-control" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <!-- <div class="icheck-primary">
                <input type="checkbox" id="remember">
                <label for="remember">
                  Remember Me
                </label>
              </div> -->
              <div class="custom-control custom-checkbox">
                <input v-model="form.remember" type="checkbox" class="custom-control-input" id="remember">
                <label class="custom-control-label" for="remember">Remember Me</label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block" @click.prevent="login()">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <!-- <div class="social-auth-links text-center mb-3">
          <p>- OR -</p>
          <a href="#" class="btn btn-block btn-primary">
            <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
          </a>
          <a href="#" class="btn btn-block btn-danger">
            <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
          </a>
        </div> -->
        <!-- /.social-auth-links -->

        <p class="mb-1">
          <a href="forgot-password.html">I forgot my password</a>
        </p>
        <p class="mb-0">
          <a href="register.html" class="text-center">Register a new membership</a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
</template>

<script>
    export default {
        data() {
            return {                     
              form: {
                phone: '',
                password: '',
                remember: false
              },       
            }
        },
        mounted() {
          this.toggleBodyClass('add', ['hold-transition', 'login-page']);           
        },
        unmounted() {
          this.toggleBodyClass('remove', ['hold-transition', 'login-page']);
        },
        methods: {
          toggleBodyClass(actionType, className) {
                const el = document.body;                
                el.classList[actionType](...className);
          },

          login() {
            axios.post('login', this.form)
            .then(response => {
              console.log(response.data)
              console.log('success')
              this.$router.push('/')

            })
            .catch(error => {
              console.log(error.response.data);
            });
          }
        }
    }
</script>
