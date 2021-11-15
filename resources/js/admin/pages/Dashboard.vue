<template>
  <div>
    <div class="container-fluid">
      <div id="layout-wrapper">
        <header id="page-topbar">
          <div class="navbar-header">
            <div class="container-fluid">
              <div class="float-right">
                <div class="dropdown d-inline-block d-lg-none ml-2">
                  <button
                    type="button"
                    class="btn header-item noti-icon waves-effect"
                    id="page-header-search-dropdown"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <i class="mdi mdi-magnify"></i>
                  </button>
                  <div
                    class="
                      dropdown-menu dropdown-menu-lg dropdown-menu-right
                      p-0
                    "
                    aria-labelledby="page-header-search-dropdown"
                  >
                    <form class="p-3">
                      <div class="form-group m-0">
                        <div class="input-group">
                          <input
                            type="text"
                            class="form-control"
                            placeholder="Search ..."
                            aria-label="Recipient's username"
                          />
                          <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                              <i class="mdi mdi-magnify"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>



                <div class="dropdown d-inline-block">
                  <button
                    type="button"
                    @click="openProfileDropdown()"
                    class="btn header-item waves-effect"
                    id="page-header-user-dropdown"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >


                    <span class="d-none d-xl-inline-block ml-1">{{this.$churchusername}}</span>
                    <i
                      class="mdi mdi-chevron-down d-none d-xl-inline-block"
                    ></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right">
                    <!-- item-->
                    <a class="dropdown-item" href="#"
                      ><i class="bx bx-user font-size-16 align-middle mr-1"></i>
                      Profile</a
                    >


                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger"  @click="logout"  href="#"
                      ><i
                        class="
                          bx bx-power-off
                          font-size-16
                          align-middle
                          mr-1
                          text-danger
                        "
                      ></i>
                      Logoutt</a
                    >
                  </div>
                </div>

              </div>
              <div>
                <!-- LOGO -->
                <div class="navbar-brand-box">


                </div>

                <button
                  type="button"
                  class="
                    btn btn-sm
                    px-3
                    font-size-16
                    header-item
                    toggle-btn
                    waves-effect
                  "
                  id="vertical-menu-btn"
                >
                  <i class="fa fa-fw fa-bars"></i>
                </button>


              </div>
            </div>
          </div>
        </header>

        <sidebar></sidebar>

        <div class="main-content">
          <router-view> </router-view>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Form from "vform";
export default {
  mounted() {},

  methods: {
    openProfileDropdown(E) {
      $("#page-header-user-dropdown").dropdown("toggle");
    },
    openSettingsDropDown(E) {
      $("#page-header-user-dropdown").dropdown("toggle");
    },
    // CurrentDate() {
    //   return Date().getFullYear();
    // },
    logout(e) {
      e.preventDefault();
      delete axios.defaults.headers.common["Authorization"];
      localStorage.removeItem("bakeryadminmask");
      localStorage.removeItem("bakeryadminusername");
      localStorage.removeItem("bakeryadmintoken");
      window.location.replace("/admin-login");
    },
  },
};
</script>

<style lang="scss" scoped>
.active {
  color: red;
}
</style>
