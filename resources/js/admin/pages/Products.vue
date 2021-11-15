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
            <h4 class="page-title mb-0 font-size-18">All Products</h4>

            <div class="page-title-right">
              <ol class="breadcrumb m-0">
                <li class="breadcrumb-item">
                  <a href="/admin-dashboard">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">All Products</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <!-- end page title -->
      <div data-repeater-list="group-a">
        <div data-repeater-item="" class="row pull-right">
          <div class="col-lg-9"></div>

          <div class="col-lg-3 align-self-center">
            <router-link
              :to="{
                name: 'product',
              }"
            >
              <button class="btn btn-primary btn-block mb-3">
                Add New Product
              </button>
            </router-link>
          </div>
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
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Edit</th>
                    <th>Delete</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="singleItem in tableData" :key="singleItem.id">
                    <td>{{ singleItem.name }}</td>
                    <td>{{ singleItem.category }}</td>
                    <td>{{ singleItem.price}}</td>
                    <td>{{ singleItem.status_name }}</td>

                    <td>
                      <router-link

                        :to="{
                          name: 'ViewProduct',
                          params: { id: singleItem.mask },
                        }"
                      >
                        <button
                          class="btn btn-primary"
                          type="button"

                        >
                          <i class="bx bx-edit-alt"></i>
                        </button>
                      </router-link>
                    </td>
                    <td>
                      <button
                        class="btn btn-danger"
                        type="button"
                        @click="showDeleteModal(singleItem)"
                      >
                        <i class="bx bx-trash-alt"></i>
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
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5
              v-show="!editmode"
              class="modal-title mt-0"
              id="myLargeModalLabel"
            >
              Add Articles Category's Details
            </h5>
            <h5
              v-show="editmode"
              class="modal-title mt-0"
              id="myLargeModalLabel"
            >
              Update Article Category's Details
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

          <form @submit.prevent="editmode ? updateRecord() : saveRecord()">
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-12 col-md-12">
                  <div class="form-group">
                    <label for="name">name</label>
                    <input
                      required
                      v-model="form.name"
                      type="text"
                      id="name"
                      name="group-a[0][untyped-input]"
                      class="form-control"
                    />
                  </div>

                  <div class="form-group">
                    <label for="name">Description</label>
                    <input
                      required
                      v-model="form.description"
                      type="text"
                      id="name"
                      name="postion"
                      class="form-control"
                    />
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
                            Active
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
                            Inactive
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-lg-12">
                  <button class="btn btn-primary btn-block mb-3" type="submit">
                    <span v-show="!editmode">Add New Article Category</span>
                    <span v-show="editmode">Update Article Category</span>
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

    <div
      id="deleteRecordModal"
      class="modal fade bs-example-modal-sm"
      tabindex="-1"
      role="dialog"
      aria-labelledby="mySmallModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title mt-0" id="mySmallModalLabel">
              Deleting a record
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
          <div class="modal-body">
            <p>
              Are you sure you want to remove
              <strong> {{ selectedItem.name }}</strong> ?
            </p>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              No
            </button>
            <button type="button" @click="deleteRecord" class="btn btn-primary">
              Yes
            </button>
          </div>
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
      imageAvatar: null,
      required: true,
      editmode: false,
      tableData: [],
      roles: [],
      form: new Form({
        name: "",
        description: "",
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
        .get("/api/v1/admin/product")
        .then(({ data }) => {
          this.tableData = data.data;
          this.initDatatable();
        })
        .catch(function (error) {
          console.log(error);
        });
    },


    showNewModal() {
      this.form.reset();
      this.editmode = false;
      this.imageAvatar = null;
      $("#newRecordModal").modal().show();
    },
    showDeleteModal(record) {
      this.selectedItem = record;
      $("#deleteRecordModal").modal().show();
    },

    launchEditModal(record) {
      this.form.reset();
      this.editmode = true;
      this.imageAvatar = record.image;
      this.form.fill(record);
      $("#newRecordModal").modal().show();
    },


    deleteRecord() {
      var vm = this;
      let formData = new FormData();

      axios
        .delete(
          "/api/v1/admin/room/" + this.selectedItem.mask,
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
  },
};
</script>

<style lang="scss" scoped>
</style>
