<template>
    <div class="row">
        <div class="offset-2 col-md-10">
            <div class="card">
                <div class="card-header">
                    <h5>تعديل توع</h5>
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

                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">الشحن داخل القاهرة</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="number" class="form-control"
                                       v-model="item.custom_tag_shipping_price_copy.cost_inside_cairo">
                            </div>
                        </div>

                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">الشحن خارج القاهرة</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="number" class="form-control"
                                       v-model="item.custom_tag_shipping_price_copy.cost_outside_cairo">
                            </div>
                        </div>


                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">الفئة</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control" v-model="item.category_id">
                                    <option v-for="category in categories" :value="category.id">{{category.name_ar }} -
                                        {{category.name_en}}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="row form-group " v-if="item.image">
                            <img :src="item.image" ref="imageDisplay" class="mr-auto imageDisplay"/>
                        </div>

                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label">الصورة</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="file" ref="myImage" v-on:change="attachImage" class="form-control">
                            </div>

                        </div>
                        <div class="text-center mt-5">
                            <router-link to="/admin/tag" class="btn btn-secondary">الغاء</router-link>
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
                url: null,
                show: false,
                image_is_changed: false,
                item: {
                    category_id: null,
                    id: null,
                    name_ar: null,
                    name_en: null,
                    custom_tag_shipping_price_copy: {
                        cost_inside_cairo: 0,
                        cost_outside_cairo: 0
                    },
                    image: null,
                },
                categories: [{id: null, name_ar: null, name_en: null}]
            };
        },
        created() {
            this.item.id = this.$route.params.id;
            this.getItem();
            this.getCategories();
        },
        methods: {
            getCategories() {
                axios.get('category/all')
                    .then(response => {
                        this.categories = response.data.data
                    })
                    .catch(err => console.log(err))
            },
            getItem() {
                axios.get('/tag/get?id=' + this.item.id)
                    .then(response => {
                        this.item = response.data.data;
                        if (this.item.custom_tag_shipping_price !== null) {

                            this.item.custom_tag_shipping_price_copy = this.item.custom_tag_shipping_price
                        }
                            this.item.custom_tag_shipping_price_copy = {
                                cost_inside_cairo: null,
                                cost_outside_cairo: null
                            }
                        // console.log(this.item)
                    })
                    .catch(err => console.log(err))
            }, editItem() {
                let data = new FormData();
                for (const property in this.item) {
                    console.log(this.item[property])
                    if (!this.image_is_changed && property == 'image') {
                        break;
                    }
                    if (this.item[property] != null) {
                        data.append(property, this.item[property])
                    }
                }

                // data.append('id', this.item.id);
                axios.post('/tag/edit', data)
                    .then(response => {
                        // this.$router.push('/admin/tag');
                        swal("Good job!", "a tag has been updated!", "success");
                        this.getItem();
                        window.scrollTo(0, 0);
                    })
                    .catch(err => {
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
                thi.image_is_changed =1 ;
                reader.readAsDataURL(this.item.image);
                this.image_is_changed = true;
                this.url = URL.createObjectURL(this.item.image);
            },
        }
    }
</script>

<style scoped>

</style>
