<template>
    <div class="row">
        <div class="offset-2 col-md-10">
            <div class="card">
                <div class="card-header">
                    <h5>تعديل كوبون</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">الكود</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" v-model="item.code">
                            </div>
                        </div>

                        <div class="row form-group ">

                            <div class="col-sm-3">
                                <label class="col-form-label">كل المستخدمين</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="checkbox"
                                       class="form-control" v-model="item.all_users">
                            </div>
                        </div>

                        <div class="row form-group ">

                            <div class="col-sm-3">
                                <label class="col-form-label">المستخدمين</label>
                            </div>
                            <div class="col-sm-9">
                                <!--<input type="text" class="form-control" v-model="item.users">-->
                                <select class="form-control form-control-alternative" :disabled="item.all_users==1"
                                        v-model="item.users"
                                        multiple>
                                    <option v-for="user in users" :value="user.id">{{user.name}} - {{user.phone}}
                                    </option>
                                </select>
                            </div>
                        </div>


                        <div class="row form-group ">

                            <div class="col-sm-3">
                                <label class="col-form-label">نسبة مئوية</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="checkbox" v-model="item.is_percentage"
                                       class="form-control ">
                            </div>
                        </div>


                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">القيمة</label>
                            </div>
                            <div class="col-sm-9">
                                <input autocomplete="off" type="number" class="form-control" v-model="item.value">
                            </div>
                        </div>

                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">أقصى عدد للإستخدام</label>
                            </div>
                            <div class="col-sm-9">
                                <input autocomplete="off" type="number" class="form-control" v-model="item.max_usage">
                            </div>
                        </div>
                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">قيمة الطلب</label>
                            </div>
                            <div class="col-sm-9">
                                <input autocomplete="off" type="number" class="form-control" v-model="item.min_total">
                            </div>
                        </div>


                        <div class="text-center mt-5">
                            <router-link to="/admin/coupon" class="btn btn-secondary">الغاء</router-link>
                            <button type="button" @click="editItem()" class="btn btn-primary">تعديل</button>
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
                users: [],
                item: {
                    id: null,
                    max_usage: 1,
                    used_times: 0,
                    min_total: 1,
                    code: null,
                    is_percentage: 0,
                    value: null,
                    disable: 0,
                    users: [],
                    all_users: 1
                }
            };
        },
        created() {
            this.item.id = this.$route.params.id;
            this.getItem();
            this.getUser();
        },
        methods: {
            getUser() {
                axios.get('customer/all')
                    .then(response => {
                        this.users = response.data.data
                    })
                    .catch(err => console.log(err))
            },
            getItem() {
                axios.get('/coupon/get?id=' + this.item.id)
                    .then(response => {

                        if (!response.data.data.users) {
                            response.data.data.users = []
                        }
                        this.item = response.data.data;
                        console.log(this.item);
                    })
                    .catch(err => console.log(err))
            }, editItem() {
                let item = this.item;
                item.is_percentage = (this.item.is_percentage || this.item.is_percentage == 1) ? 1 : 0;
                item.all_users = (this.item.all_users || this.item.all_users == 1) ? 1 : 0;
                if (item.all_users == 1) {
                    delete this.item.users;
                }

                axios.post('/coupon/edit', item)
                    .then(response => {
                        this.$router.push('/admin/coupon');
                        // swal("Good job!", "a user has been updated!", "success");
                        this.getItem();
                        window.scrollTo(0,0);
                    })
                    .catch(err => {
                        this.errorMessages(err.response.data);
                        console.log(err)
                    });
            },
        }
    }
</script>

<style scoped>

</style>
