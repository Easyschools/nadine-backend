<template>
    <div class="row">
        <div class="offset-2 col-md-10">
            <div class="card">
                <div class="card-header">
                    <h5>Add New Offer</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row form-group">

                            <div class="col-sm-9">
                                <input type="text" class="form-control" v-model="item.name_ar">
                            </div>
                            <div class="col-sm-3">
                                <label class="col-form-label">Name AR</label>
                            </div>
                        </div>
                        <div class="row form-group">

                            <div class="col-sm-9">
                                <input type="text" class="form-control" v-model="item.name_en">
                            </div>
                            <div class="col-sm-3">
                                <label class="col-form-label">Name En</label>
                            </div>
                        </div>
                        <div class="row form-group ">

                            <div class="col-sm-9">
                                <input type="checkbox"
                                       class="form-control " v-model="item.is_percentage">
                            </div>
                            <div class="col-sm-3">
                                <label class="col-form-label">Is Percentage</label>
                            </div>
                        </div>

                        <div class="row form-group">

                            <div class="col-sm-9">
                                <input type="number" autocomplete="off" class="form-control" v-model="item.discount">
                            </div>
                            <div class="col-sm-3">
                                <label class="col-form-label">Discount</label>
                            </div>
                        </div>

                        <div class="row form-group">

                            <div class="col-sm-9 text-center">
                                <date-picker v-model="item.expire_at" valueType="format"></date-picker>
                                <!--<datetime ></datetime>-->
                                <!--<input type="date" class="form-control" v-model="item.expire_at">-->

                            </div>
                            <div class="col-sm-3">
                                <label class="col-form-label">Expire At</label>
                            </div>
                        </div>


                        <div class="row form-group">

                            <div class="col-sm-9">
                                <select class="form-control" v-model="item.category_id">
                                    <option v-for="category in categories" :value="category.id">{{category.name_ar }} -
                                        {{category.name_en}}
                                    </option>
                                </select>
                            </div>

                            <div class="col-sm-3">
                                <label class="col-form-label">Category</label>
                            </div>
                        </div>

                        <div class="row form-group " v-if="item.image">
                            <img src="" ref="imageDisplay" class="mr-auto imageDisplay"/>
                        </div>

                        <div class="row form-group">

                            <div class="col-sm-9">
                                <input type="file" ref="myImage" v-on:change="attachImage" class="form-control">
                            </div>

                            <div class="col-sm-3">
                                <label class="col-form-label ">Image</label>
                            </div>
                        </div>

                        <div class="text-center mt-5">
                            <router-link to="/admin/offer" class="btn btn-secondary">Cancel</router-link>
                            <button type="button" @click="createItem()" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import {Datetime} from 'vue-datetime';
    import DatePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';

    export default {
        name: "Create",
        template: '...',
        components: {
            datetime: Datetime,
            DatePicker
        },
        data() {
            return {
                show: false,
                item: {
                    name_ar: '',
                    name_en: '',
                    discount: '',
                    is_percentage: 1,
                    expire_at: '',
                    image: null
                },
                categories: [{
                    id: null,
                    name_en: null,
                    name_ar: null
                }]

            };
        },
        created() {
            this.getCategory();
        },
        methods: {
            getCategory() {
                axios.get('category/all')
                    .then(response => {
                        this.categories = response.data.data
                    })
                    .catch(err => console.log(err))
            },
            createItem() {

                let formData = new FormData();
                for (const property in this.item) {
                    if (this.item[property] != null) {
                        if (property == 'is_percentage') {

                            formData.append(property, (this.item[property]) ? 1 : 0)
                        } else {

                            formData.append(property, this.item[property])
                        }
                    }
                }

                axios.post('/offer/create', formData)
                    .then(response => {
                        this.$router.push('/admin/offer');
                        swal("Good job!", "A new offer has been added!", "success");
                    }).catch(err => {
                    this.errorMessages(err.response.data);
                    console.log(err)
                });
            },
            attachImage() {
                this.item.image = this.$refs.myImage.files[0];
                let reader = new FileReader();
                reader.addEventListener('load', function () {
                    this.$refs.imageDisplay.src = reader.result;
                }.bind(this), false);

                reader.readAsDataURL(this.item.image);
            },
        }
    }
</script>

<style scoped>

</style>
