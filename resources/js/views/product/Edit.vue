<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>تعديل منتج</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">الكود</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" v-model="item.sku">
                            </div>
                        </div>
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
                                <label class="col-form-label">الوصف بالعربية</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" v-model="item.description_ar">
                            </div>
                        </div>
                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">الوصف بالانجليزية</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" v-model="item.description_en">
                            </div>
                        </div>

                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">السعر</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="number" v-on:keyup="fillPriceAfterDiscount" class="form-control"
                                       v-model="item.price">
                            </div>
                        </div>
                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">السعر بعد الخصم</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" v-model="item.price_after_discount">
                            </div>
                        </div>


                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">الفئة</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control" v-if="item.tag" v-on:change="selectCategory"
                                        v-model="item.tag.category_id">
                                    <option v-for="category in categories" :value="category.id">{{ category.name_ar }} -
                                        {{ category.name_en }}
                                    </option>
                                </select>

                                <select class="form-control" v-else v-on:change="selectCategory"
                                        v-model="item.category_id">
                                    <option v-for="category in categories" :value="category.id">{{ category.name_ar }} -
                                        {{ category.name_en }}
                                    </option>
                                </select>
                            </div>

                        </div>


                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">النوع</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control" v-model="item.tag_id">
                                    <option v-for="tag in tags" :value="tag.id">{{ tag.name_ar }} - {{ tag.name_en }}
                                    </option>
                                </select>
                            </div>

                        </div>
                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">الخامة</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control" v-model="item.material_id">
                                    <option v-for="material in materials" :value="material.id">{{ material.name_ar }} -
                                        {{ material.name_en }}
                                    </option>
                                </select>
                            </div>

                        </div>

                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">المجموعة</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control" v-model="item.collection_id">
                                    <option v-for="collection in collections" :value="collection.id">
                                        {{ collection.name_ar }} -
                                        {{ collection.name_en }}
                                    </option>
                                </select>
                            </div>

                        </div>


                    </form>
                </div>
            </div>
        </div>


        <!--        //here-->


        <div class="col-sm-12">
            <div class="col-md-12 text-right">
                <button class="btn btn-secondary mb-3" type="button" @click="addVariant()">
                    اضافة جديد توع منتج
                </button>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 col-sm-12">
                            <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                <li v-for="(variant,index) in item.variants">
                                    <a :class="(index)?'nav-link text-left':'nav-link text-left active'"
                                       id="v-pills-home-tab" data-toggle="pill"
                                       :href="'#variant'+index" role="tab"
                                       aria-controls="v-pills-home" aria-selected="true">
                                        نوع {{ index }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-10 col-sm-12">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div v-for="(variant,index) in item.variants"
                                     :class="(index==0)?'tab-pane fade active show':'tab-pane fade'"
                                     :id="'variant'+index" role="tabpanel"
                                     aria-labelledby="v-pills-home-tab">
                                    <div>
                                        <div class="row mb-4">
                                            <strong class="col-md-5 text-capitalize"
                                                    style="font-size: 18px">
                                                نوع {{ index }}
                                            </strong>

                                            <button type="button"
                                                    class="float-right btn btn-icon btn-outline-danger"
                                                    v-if="index!=0||item.variants.length>1"
                                                    @click="item.variants.splice(index,1)"
                                            >
                                                <i class="feather icon-x"></i>
                                            </button>

                                        </div>
                                        <div class="row ">

                                            <div class="col-md-12">

                                                <div class="row form-group">

                                                    <div class="col-md-3 m-2" v-if="variant.images.length > 0"
                                                         v-for="image in variant.images">
                                                        <img v-if="image" :src="image.image" width="200px"
                                                             height="200px">
                                                    </div>

                                                </div>

                                                <div class="row form-group">

                                                    <div class="col-sm-3">
                                                        <label style="font-weight: bold;"
                                                               class="col-form-label ">الصورة</label>
                                                    </div>

                                                    <div class="col-md-9">
                                                        <input type="file" :ref="'mainImages'+index"
                                                               @change="uploadVariantImage(index)" multiple>
                                                    </div>

                                                </div>
                                            </div>


                                            <!--                                            &lt;!&ndash;                                            <div class="col-md-">&ndash;&gt;-->
                                            <!--                                            <div class="col-md-3">-->

                                            <!--                                                <label-->
                                            <!--                                                    style="font-weight: bold;margin-left: 0px;">Image</label>-->
                                            <!--                                            </div>-->
                                            <!--                                            <div class="col-md-9">-->
                                            <!--                                                <input type="file" :ref="'variant'+index"-->
                                            <!--                                                       @change="uploadVariantImage(index)">-->
                                            <!--                                            </div>-->
                                            <!--                                            &lt;!&ndash;                                            </div>&ndash;&gt;-->
                                            <div class="col-md-3 mt-4 mb-3">
                                                <label style="font-weight: bold;">اللون</label>
                                            </div>
                                            <div class="col-md-9 mt-3">
                                                <select class="form-control" v-model="variant.color_id">
                                                    <option value=""></option>
                                                    <option v-for="color in colors" :value="color.id">
                                                        {{ color.name_ar }} -
                                                        {{ color.name_en }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mt-4 mb-3">
                                                <label style="font-weight: bold;">المقاس</label>
                                            </div>
                                            <div class="col-md-9 mt-3">
                                                <input type="text" v-model="variant.dimension_value"
                                                       class="form-control">

                                            </div>


                                            <div class="col-md-3 mt-4 mb-3">
                                                <label style="font-weight: bold;">السعر الاضافى</label>
                                            </div>
                                            <div class="col-md-9 mt-3">

                                                <input type="number" v-model="variant.additional_price"
                                                       class="form-control mob_no"
                                                       autocomplete="off" maxlength="2">
                                            </div>


                                        </div>


                                    </div>


                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <router-link :to="{path:'/admin/product/' ,query: {
                                     page: current_page,}}" class="btn btn-secondary">
                    الغاء
                </router-link>
                <button type="button" @click="editItem" class="btn btn-primary">
                    تعديل
                </button>
            </div>
        </div>

    </div>
