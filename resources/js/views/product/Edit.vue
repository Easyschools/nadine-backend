<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Edit Product</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">Slug</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" v-model="item.slug">
                            </div>
                        </div>
                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">Name AR</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" v-model="item.name_ar">
                            </div>
                        </div>
                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">Name En</label>
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
                                <label class="col-form-label">Description AR</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" v-model="item.description_ar">
                            </div>
                        </div>
                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">Description En</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" v-model="item.description_en">
                            </div>
                        </div>

                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">Price</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="number" v-on:keyup="fillPriceAfterDiscount" class="form-control"
                                       v-model="item.price">
                            </div>
                        </div>
                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">Price After Discount</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="number"  class="form-control" v-model="item.price_after_discount">
                            </div>
                        </div>

                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">Weight</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="number"  class="form-control" v-model="item.weight">
                            </div>
                        </div>


                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">Category</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control" v-model="item.category_id">
                                    <option v-for="category in categories" :value="category.id">{{ category.name_ar }} -
                                        {{ category.name_en }}
                                    </option>
                                </select>
                            </div>

                        </div>


                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">Tag</label>
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
                                <label class="col-form-label">Material</label>
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
                                <label class="col-form-label">Collection</label>
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
                    Add New Product Variant
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
                                        Variant {{ index }}
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
                                                Variant {{ index }}
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

                                                    <div class="col-sm-12 pb-3 text-center" v-if="variant.image">
                                                        <img :src="variant.image" :ref="'imageDisplay_'+ index"
                                                             class="mr-auto imageDisplay"/>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <label style="font-weight: bold;"
                                                               class="col-form-label ">Image</label>
                                                    </div>

                                                    <div class="col-md-9">
                                                        <input type="file" :ref="'variant'+index"
                                                               @change="uploadVariantImage(index)">
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
                                                <label style="font-weight: bold;">Color</label>
                                            </div>
                                            <div class="col-md-9 mt-3">
                                                <select class="form-control" v-model="variant.color_id">
                                                    <option v-for="color in colors" :value="color.id">
                                                        {{ color.name_ar }} -
                                                        {{ color.name_en }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mt-4 mb-3">
                                                <label style="font-weight: bold;">Dimension</label>
                                            </div>
                                            <div class="col-md-9 mt-3">
                                                <select class="form-control" v-model="variant.dimension_id">
                                                    <option v-for="dimension in dimensions" :value="dimension.id">
                                                        {{ dimension.dimension }}
                                                    </option>
                                                </select>
                                            </div>


                                            <div class="col-md-3 mt-4 mb-3">
                                                <label style="font-weight: bold;">Stock</label>
                                            </div>
                                            <div class="col-md-9 mt-3">

                                                <input type="number" v-model="variant.stock"
                                                       class="form-control mob_no"
                                                       autocomplete="off" maxlength="2">
                                            </div>

                                            <div class="col-md-3 mt-4 mb-3">
                                                <label style="font-weight: bold;">additional_price</label>
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
                <router-link to="/admin/product" class="btn btn-secondary">
                    Cancel
                </router-link>
                <button type="button" @click="editItem" class="btn btn-primary">
                    Add
                </button>
            </div>
        </div>

    </div>
</template>


<script>
    import {VueEditor} from "vue2-editor";

    export default {
        name: "Edit",
        components: {
            VueEditor
        },
        data() {
            return {
                disableButton: false,
                item: {
                    name_ar: '',
                    name_en: '',
                    description_ar: '',
                    description_en: '',
                    slug: '',
                    weight: 0,
                    tag: '',
                    category: '',
                    collection: '',
                    price: 1,
                    price_after_discount: 1,
                    variants: [
                        {
                            image: null,
                            stock: 1,
                            additional_price: 0,
                            color_id: null,
                            dimension_id: null,
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
            this.item.id = this.$route.params.id;
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
            getTag() {
                axios.get('tag/all')
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
                axios.get('/product/get?id=' + this.item.id)
                    .then(response => {
                        this.item = response.data.data;
                    }).catch(err => {
                    this.errorMessages(err.response.data);
                    console.log(err);
                });
            },
            editItem() {
                this.disableButton = true;
                let formData = new FormData();
                // formData.append('id', this.item.id);
                let data = this.getFormData(formData);
                axios.post('/product/edit/', data).then(response => {
                    this.disableButton = false;
                    // this.$router.push('/admin/product');
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
                })
            },
            getFormData(formData) {
                this.buildFormData(formData, this.item, null);
                return formData;
            },
            uploadVariantImage(index) {
                this.item.variants[index].image = this.$refs['variant' + index][0].files[0];

                let reader = new FileReader();
                reader.addEventListener('load', function () {
                    this.$refs['imageDisplay_' + index][0].src = reader.result;
                }.bind(this), false);

                reader.readAsDataURL(this.item.variants[index].image);

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
