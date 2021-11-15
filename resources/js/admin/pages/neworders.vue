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
            <h4 class="page-title mb-0 font-size-18">New Orders</h4>

            <div class="page-title-right">
              <ol class="breadcrumb m-0">
                <li class="breadcrumb-item">
                  <a href="/dashboard">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">New Orders</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <!-- end page title -->
      <div data-repeater-list="group-a">
        <div data-repeater-item="" class="row pull-right">
          <div class="col-lg-9"></div>

          <div class="col-lg-3 align-self-center"></div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <table
                id="datatable-buttons"
                class="table table-bordered dt-responsive nowrap"
                style="
                  border-collapse: collapse;
                  border-spacing: 0;
                  width: 100%;
                "
              >
                <thead>
                  <tr>
                    <th>Customer</th>
                    <th>Number of Items</th>
                    <th>Total Cost</th>
                    <th>Placed On</th>
                    <th>Pickup Date</th>
                    <th>Status</th>
                    <th>Edit</th>
                  </tr>
                </thead>

                <tbody>
                  <tr v-for="singleItem in tableData" :key="singleItem.id">
                    <td>{{ singleItem.customer }}</td>
                    <td>{{ singleItem.number_of_items }}</td>
                    <td>{{ singleItem.amount }}</td>
                    <td>{{ singleItem.placed_on }}</td>
                    <td>{{ singleItem.pickupdate }}</td>
                    <td>{{ singleItem.status_name }}</td>

                    <td>
                      <button @click="showNewModal(singleItem)" class="btn" type="button">
                        <i class="bx bx-edit-alt"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- end col -->
      </div>
    </div>

    <div
      id="newRecordModal"
      class="modal fade bs-example-modal-lg"
      tabindex="-1"
      role="dialog"
      aria-labelledby="myLargeModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title mt-0" id="myLargeModalLabel">
              ORDER DETAILS
            </h5>

            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form @submit.prevent="updateRecord()">
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-4 col-md-4">
                  <div class="form-group">
                    <label for="name">CUSTOMER</label>
                    <h6>{{ form.name }}</h6>
                  </div>
                  <div class="form-group">
                    <label for="name">TELEPHONE NUMBER</label>
                    <h6>{{ form.telephone }}</h6>
                  </div>
                  <div class="form-group">
                    <label for="name">AMOUNT</label>
                    <h6> $ {{ form.amount }}</h6>
                  </div>
                  <div class="form-group">
                    <label for="name">PICKUP DATE</label>
                    <h6>{{ form.pickupdate }}</h6>
                  </div>

                      <div class="form-group mt-5">
                    <div class="row">
                      <div class="col">
                        <h5 class="font-size-14">Status</h5>
                      </div>
                      <div class="col">
                        <div class="form-check">
                          <input
                            v-model="form.status"
                            class="form-check-input"
                            type="radio"
                            name="exampleRadios"
                            id="exampleRadios1"
                            value="1"
                          />
                          <label class="form-check-label" for="exampleRadios1">
                            Done
                          </label>
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-check">
                          <input
                            v-model="form.status"
                            class="form-check-input"
                            type="radio"
                            name="exampleRadios"
                            id="exampleRadios2"
                            value="0"
                          />
                          <label class="form-check-label" for="exampleRadios2">
                            Pending
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-8 col-md-8">
                  <div class="text-center">
                    <h5>ITEMS</h5>
                  </div>
                  <table
                    id="datatable-buttons"
                    class="table table-bordered dt-responsive nowrap"
                    style="
                      border-collapse: collapse;
                      border-spacing: 0;
                      width: 100%;
                    "
                  >
                    <thead>
                      <tr>
                        <th>ITEM</th>
                        <th>QUANTITY</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="singleItem in orderitems" :key="singleItem.id">
                        <td>{{singleItem.name}}</td>
                        <td>{{singleItem.quantity}}</td>

                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-lg-12">
                  <button class="btn btn-primary btn-block mb-3" type="submit">
                    <span >UPDATE ORDER</span>

                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Form from "vform";
import { mixin } from "../mixin";

import "vue-select/dist/vue-select.css";

import vSelect from "vue-select";
export default {
  components: {
    vSelect,
  },
  mixins: [mixin],
  data() {
    return {
      selectedItem: "",

      required: true,
      editmode: false,
      tableData: [],
      orderitems: [],

      form: new Form({
        name: "",
        telephone: "",
        amount: "",
        status: "",
        mask: "",
      }),
    };
  },
  mounted() {
    this.getRecords();

    //    alert('Bright');
  },

  methods: {
    initDatatable() {
      setTimeout(() => {
        $("#datatable-buttons").DataTable({
          pagingType: "full_numbers",
          lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 100, "All"],
          ],
          order: [
            [0, "asc"],
            [3, "desc"],
          ],
          responsive: true,
          destroy: true,
          retrieve: true,
          autoFill: true,
          colReorder: true,
        });
      }, 300);
    },


    getRecords() {
      axios
        .get("/api/v1/admin/orders/new")
        .then(({ data }) => {
          this.tableData = data.data;
          this.initDatatable();
        })
        .catch(function (error) {
          console.log(error);
        });
    },

    updateRecord() {
      var vm = this;
      let formData = new FormData();
      formData.append("status", this.form.status);

      axios
        .post(
          "/api/v1/admin/orders/update/" + this.form.mask,
          formData,
          {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          }
        )
        .then(
          (response) => {
            if (response) {
              const res = response.data;

              if (res.code === 200) {
                this.successToastReloadPage(res.message);
              } else {
              }
            }
          },
          function (error) {
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
    showNewModal(item) {
       this.form = item;
       this.orderitems = item.items
      //   this.editmode = false;
      //   this.imageAvatar = null;
      $("#newRecordModal").modal().show();
    },
    showDeleteModal(record) {
      this.selectedItem = record;
      $("#deleteRecordModal").modal().show();
    },

    launchEditModal(record) {
      this.form.reset();
      this.editmode = true;
      this.required = false;
      this.form.fill(record);
      $("#newRecordModal").modal().show();
    },

    deleteRecord() {
      var vm = this;
      let formData = new FormData();

      axios
        .delete("/api/v1/admin/galleries/" + this.selectedItem.mask, formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then(
          (response) => {
            if (response) {
              const res = response.data;

              if (res.code === 200) {
                this.successToastReloadPage(res.message);
              } else {
              }
            }
          },
          function (error) {
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

<style lang="scss" scoped>
</style>
