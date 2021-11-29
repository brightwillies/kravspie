<template>
  <div>
    <div class="vertical-menu">
      <div class="h-100">
        <!-- <div class="user-wid text-center py-4">


          <div class="mt-3">
            <a href="#" class="text-dark font-weight-medium font-size-16"
              >Patrick Becker</a
            >

          </div>
        </div> -->

        <!--- Sidemenu -->
        <div id="sidebar-menu">
          <!-- Left Menu Start -->
          <ul class="metismenu list-unstyled" id="side-menu">
            <li class="menu-title">Menu</li>

            <li>
              <a href="javascript: void(0);" class="waves-effect">
                <i class="mdi mdi-airplay"></i>
                <span>Dashboard</span>
              </a>
              <ul class="sub-menu" aria-expanded="false">
                <li><a href="/admin-dashboard">Overview</a></li>
              </ul>
            </li>

            <li>
              <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="mdi mdi-flip-horizontal"></i>
                <span>Users Management</span>
              </a>
              <ul class="sub-menu" aria-expanded="false">
                <li>
                  <a href="/admin-dashboard/administrators">Administrators</a>
                </li>
                <li>
                  <a href="/admin-dashboard/customers">Customers</a>
                </li>
                <!-- <li>
                  <a href="/admin-dashboard/roles">System Roles</a>
                </li> -->
                <!-- <li>
                  <a href="/admin-dashboard/users">Users</a>
                </li> -->
              </ul>
            </li>

            <li>
              <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="mdi mdi-flip-horizontal"></i>
                <span>Products</span>
              </a>
              <ul class="sub-menu" aria-expanded="false">
                <li>
                  <a href="/admin-dashboard/all-products">All Products</a>
                </li>
                <li>
                  <a href="/admin-dashboard/new-product">New Product</a>
                </li>
                <li>
                  <a href="/admin-dashboard/categories">Categories</a>
                </li>
                <li>
                  <a href="/admin-dashboard/custom-date">Pickup Dates</a>
                </li>

              </ul>
            </li>

            <li>
              <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="mdi mdi-flip-horizontal"></i>
                <span>Orders</span>
              </a>
              <ul class="sub-menu" aria-expanded="false">
                <li>
                  <a href="/admin-dashboard/new-orders"> News Orders</a>
                </li>
                <li>
                  <a href="/admin-dashboard/old-orders">Completed Orders</a>
                </li>
              </ul>
            </li>








          </ul>
        </div>
        <!-- Sidebar -->
      </div>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped>
</style>
