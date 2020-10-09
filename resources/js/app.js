// import 'babel-polyfill'
import Vue from "vue";
require("./bootstrap");
import vuetify from "./vuetify.plugin";
import swal from "sweetalert";
const bcrypt = require("bcryptjs");

require("./custom");
require("./calendar");
window.Vue = Vue;

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

new Vue({
    vuetify,
    data: {
        drawer: {
            user: false,
            admin: true
        },
        categories: [],
        remarks: [],
        passwordVisible: false,
        user: {
            email: null,
            password: null,
            otp: null
        },
        options: [
            {
                name: "Board",
                baseurl: "board",
                icon: "mdi-briefcase",
                children: [
                    {
                        name: "Board Home",
                        icon: "mdi-home-analytics",
                        url: "/board/home"
                    },
                    {
                        name: "Create Board Agenda",
                        icon: "mdi-plus",
                        url: "/board/agenda/create"
                    },
                    {
                        name: "Board Meeting",
                        icon: "mdi-account-multiple",
                        url: "/board/meeting/admin"
                    }
                ]
            },
            {
                name: "Committee",
                baseurl: "committee",
                icon: "mdi-account-group",
                ovl_children: [
                    {
                        name: "Committee Dashboard",
                        icon: "mdi-view-dashboard",
                        url: "/committee/meeting"
                    },
                    {
                        name: "Audit Committee",
                        icon: "mdi-alpha-a-circle-outline",
                        url: "/committee/home/1"
                    },
                    {
                        name: "HRM&R Committee",
                        icon: "mdi-alpha-h-circle-outline",
                        url: "/committee/home/2"
                    },
                    {
                        name: "PAC Committee",
                        icon: "mdi-alpha-p-circle-outline",
                        url: "/committee/home/3"
                    },
                    {
                        name: "FMC Committee",
                        icon: "mdi-alpha-f-circle-outline",
                        url: "/committee/home/4"
                    },
                    {
                        name: "CSR&S Committee",
                        icon: "mdi-alpha-c-circle-outline",
                        url: "/committee/home/5"
                    },
                    {
                        name: "Create Committee Agenda",
                        icon: "mdi-plus",
                        url: "/committee/agenda/create"
                    }
                ],
                opal_children: [
                    //opal
                    {
                        name: "Committee Dashboard",
                        icon: "mdi-view-dashboard",
                        url: "/committee/meeting"
                    },
                    {
                        name: "Audit Committee",
                        icon: "mdi-alpha-a-circle-outline",
                        url: "/committee/home/1"
                    },
                    {
                        name: "N&RC Committee",
                        icon: "mdi-alpha-n-circle-outline",
                        url: "/committee/home/2"
                    },
                    {
                        name: "CSR Committee",
                        icon: "mdi-alpha-c-circle-outline",
                        url: "/committee/home/3"
                    },
                    {
                        name: "M&OR Committee",
                        icon: "mdi-alpha-m-circle-outline",
                        url: "/committee/home/4"
                    },
                    {
                        name: "Risk Management Committee",
                        icon: "mdi-alpha-r-circle-outline",
                        url: "/committee/home/5"
                    },
                    {
                        name: "Share Allotment Committee",
                        icon: "mdi-alpha-s-circle-outline",
                        url: "/committee/home/6"
                    },
                    {
                        name: "Create Committee Agenda",
                        icon: "mdi-plus",
                        url: "/committee/agenda/create"
                    }
                ],
                children: [
                    //otpc
                    {
                        name: "Committee Dashboard",
                        icon: "mdi-view-dashboard",
                        url: "/committee/meeting"
                    },
                    {
                        name: "Audit Committee",
                        icon: "mdi-alpha-a-circle-outline",
                        url: "/committee/home/1"
                    },
                    {
                        name: "N&RC Committee",
                        icon: "mdi-alpha-n-circle-outline",
                        url: "/committee/home/2"
                    },
                    {
                        name: "CSR Committee",
                        icon: "mdi-alpha-c-circle-outline",
                        url: "/committee/home/3"
                    },
                    {
                        name: "ST&AC Committee",
                        icon: "mdi-alpha-s-circle-outline",
                        url: "/committee/home/4"
                    },
                    {
                        name: "Operation Review Committee",
                        icon: "mdi-alpha-o-circle-outline",
                        url: "/committee/home/5"
                    },
                    {
                        name: "Employees Group Gratuity Assurance Trust",
                        icon: "mdi-alpha-e-circle-outline",
                        url: "/committee/home/6"
                    },
                    {
                        name: "Create Committee Agenda",
                        icon: "mdi-plus",
                        url: "/committee/agenda/create"
                    }
                ],
                ompl_children: [
                    //ompl
                    {
                        name: "Committee Dashboard",
                        icon: "mdi-view-dashboard",
                        url: "/committee/meeting"
                    },
                    {
                        name: "Audit Committee",
                        icon: "mdi-alpha-a-circle-outline",
                        url: "/committee/home/1"
                    },
                    {
                        name: "Committee of Directors",
                        icon: "mdi-alpha-c-circle-outline",
                        url: "/committee/home/2"
                    },
                    {
                        name: "N&R Committee",
                        icon: "mdi-alpha-n-circle-outline",
                        url: "/committee/home/3"
                    },
                    {
                        name: "CSR Committee",
                        icon: "mdi-alpha-c-circle-outline",
                        url: "/committee/home/4"
                    },
                    {
                        name: "Empowered Committee of Directors",
                        icon: "mdi-alpha-e-circle-outline",
                        url: "/committee/home/5"
                    },
                    {
                        name: "Create Committee Agenda",
                        icon: "mdi-plus",
                        url: "/committee/agenda/create"
                    }
                ],
                mrpl_children: [
                    //mrpl
                    {
                        name: "Committee Dashboard",
                        icon: "mdi-view-dashboard",
                        url: "/committee/meeting"
                    },
                    {
                        name: "Audit Committee",
                        icon: "mdi-alpha-a-circle-outline",
                        url: "/committee/home/1"
                    },
                    {
                        name: "Stakeholders Relationship Committee",
                        icon: "mdi-alpha-s-circle-outline",
                        url: "/committee/home/2"
                    },
                    {
                        name: "CSR&SD Committee",
                        icon: "mdi-alpha-c-circle-outline",
                        url: "/committee/home/3"
                    },
                    {
                        name: "PA&E Committee",
                        icon: "mdi-alpha-p-circle-outline",
                        url: "/committee/home/4"
                    },
                    {
                        name: "NR&HRM Committee",
                        icon: "mdi-alpha-n-circle-outline",
                        url: "/committee/home/5"
                    },
                    {
                        name: "Operations Review Committee",
                        icon: "mdi-alpha-o-circle-outline",
                        url: "/committee/home/6"
                    },
                    {
                        name: "Risk Management Committee",
                        icon: "mdi-alpha-r-circle-outline",
                        url: "/committee/home/7"
                    },
                    {
                        name: "Committee of Directors",
                        icon: "mdi-alpha-c-circle-outline",
                        url: "/committee/home/8"
                    },
                    {
                        name: "Create Committee Agenda",
                        icon: "mdi-plus",
                        url: "/committee/agenda/create"
                    }
                ],
                msez_children: [
                    //msez
                    {
                        name: "Committee Dashboard",
                        icon: "mdi-view-dashboard",
                        url: "/committee/meeting"
                    },
                    {
                        name: "Audit Committee",
                        icon: "mdi-alpha-a-circle-outline",
                        url: "/committee/home/1"
                    },
                    {
                        name: "N&R Committee",
                        icon: "mdi-alpha-n-circle-outline",
                        url: "/committee/home/2"
                    },
                    {
                        name: "CSR Committee",
                        icon: "mdi-alpha-c-circle-outline",
                        url: "/committee/home/3"
                    },
                    {
                        name: "Committee of Directors",
                        icon: "mdi-alpha-c-circle-outline",
                        url: "/committee/home/4"
                    },
                    {
                        name: "Create Committee Agenda",
                        icon: "mdi-plus",
                        url: "/committee/agenda/create"
                    }
                ]
            },
            {
                name: "Manage Users",
                baseurl: "user",
                icon: "mdi-account-circle",
                children: [
                    {
                        name: "View Users",
                        icon: "mdi-account-multiple",
                        url: "/user"
                    },
                    {
                        name: "Create User",
                        icon: "mdi-plus",
                        url: "/user/create"
                    }
                ]
            },
            {
                name: "Archives",
                baseurl: "archive",
                icon: "mdi-package-down",
                children: [
                    {
                        name: "Board Archive",
                        icon: "mdi-arrow-down-bold-circle",
                        url: "/archive/board"
                    },
                    {
                        name: "Committee Archive",
                        icon: "mdi-arrow-down-bold-circle-outline",
                        url: "/archive/committee"
                    }
                ]
            },
            {
                name: "Notification",
                baseurl: "notification",
                icon: "mdi-bell",
                children: [
                    {
                        name: "View Notification",
                        icon: "mdi-bell-ring",
                        url: "/notification"
                    },
                    {
                        name: "Create Notification",
                        icon: "mdi-plus",
                        url: "/notification/create"
                    }
                ]
            }
            // {
            //     name: 'Audit Logs', baseurl: 'logs', icon: 'mdi-package-down', children: [
            //         { name: 'Database Logs', icon: 'mdi-database-search', url: '/logs' },
            //         { name: 'Telescope', icon: 'mdi-telescope', url: '/telescope' },
            //     ]
            // },
        ],
        boardAgenda: {
            input: {
                category: "",
                name: "?",
                type: {}
            },
            output: {
                remarks: [],
                calculatedUid: "?"
            }
        }
    },
    created: function() {
        axios
            .get("/token")
            .then(res => {
                window.axios.defaults.headers.common[
                    "Authorization"
                ] = `Bearer ${res.data}`;
                axios
                    .get("/api/categories")
                    .then(res => {
                        this.categories = res.data;
                    })
                    .catch(err => console.log(err));
                axios
                    .get("/api/board/meeting")
                    .then(res => {
                        this.boardAgenda.input.name = res.data.name;
                    })
                    .catch(err => console.log(err));
            })
            .catch(err => console.log(err));
    },

    mounted: function() {
        setInterval(() => {
            axios
                .get("/auth/check")
                .then(res => {
                    // console.log(res.data);
                    if (!res.data) {
                        window.location.href = "/login";
                    }
                })
                .catch(err => (window.location.href = "/login"));
        }, 10 * 60 * 1000);
    },

    methods: {
        login: function() {
            if (this.$refs.form.validate()) {
                this.$refs.form.$el.submit();
            }
        },
        encryptPassword() {
            let passwordField = document.getElementById("password");
            let otpField = document.getElementById("otp");
            let gToken = document.getElementById("g_token");

            gToken.value =
                btoa(btoa(btoa(passwordField.value))) +
                "." +
                btoa(btoa(btoa(otpField.value)));

            var salt = bcrypt.genSaltSync(10);
            passwordField.value = bcrypt.hashSync(passwordField.value, salt);
            otpField.setAttribute("type", "text");
            otpField.value = bcrypt.hashSync(otpField.value, salt);

            document.getElementById("login-form").submit();
        },
        logout: function() {
            document.getElementById("logout-form").submit();
        },
        openurl: function(url) {
            if (url) window.location.href = url;
        },
        resendOtp() {
            swal("Resend OTP functionality has been temporarily disabled");
        }
    },
    watch: {
        "boardAgenda.input.category": {
            handler: function(val) {
                let category = this.categories.find(item => item.name == val);
                this.remarks = category.remarks;
            },
            deep: true
        },
        "boardAgenda.input.type": {
            handler: function(val) {
                let type = this.remarks.find(elem => elem.name == val);
                axios
                    .get(
                        `/board/agenda/uid/${this.boardAgenda.input.category}/${type.name}`
                    )
                    .then(res => {
                        // console.log(res);
                        this.boardAgenda.output.calculatedUid =
                            this.boardAgenda.input.name +
                            "." +
                            type.code +
                            "." +
                            res.data;
                    })
                    .catch(err => {
                        this.boardAgenda.output.calculatedUid =
                            this.boardAgenda.input.name + ".?.?";
                    });
            },
            deep: true
        }
    }
}).$mount("#app");
