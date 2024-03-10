<template>
    <div class="row">
        <div class="offset-2 col-md-10">
            <div class="card">
                <div class="card-header">
                    <h5>{{translations.general.add}} {{translations.status.status}}</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">{{translations.general.nameAr}}</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" v-model="item.name_ar">
                            </div>
                        </div>
                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">{{translations.general.nameEn}}</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" v-model="item.name_en">
                                <!--<select class="form-control" v-model="item.name_en">-->
                                <!--<option v-for="type in types" :value="type.id">{{type.name}}</option>-->
                                <!--</select>-->
                            </div>
                        </div>

                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">{{translations.status.status}}</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control" v-model="item.type">
                                    <option value="active">{{translations.status.active}}</option>
                                    <option value="inactive">{{translations.status.inActive}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="text-center mt-5">
                            <router-link to="/admin/status" class="btn btn-secondary">{{translations.general.cancel}}</router-link>
                            <button type="button" @click="createItem()" class="btn btn-primary">{{translations.general.add}}</button>
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
                    name_en: null,
                    name_ar: null,
                    type_ar: null,
                    type_en: null,
                },

            };
        },
        created() {

        },
        methods: {

            createItem() {

                let formData = new FormData();
                for (const property in this.item) {
                    if (this.item[property] != null) {
                        formData.append(property, this.item[property])
                    }
                }

                axios.post('/order-status/create', formData)
                    .then(response => {
                        this.$router.push('/admin/status');
                        swal("Good job!", "A new order status has been added!", "success");
                    }).catch(err => {
                    this.errorMessages(err.response.data);
                    console.log(err)
                });
            },
        }
    }
</script>

<style scoped>

</style>
