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
            <h4 class="page-title mb-0 font-size-18">New Product</h4>

            <div class="page-title-right">
              <ol class="breadcrumb m-0">
                <li class="breadcrumb-item">
                  <a href="/admin-dashboard">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">New Product</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <!-- end page title -->

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="row pl-2">
                <div class="col-lg-5 text-center">
                  <div class="form-group">
                    <input
                      placeholder="Product Name"
                      required
                      v-model="form.name"
                      type="text"
                      id="name"
                      name="group-a[0][untyped-input]"
                      class="form-control"
                    />
                  </div>

                  <div class="form-group">
                    <label
                      for="example-text-input"
                      class="col-form-label form-control-label"
                      >Preview</label
                    >
                    <div class="col-md-12">
                      <img
                        :src="imageAvatar"
                        id="profile-img-tag"
                        height="300px"
                        width="100%"
                      />
                    </div>
                  </div>
                  <div class="custom-file">
                    <input
                      type="file"
                      class="custom-file-input"
                      id="customFileLang"
                      lang="en"
                      @change="getFeaturedImage"
                      ref="webfile"
                    />
                    <label class="custom-file-label" for="customFileLang"
                      >Select Product Image</label
                    >
                  </div>
                  <div class="form-group mt-5">
                    <input
                      placeholder="Price of Product"
                      required
                      v-model="form.price"
                      type="integer"
                      id="name"
                      name="group-a[0][untyped-input]"
                      class="form-control"
                    />
                  </div>

                  <div class="form-group mt-5">
                    <div class="row">
                      <div class="col-lg-2">
                        <h5 class="font-size-14">Status</h5>
                      </div>
                      <div class="col-lg-2">
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
                      <div class="col-lg-2">
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

                  <div class="form-group row">
                    <label class="col-md-4 col-form-label"
                      >Select Category</label
                    >
                    <div class="col-md-8">
                      <v-select
                        id="sort_by_location"
                        v-model="form.category_id"
                        :options="categories"
                        placeholder="Select Category"
                        label="name"
                        :reduce="(name) => name.id"
                      ></v-select>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6" style="height: 500px">
                  <quill-editor
                    style="height: 560px"
                    ref="myQuillEditor"
                    v-model="form.description"
                    :options="editorOption"
                  />

                  <br />
                </div>
              </div>

              <div class="row justify-content-center bg-purple">
                <button
                  @click="launchEmailConfirmation"
                  style="width: 100%"
                  class="btn btn-primary"
                >
                  Save Product
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end col -->

    <div
      id="modal-block-small"
      class="modal fade bs-example-modal-sm"
      tabindex="-1"
      role="dialog"
      aria-labelledby="mySmallModalLabel"
      aria-hidden="true"
      style="display: none"
    >
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" v-show="!editmode" id="mySmallModalLabel">
              Saving Product Details
            </h4>
            <h4 class="modal-title" v-show="editmode" id="mySmallModalLabel">
              Updating Product Details
            </h4>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-hidden="true"
            >
              ×
            </button>
          </div>
          <div class="modal-body">
            <p>Are you sure you want to save Product ?</p>
          </div>

          <div class="block-content block-content-full text-right bg-light">
            <button
              type="button"
              class="btn btn-sm btn-light"
              data-dismiss="modal"
            >
              No
            </button>
            <button
              v-show="!editmode"
              type="button"
              @click="saveRecord()"
              class="btn btn-sm btn-primary"
              data-dismiss="modal"
            >
              Yes
            </button>
            <button
              v-show="editmode"
              type="button"
              @click="updateRecord()"
              class="btn btn-sm btn-primary"
              data-dismiss="modal"
            >
              Yes Update
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
      selected_image: "",
      /**images keys */
      isDragging: false,
      dragCount: 0,
      images: [],
      categories: [],
      files: [],
      /*end of image keys */

      editorOption: {
        // Some Quill options...
      },
      selectedItem: "",
      imageAvatar: null,
      required: true,
      features: [],
      categories: [],
      editmode: false,
      form: new Form({
        price: "",
        name: "",
        description: "",
        category_id: "",
        status: "",
        mask: "",
        featured_image: "",
      }),
    };
  },
  mounted() {
    if (this.$route.params.id) {
      this.getRecord();

      // this.getSub();
    }
    this.getCategories();
  },

  methods: {
    showRemovePreviewImageModal(image) {
      this.selected_image = image;
      $("#exampleModalCenter").modal().show();
    },
    showNewModal() {
      $("#modal-block-large").modal().show();
    },

    getRecord() {
      this.editmode = true;
      let mask = this.$route.params.id;
      axios
        .get("/api/v1/admin/product/" + mask)
        .then(({ data }) => {
          this.form.fill(data.data);

          this.imageAvatar = data.data.image;
        })
        .catch(function (error) {
          console.log(error);
        });
    },

    getFeaturedImage(e) {
      this.form.featured_image = this.$refs.webfile.files[0];
      let image = e.target.files[0];
      let reader = new FileReader();
      reader.readAsDataURL(image);
      reader.onload = (e) => {
        this.imageAvatar = e.target.result;
      };
    },

    launchEmailConfirmation() {
      $("#modal-block-small").modal().show();
    },

    getCategories() {
      axios
        .get("/api/v1/admin/categories")
        .then(({ data }) => {
          this.categories = data.data;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    saveRecord() {
      // return;
      var vm = this;
      let formData = new FormData();
      formData.append("name", this.form.name);
      formData.append("price", this.form.price);
      formData.append("description", this.form.description);
      formData.append("status", this.form.status);
      formData.append("category_id", this.form.category_id);
      formData.append("featured_image", this.form.featured_image);
      axios
        .post("/api/v1/admin/product", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then(
          (response) => {
            if (response) {
              const res = response.data;
              if (res.code === 200) {
                // vm.$toasted.show(res.message);
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
    updateRecord() {
      // return;
      var vm = this;
      let formData = new FormData();
      formData.append("name", this.form.name);
      formData.append("price", this.form.price);
      formData.append("description", this.form.description);
      formData.append("status", this.form.status);
      formData.append("category_id", this.form.category_id);
      formData.append("featured_image", this.form.featured_image);
      axios
        .post("/api/v1/admin/product/" + this.$route.params.id, formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then(
          (response) => {
            if (response) {
              const res = response.data;
              if (res.code === 200) {
                // vm.$toasted.show(res.message);
                this.successToastReloadPage(res.message);
                // this.successToastRedirect(res.message, "/dashboard/articles");
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
.previmg {
  padding-right: 2px;
  width: 100%;
  height: 150px;
  margin-top: 5px;
}

.custom-file input[type="file"] {
  cursor: pointer;
}
.custom-file label {
  cursor: pointer;
  z-index: 999;
}

.ql-editor {
  height: 400px !important;
}

/**end of form */
</style>
