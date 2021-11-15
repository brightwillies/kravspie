<template>
  <div>
    <div class="account-pages my-5 pt-sm-5">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card overflow-hidden">
              <div class="bg-login text-center">
                <div class="bg-login-overlay"></div>
                <div class="position-relative">
                  <h5 class="text-white font-size-20">Welcome Back !</h5>
                  <p class="text-white-50 mb-0">Sign in.</p>
                  <a href="/" class="logo logo-admin mt-4">
                    <img
                      src="/adassets/images/logo-sm-dark.png"
                      alt=""
                      height="30"
                    />
                  </a>
                </div>
              </div>
              <div class="card-body pt-5">
                <div class="p-2">
                  <form    @submit.prevent="login"  class="form-horizontal">
                    <div class="form-group">
                      <label for="username">Email</label>
                      <input
                        v-model="form.email"
                        type="text"
                        class="form-control"
                        id="username"
                        placeholder="Enter email"
                      />
                    </div>

                    <div class="form-group">
                      <label for="userpassword">Password</label>
                      <input
                        v-model="form.password"
                        type="password"
                        class="form-control"
                        id="userpassword"
                        placeholder="Enter password"
                      />
                    </div>



                    <div class="mt-3">
                      <button
                        class="
                          btn btn-primary btn-block
                          waves-effect waves-light
                        "
                        type="submit"
                      >
                        Log In
                      </button>
                    </div>

                    <div class="mt-4 text-center">
                      <a href="/admin-forgot-password" class="text-muted"
                        ><i class="mdi mdi-lock mr-1"></i> Forgot your
                        password?</a
                      >
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
$(document).ready(function () {
  $(window).on("scroll", function () {
    if ($(this).scrollTop() > 150) {
      $(".scroll-btn").addClass("no-display");
    } else {
      $(".scroll-btn").removeClass("no-display");
    }
  });
});
</script>
<script>
import axios from "axios";
import Form from "vform";
import store from "../store";
import { mixin } from "../mixin";
export default {
  mixins: [mixin],
  data() {
    return {
      form: new Form({
        email: "",
        password: "",
      }),
    };
  },
  methods: {
    login() {
      var vm = this;
      let formData = new FormData();
      formData.append("email", this.form.email);
      formData.append("password", this.form.password);
      axios
        .post("/api/v1/admin/auth/login", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then(
          (response) => {
            if (response) {
              const res = response.data;

              if (res.code == 200) {
                var userData = res.data;
                localStorage.setItem("bakeryadminmask", userData.user.mask);
                localStorage.setItem("bakeryadminusername", userData.user.first_name);
                localStorage.setItem("bakeryadmintoken", userData.token);
                axios.defaults.headers.common["Authorization"] =
                  "Bearer " + userData.token;
                store.commit("loginUser");
                this.successToastRedirect(res.message, "/admin-dashboard");
              } else {
                vm.$toasted.show(res.message);
              }
            }
          },
          function (error) {
            vm.isActive = false;

            if (error.response) {
              console.log(error.response.data.errors);
              error.response.data.errors.forEach((element) => {
                vm.$toasted.show(element);
              });
              // alert(error.response.status);
            }
          }
        );
    },
  },
};
</script>

<style scoped>
.float-btn-scroll {
  position: fixed;
  width: 60px;
  height: 60px;
  bottom: 40px;
  left: 40px;
  background-color: rgb(252, 249, 250);
  color: red;
  border-radius: 50px;
  text-align: center;
  box-shadow: 20px 20px 60px #bebebe, -20px -20px 60px #ffffff;
  animation: bounceTop_01 4s linear infinite;
}
</style>
