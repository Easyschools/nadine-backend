<template>
    <div class="row">
        <div class="offset-2 col-md-10">
            <div class="card">
                <div class="card-header">
                    <h5>اضافة جديد كوبون</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label">الكود</label>
                            </div>
                            <div class="col-sm-9">
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="item.code"
                                />
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label"
                                    >كل المستخدمين</label
                                >
                            </div>
                            <div class="col-sm-9">
                                <input
                                    type="checkbox"
                                    class="form-control"
                                    v-model="item.all_users"
                                />
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label">المستخدمين</label>
                            </div>
                            <div class="col-sm-9">
                                <!--<input type="text" class="form-control" v-model="item.users">-->
                                <select
                                    class="form-control"
                                    :disabled="item.all_users == 1"
                                    v-model="item.users"
                                    multiple
                                >
                                    <option
                                        :key="user.id"
                                        v-for="user in users"
                                        :value="user.id"
                                    >
                                        {{ user.name }} - {{ user.phone }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label">نسبة مئوية</label>
                            </div>
                            <div class="col-sm-9">
                                <input
                                    type="checkbox"
                                    v-model="item.is_percentage"
                                    class="form-control"
                                />
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label">القيمة</label>
                            </div>
                            <div class="col-sm-9">
                                <input
                                    autocomplete="off"
                                    type="number"
                                    class="form-control"
                                    v-model="item.value"
                                />
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label"
                                    >أقصى عدد للإستخدام</label
                                >
                            </div>
                            <div class="col-sm-9">
                                <input
                                    autocomplete="off"
                                    type="number"
                                    class="form-control"
                                    v-model="item.max_usage"
                                />
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label">قيمة الطلب</label>
                            </div>
                            <div class="col-sm-9">
                                <input
                                    autocomplete="off"
                                    type="number"
                                    class="form-control"
                                    v-model="item.min_total"
                                />
                            </div>
                        </div>

                        <div class="text-center mt-5">
                            <router-link
                                to="/admin/coupon"
                                class="btn btn-secondary"
                                >الغاء</router-link
                            >
                            <button
                                type="button"
                                @click="createItem()"
                                class="btn btn-primary"
                            >
                                اضافة
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Create",
    data() {
        return {
            show: false,
            item: {
                code: null,
                users: [],
                is_percentage: 1,
                value: 1,
                max_usage: 1,
                all_users: 1,
                used_times: 0,
                min_total: 1
                // users_of_coupon: [],
            },
            users: [
                {
                    name: "",
                    phone: ""
                }
            ]
        };
    },
    created() {
        this.getUser();
    },
    methods: {
        getUser() {
            axios
                .get("customer/all")
                .then(response => {
                    this.users = response.data.data;
                })
                .catch(err => console.log(err));
        },
        createItem() {
            this.item.is_percentage =
                this.item.is_percentage || this.item.is_percentage == 1 ? 1 : 0;
            this.item.all_users =
                this.item.all_users || this.item.all_users == 1 ? 1 : 0;

            if (this.item.all_users == 1) {
                delete this.item.users;
            }

            axios
                .post("/coupon/create", this.item)
                .then(response => {
                    this.$router.push("/admin/coupon");
                    swal(
                        "Good job!",
                        "A new coupon has been added!",
                        "success"
                    );
                })
                .catch(err => {
                    this.errorMessages(err.response.data);
                    console.log(err);
                });
        },
        attachImage() {
            this.item.image = this.$refs.myImage.files[0];
            let reader = new FileReader();
            reader.addEventListener(
                "load",
                function() {
                    this.$refs.imageDisplay.src = reader.result;
                }.bind(this),
                false
            );

            reader.readAsDataURL(this.item.image);
        }
    }
};
</script>

<style scoped></style>
