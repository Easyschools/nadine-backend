<template>
    <div class="row">
        <div class="offset-2 col-md-10">
            <div class="card">
                <div class="card-header">
                    <h5>تعديل حالة الطلب</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">الاسم بالعربية</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" v-model="item.name_ar">
                            </div>
                        </div>
                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">الاسم بالانجليزية</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" v-model="item.name_en">
                            </div>
                        </div>

                        <div class="text-center mt-5">
                            <router-link to="/admin/status" class="btn btn-secondary">الغاء</router-link>
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
                item: {
                    id: null,
                    name_ar: null,
                    name_en: null,
                },

            };
        },
        created() {
            this.item.id = this.$route.params.id;
            this.getItem();

        },
        methods: {
            getItem() {
                axios.get('/order-status/get?id=' + this.item.id)
                    .then(response => {
                        this.item = response.data.data
                    })
                    .catch(err => console.log(err))
            }, editItem() {
                let data = new FormData();
                for (const property in this.item) {
                    if (!this.image_is_changed && property == 'image') {
                        break;
                    }
                    if (this.item[property] != null) {
                        data.append(property, this.item[property])
                    }
                }

                // data.append('id', this.item.id);
                axios.post('/order-status/edit', data)
                    .then(response => {
                        this.$router.push('/admin/status');
                        swal("Good job!", "a status has been updated!", "success");
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
