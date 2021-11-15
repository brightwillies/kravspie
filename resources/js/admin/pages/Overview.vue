<template>
  <div>
    <div class="page-content">
      <!-- start page title -->
      <div class="row">
        <div class="col-12">
          <div
            class="
              page-title-box
              d-flex
              align-items-center
              justify-content-between
            "
          >
            <h4 class="page-title mb-0 font-size-18">Dashboard</h4>

            <div class="page-title-right">
              <ol class="breadcrumb m-0">
                <li class="breadcrumb-item active">
                  Welcome to KravsPie Dashboard
                </li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <!-- end page title -->

      <div class="row">
        <div class="col-xl-4">
          <div class="card">
            <div class="card-body">
              <div class="media">
                <div class="avatar-sm font-size-20 mr-3">
                  <span
                    class="avatar-title bg-soft-primary text-primary rounded"
                  >
                    <i class="mdi mdi-tag-plus-outline"></i>
                  </span>
                </div>
                <div class="media-body">
                  <div class="font-size-16 mt-2">Total Orders</div>
                </div>
              </div>
              <h4 class="mt-4">{{ totalOrders }}</h4>
              <div class="row">
                <div class="col-7"></div>
                <div class="col-5 align-self-center">
                  <div class="progress progress-sm">
                    <div
                      class="progress-bar bg-primary"
                      role="progressbar"
                      style="width: 62%"
                      aria-valuenow="62"
                      aria-valuemin="0"
                      aria-valuemax="100"
                    ></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4">
          <div class="card">
            <div class="card-body">
              <div class="media">
                <div class="avatar-sm font-size-20 mr-3">
                  <span
                    class="avatar-title bg-soft-primary text-primary rounded"
                  >
                    <i class="mdi mdi-account-multiple-outline"></i>
                  </span>
                </div>
                <div class="media-body">
                  <div class="font-size-16 mt-2">Completed Orders </div>
                </div>
              </div>
              <h4 class="mt-4">{{ completedOrders }}</h4>
              <div class="row">
                <div class="col-7"></div>
                <div class="col-5 align-self-center">
                  <div class="progress progress-sm">
                    <div
                      class="progress-bar bg-success"
                      role="progressbar"
                      style="width: 62%"
                      aria-valuenow="62"
                      aria-valuemin="0"
                      aria-valuemax="100"
                    ></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4">
          <div class="card">
            <div class="card-body">
              <div class="media">
                <div class="avatar-sm font-size-20 mr-3">
                  <span
                    class="avatar-title bg-soft-primary text-primary rounded"
                  >
                    <i class="mdi mdi-account-multiple-outline"></i>
                  </span>
                </div>
                <div class="media-body">
                  <div class="font-size-16 mt-2">Pending Orders</div>
                </div>
              </div>
              <h4 class="mt-4">{{ pendingOrders }}</h4>
              <div class="row">
                <div class="col-7"></div>
                <div class="col-5 align-self-center">
                  <div class="progress progress-sm">
                    <div
                      class="progress-bar bg-success"
                      role="progressbar"
                      style="width: 62%"
                      aria-valuenow="62"
                      aria-valuemin="0"
                      aria-valuemax="100"
                    ></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- end row -->


    </div>
  </div>
</template>

<script>
export default {
  mounted() {

    this.getCount();

  },
  data() {
    return {

      totalOrders :0,
      completedOrders :0,
      pendingOrders :0,
      tableData: [],

    };
  },
  methods: {
    getCount() {
      var vm = this;
      axios
        .get("/api/v1/admin/stats")
        .then(({ data }) => {
          this.totalOrders = data.data.totalOrders;
          this.completedOrders = data.data.completedOrders;
          this.pendingOrders = data.data.pendingOrders;
        })
        .catch(function (error) {
          console.log(error);
        });
    },


  },
};
</script>

<style scoped>
</style>
