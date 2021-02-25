<template>
    <div class="row">
        <div class="offset-2 col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5> تعديل بيانات المستخدم</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label">صور</label>
                            </div>
                            <div class="col-sm-5">
                                <input type="file" ref="image" v-on:change="uploadImage()">
                            </div>
                            <div class="col-sm-4">
                                <img height="100" width="100" v-if="!url"  :src="item.image">
                                <img height="100" width="100"  v-if="url" :src="url" />
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label">الاسم</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" v-model="item.name">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label">البريد الالكترونى</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" v-model="item.email">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label">التلبفون</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" v-model="item.phone">
                            </div>
                        </div>
                            <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                تغيير كلمه السر
                            </a>
                            <div class="collapse col-md-12" id="collapseExample">
                                    <div class="row form-group">
                                        <div class="col-sm-3">
                                            <label class="col-form-label">كلمه السر الجديده</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" v-model="password">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-sm-3">
                                            <label class="col-form-label">تاكيد كلمه السر</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" v-model="password_confirmation">
                                        </div>
                                    </div>
                            </div>

                        <div class="text-center mt-5">
                            <button type="button" @click="$router.go(-1)" class="btn btn-secondary">الغاء</button>
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
    name: "Edit",
    data() {
        return {
            url:null,
            image_is_changed:false,
            item: {
                id: null,
                image: null,
                name: null,
                email: null,
                phone: null,
            },
            password: null,
            password_confirmation: null,
        };
    },
    created() {
        this.item.id=this.$route.params.id;
        this.getItem();
    },
    methods: {
        getItem() {
            axios.get('/users/' + this.item.id)
                .then(response => {
                    this.item = response.data.data
                })
                .catch(err => {
                    this.errorMessages(err.response.data);
                });
        },
        editItem() {
            let data = new FormData();
            for (const property in this.item) {
                if (!this.image_is_changed && property=='image'){
                    break;
                }
                if (this.item[property] != null) {
                    data.append(property, this.item[property])
                }
            }
            if (this.password){
                data.append('password',this.password)
                data.append('password_confirmation',this.password_confirmation)
            }
            data.append('_method', 'PUT');
            axios.post('/users/'+ this.item.id, data)
                .then(response => {
                    this.$router.push('/admin/user');
                    swal("Good job!", "a user has been updated!", "success");
                })
                .catch(err => {
                    this.errorMessages(err.response.data);
                    console.log(err)
                });
        },
        uploadImage(e) {
            this.item.image = this.$refs.image.files[0];
            // const file = e.target.files[0];
            this.image_is_changed=true;
            this.url = URL.createObjectURL(this.item.image);
        }
    }
}
</script>

<style scoped>

</style>
