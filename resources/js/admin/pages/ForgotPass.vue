<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">
                <img
                    src="/assets/img/logos/AkomaCare_Full_Color.png"
                    width="50"
                />

                AkomaCare</a
            >
            <button
                class="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <button
                        class="btn btn-outline-danger my-2 my-sm-0"
                        data-toggle="modal"
                        data-target="#coloredModalDanger"
                    >
                        What is AkomaCare ?
                    </button>

                  <li class="nav-item">
                        <a class="nav-link" href="/about-us">About us</a>
                    </li>

                    <div
                        class="modal modal-colored modal-danger fade"
                        id="coloredModalDanger"
                        tabindex="-1"
                        role="dialog"
                        aria-hidden="true"
                    >
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">About</h3>
                                    <button
                                        type="button"
                                        class="close"
                                        data-dismiss="modal"
                                        aria-label="Close"
                                    >
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body m-3 text-justify">
                                    <p class="mb-0">
                                        <span
                                            style="font-weight: 700; font-size: 18px"
                                            >Cardiovascular diseases
                                            (CVDs)</span
                                        >
                                        are a growing public health problem in
                                        Ghana and other African countries.
                                        Strokes and other CVDs have become a
                                        leading cause of death due to increasing
                                        risk factors such as hypertension.
                                        According to the Global Burden of
                                        Disease study (GBD), ischaemic heart
                                        disease was the fourth leading cause of
                                        death in Ghana in 2016. The prevalence
                                        of hyper- tension, a major risk factor
                                        for CVDs, is increasing rapidly and
                                        ranges from 19% to 48%, according to the
                                        Ghana Health Service Annual Report,
                                        2017, due to rising life expectancy and
                                        the increasing prevalence of
                                        contributing factors such as
                                        overweight/obesity. Early diagnosis and
                                        adequate management of the risk factors
                                        can reduce the fatal consequences of
                                        CVDs.
                                    </p>
                                    <br />

                                    <p>
                                        At the heart of improving risk
                                        assessment and management of CVDs are
                                        nationally approved guidelines, which
                                        facilitate standardisation of care
                                        approaches. These guidelines developed
                                        by experts from all levels of health
                                        care and stakeholders together capture
                                        all recommended approaches and necessary
                                        information for clinicians and other
                                        healthcare workers on CVDs. They also
                                        serve as a practical guide for assessing
                                        and managing the most important CVDs
                                        prevalent in Ghana and can be used at
                                        all the levels of care namely health
                                        facilities without a doctor; with a
                                        general practitioner and with a
                                        physician specialist. <br /><br />
                                    </p>
                                    We hope that these guidelines will prove to
                                    be a useful and a beneficial tool for all
                                    its users.
                                </div>
                                <div class="modal-footer">
                                    <button
                                        type="button"
                                        class="btn btn-light"
                                        data-dismiss="modal"
                                    >
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </ul>
            </div>
        </nav>

        <img class="wave" src="/assets/img/vector-bg.png" />
        <div class="container contained">
            <div class="img"><img src="/assets/img/femdoc-bg.png" /><br /></div>
            <div class="login-content">
                <form @submit.prevent="login" class="signin-form">
                    <img
                        src="/assets/img/logos/AkomaCare_Full_Color.png"
                        width="170"
                    />
                    <div class="sign-wrapper">
                        <div class="wd-100p">
                            <h4
                                class="tx-color-01 mg-b-5 text-center"
                                style="font-size: 30px"
                            >
                                Welcome to AkomaCare
                            </h4>
                            <p
                                class="tx-color-03 text-center tx-16 mg-b-40"
                                style="font-size: 15px"
                            >
                                Reset Password
                            </p>
                            <hr />

                            <div class="form-group mt-4">
                                <label for="">
                                    Enter your email to received new
                                    password.</label
                                >
                                <input
                                    @keydown.space="
                                        event => event.preventDefault()
                                    "
                                    type="email"
                                    required
                                    v-model="form.email"
                                    class="form-control-signup"
                                    placeholder="Enter email"
                                />
                            </div>
                        </div>
                    </div>
                    <!-- sign-wrapper -->
                    <div class="text-center">
                        <button
                            type="submit"
                            class="btn my-btn btn-pill btn-lg"
                        >
                            Reset Password
                        </button>
                    </div>
                    <div class="text-center mt-3">
                        <div class="tx-13 mg-t-30 tx-center">
                            I have an account.
                            <router-link :to="{ name: 'Login' }"
                                >Sign in.</router-link
                            >
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Form from "vform";
import store from "../store";
import { mixin } from "./../mixin";
export default {
    mixins: [mixin],
    data() {
        return {
            form: new Form({
                email: "",
                password: ""
            })
        };
    },
    methods: {
        login() {
            var vm = this;
            let formData = new FormData();
            formData.append("email", this.form.email);

            axios
                .post("/api/v1/healthworker/auth/forgot-password", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(
                    response => {
                        if (response) {
                            const res = response.data;

                            if (res.code == 200) {
                                var userData = res.data;
                                vm.$toasted.show(res.message);
                            } else {
                                vm.$toasted.show(res.message);
                            }
                        }
                    },
                  function (error) {
            if (error.response) {
              //  console.log(error.response.data.message);

              // console.log(error.response.data.errors);
              if (error.response.data.errors) {
                error.response.data.errors.forEach((element) => {
                  vm.$toasted.show(element);
                });
              } else {
                vm.$toasted.show(error.response.data.message);
              }
              // alert(error.response.status);
            }
          }
                );
        }
    }
};
</script>

<style lang="sass" scoped></style>