</template>


<script>

export default {
    name: "Edit",
    data() {
        return {
            disableButton: false,
            current_page: 0,
            item: {
                sku: '',
                name_ar: '',
                name_en: '',
                description_ar: '',
                description_en: '',
                slug: '',
                images: [],
                weight: 0,
                tag: {
                    category: {
                        id: null
                    }
                },
                category: '',
                collection: '',
                category_id: '',
                tag_id: '',
                price: 1,
                price_after_discount: 1,
                variants: [
                    {
                        image: null,
                        additional_price: 0,
                        color_id: null,
                        dimension_id: null,
                        dimension_value: null,
                        images: [null],
                    },
                ]
            },
            categories: [{
                id: null,
                name_en: null,
                name_ar: null
            }],
            tags: [{
                id: null,
                name_en: null,
                name_ar: null,
                category_id: null
            }],
            materials: [{
                id: null,
                name_en: null,
                name_ar: null,
            }],

            collections: [{
                id: null,
                name_en: null,
                name_ar: null,
            }],
            dimensions: [{}],
            colors: [{
                id: null,
                name_en: null,
                name_ar: null,
            }]

        };
    },

    created() {
        this.item.slug = this.$route.params.slug;
        this.current_page = this.$route.params.page;
        this.getItem();
        this.getCategory();
        this.getTag();
        this.getMaterial();
        this.getCollection();
        this.getColor();
        this.getDimension();
    },
    methods: {
        getCategory() {
            axios.get('category/all')
                .then(response => {
                    this.categories = response.data.data
                })
                .catch(err => console.log(err))
        },
        getDimension() {
            axios.get('dimension/all')
                .then(response => {
                    this.dimensions = response.data.data
                })
                .catch(err => console.log(err))
        },
        getColor() {
            axios.get('color/all')
                .then(response => {
                    this.colors = response.data.data
                })
                .catch(err => console.log(err))
        },
        getTag(value = null) {
            axios.get('tag/all?category_id=' + (value ? value : 0))
                .then(response => {
                    this.tags = response.data.data
                })
                .catch(err => console.log(err))
        },
        getMaterial() {
            axios.get('material/all')
                .then(response => {
                    this.materials = response.data.data
                })
                .catch(err => console.log(err))
        },
        getCollection() {
            axios.get('collection/all')
                .then(response => {
                    this.collections = response.data.data
                })
                .catch(err => console.log(err))
        },
        getItem() {
            axios.get('/product/get?slug=' + this.item.slug)
                .then(response => {
                    this.item = response.data.data;
                    // console.log(this.item.variants);
                    // this.item.images = [];
                    // this.item.dimension = response.data.data.dimension.dimension;
                }).catch(err => {
                this.errorMessages(err.response.data);
                console.log(err);
            });
        },
        selectCategory: function (e) {
            this.getTag(e.target.value);
            // console.log(e.target.value);
        },
        editItem() {
            this.disableButton = true;
            let formData = new FormData();
            let data = this.getFormData(formData);
            axios.post('product/update', data).then(response => {
                this.disableButton = false;
                this.$router.push({
                    path: '/admin/product',
                    query: {
                        page: this.current_page,
                    }
                });
                swal("Good job!", "A new product has been updated!", "success");
                this.getItem();
                window.scrollTo(0, 0);
            }).catch(err => {
                this.disableButton = false;
                this.errorMessages(err.response.data);
                console.log(err)
            });
        },
        addVariant() {
            this.item.variants.push({
                id: null,
                image: null,
                stock: 1,
                additional_price: 0,
                color_id: null,
                dimension_id: null,
                images: [],
                dimension: null,
            });

        },
        getFormData(formData) {
            this.buildFormData(formData, this.item, null);
            return formData;
        },
        uploadVariantImage(index) {
            // console.log(this.$refs['mainImages'+index][index].files[0])
            console.log(this.$refs['mainImages' + index][0])
            Array.from(this.$refs['mainImages' + index][0].files).forEach((item, indx) => {
                this.item.variants[index].images.push(item);
                console.log(this.item.variants[index].images)
            });
        },
        buildFormData(formData, data, parentKey) {
            if (data && typeof data === 'object' && !(data instanceof Date) && !(data instanceof File) && !(data instanceof Blob)) {
                Object.keys(data).forEach(key => {
                    this.buildFormData(formData, data[key], parentKey ? `${parentKey}[${key}]` : key);
                });
            } else {
                let value = data == null ? '' : data;
                if (typeof (value) === 'string' && parentKey.search('content') > 0) {
                    return;
                }
                if (typeof (data) === 'boolean' && data === false) {
                    value = '0'
                }
                if (typeof (data) === 'boolean' && data === true) {
                    value = '1'
                }
                formData.append(parentKey, value);
            }
        },
        fillPriceAfterDiscount() {
            this.item.price_after_discount = this.item.price;
        }
    }
}
</script>

<style scoped>
li {
    transition: width 1s;
    width: 100px;
    margin-right: -30px;
}

li:hover {
    width: 120px;
}

li a:hover {
    background: aliceblue;

}
</style>
