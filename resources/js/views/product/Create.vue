<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>اضافة جديد منتج</h5>
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
                                    v-model="item.sku"
                                />
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label"
                                    >الاسم بالعربية</label
                                >
                            </div>
                            <div class="col-sm-9">
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="item.name_ar"
                                />
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label"
                                    >الاسم بالانجليزية</label
                                >
                            </div>
                            <div class="col-sm-9">
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="item.name_en"
                                />
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label"
                                    >الوصف بالعربية</label
                                >
                            </div>
                            <div class="col-sm-9">
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="item.description_ar"
                                />
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label"
                                    >الوصف بالانجليزية</label
                                >
                            </div>
                            <div class="col-sm-9">
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="item.description_en"
                                />
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label">السعر</label>
                            </div>
                            <div class="col-sm-9">
                                <!-- <input type="number" v-on:keyup="fillPriceAfterDiscount" class="form-control"
                                       v-model="item.price"> -->
                                <input
                                    type="number"
                                    class="form-control"
                                    v-model="item.price"
                                />
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label"
                                    >السعر بعد الخصم</label
                                >
                            </div>
                            <div class="col-sm-9">
                                <input
                                    type="number"
                                    class="form-control"
                                    v-model="item.price_after_discount"
                                />
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label">الفئة</label>
                            </div>
                            <div class="col-sm-9">
                                <select
                                    class="form-control"
                                    v-on:change="selectCategory"
                                    v-model="item.category_id"
                                >
                                    <option
                                        v-for="category in categories"
                                        :value="category.id"
                                    >
                                        {{ category.name_ar }} -
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
                                <select
                                    class="form-control"
                                    v-model="item.tag_id"
                                >
                                    <option v-for="tag in tags" :value="tag.id">
                                        {{ tag.name_ar }} - {{ tag.name_en }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label">الخامة</label>
                            </div>
                            <div class="col-sm-9">
                                <select
                                    class="form-control"
                                    v-model="item.material_id"
                                >
                                    <option
                                        v-for="material in materials"
                                        :value="material.id"
                                    >
                                        {{ material.name_ar }} -
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
                                <select
                                    class="form-control"
                                    v-model="item.collection_id"
                                >
                                    <option
                                        v-for="collection in collections"
                                        :value="collection.id"
                                    >
                                        {{ collection.name_ar }} -
                                        {{ collection.name_en }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label"
                                    >تفاصيل المنتج
                                </label>
                            </div>
                            <div class="col-sm-9">
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="item.product_details"
                                />
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label"
                                    >صورة المنتج
                                </label>
                            </div>
                            <div class="col-sm-9">
                                <input
                                    type="file"
                                    class="form-control"
                                    @change="handleFileChange"
                                />
                            </div>
                        </div> -->

                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label">جديد</label>
                            </div>
                            <div class="col-sm-9">
                                <div class="form-check align-bottom mt-2">
                                    <input
                                        type="checkbox"
                                        class="form-check-input align-bottom"
                                        v-model="item.new_arrival"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label">منتج محدود</label>
                            </div>
                            <div class="col-sm-9">
                                <div class="form-check align-bottom mt-2">
                                    <input
                                        type="checkbox"
                                        class="form-check-input align-bottom"
                                        v-model="item.limited_edition"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label">
                                    افضل مبيعا</label
                                >
                            </div>
                            <div class="col-sm-9">
                                <div class="form-check align-bottom mt-2">
                                    <input
                                        type="checkbox"
                                        class="form-check-input align-bottom"
                                        v-model="item.best_selling"
                                    />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="col-md-12 text-right">
                <button
                    class="btn btn-secondary mb-3"
                    type="button"
                    @click="addVariant()"
                >
                    اضافة جديد توع منتج
                </button>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 col-sm-12">
                            <ul
                                class="nav flex-column nav-pills"
                                id="v-pills-tab"
                                role="tablist"
                                aria-orientation="vertical"
                            >
                                <li v-for="(variant, index) in item.variants">
                                    <a
                                        :class="
                                            index
                                                ? 'nav-link text-left'
                                                : 'nav-link text-left active'
                                        "
                                        id="v-pills-home-tab"
                                        data-toggle="pill"
                                        :href="'#variant' + index"
                                        role="tab"
                                        aria-controls="v-pills-home"
                                        aria-selected="true"
                                    >
                                        نوع {{ index }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-10 col-sm-12">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div
                                    v-for="(variant, index) in item.variants"
                                    :class="
                                        index == 0
                                            ? 'tab-pane fade active show'
                                            : 'tab-pane fade'
                                    "
                                    :id="'variant' + index"
                                    role="tabpanel"
                                    aria-labelledby="v-pills-home-tab"
                                >
                                    <div>
                                        <div class="row mb-4">
                                            <strong
                                                class="col-md-5 text-capitalize"
                                                style="font-size: 18px"
                                            >
                                                نوع {{ index }}
                                            </strong>

                                            <button
                                                type="button"
                                                class="float-right btn btn-icon btn-outline-danger"
                                                v-if="
                                                    index != 0 ||
                                                    item.variants.length > 1
                                                "
                                                @click="
                                                    item.variants.splice(
                                                        index,
                                                        1
                                                    )
                                                "
                                            >
                                                <i class="feather icon-x"></i>
                                            </button>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row form-group">
                                                    <div
                                                        class="col-md-3 m-2"
                                                        v-if="
                                                            variant.images
                                                                .length > 0
                                                        "
                                                        v-for="image in variant.images"
                                                    >
                                                        <img
                                                            v-if="image"
                                                            :src="image.image"
                                                            width="200px"
                                                            height="200px"
                                                        />
                                                    </div>
                                                </div>

                                                <div class="row form-group">
                                                    <div class="col-sm-3">
                                                        <label
                                                            style="
                                                                font-weight: bold;
                                                            "
                                                            class="col-form-label"
                                                            >الصورة</label
                                                        >
                                                    </div>

                                                    <div class="col-md-9">
                                                        <input
                                                            type="file"
                                                            :ref="
                                                                'mainImages' +
                                                                index
                                                            "
                                                            @change="
                                                                uploadVariantImage(
                                                                    index
                                                                )
                                                            "
                                                            multiple
                                                        />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 mt-4 mb-3">
                                                <label style="font-weight: bold"
                                                    >اللون</label
                                                >
                                            </div>
                                            <div class="col-md-9 mt-3">
                                                <select
                                                    class="form-control"
                                                    v-model="variant.color_id"
                                                >
                                                    <option value=""></option>
                                                    <option
                                                        v-for="color in colors"
                                                        :value="color.id"
                                                    >
                                                        {{ color.name_ar }} -
                                                        {{ color.name_en }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mt-4 mb-3">
                                                <label style="font-weight: bold"
                                                    >المقاس</label
                                                >
                                            </div>
                                            <div class="col-md-9 mt-3">
                                                <input
                                                    type="text"
                                                    v-model="variant.dimension"
                                                    class="form-control"
                                                />
                                            </div>

                                            <div class="col-md-3 mt-4 mb-3">
                                                <label style="font-weight: bold"
                                                    >السعر الاضافى</label
                                                >
                                            </div>
                                            <div class="col-md-9 mt-3">
                                                <input
                                                    type="number"
                                                    v-model="
                                                        variant.additional_price
                                                    "
                                                    class="form-control mob_no"
                                                    autocomplete="off"
                                                    maxlength="2"
                                                />
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
                <router-link
                    v-if="!disableButton"
                    to="/admin/product"
                    class="btn btn-secondary"
                >
                    الغاء
                </router-link>
                <button
                    v-if="!disableButton"
                    type="button"
                    @click="createItem"
                    class="btn btn-primary"
                >
                    اضافة
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import alertsMixin from "../../mixins/alertsMixin";

export default {
    name: "Create",
    data() {
        return {
            disableButton: false,

            show: true,
            item: {
                name_ar: "",
                name_en: "",
                sku: "",
                description_ar: "",
                description_en: "",
                tag: "",
                category: "",
                collection: "",
                price: null,
                new_arrival: 0,
                best_selling: 0,
                limited_edition: 0,
                // product_details_image: null,
                // product_details: null,
                // image: null,
                variants: [
                    {
                        image: null,
                        additional_price: 0,
                        color_id: null,
                        dimension_id: null,
                        images: [],
                    },
                ],
            },
            categories: [
                {
                    id: null,
                    name_en: null,
                    name_ar: null,
                },
            ],
            tags: [
                {
                    id: null,
                    name_en: null,
                    name_ar: null,
                    category_id: null,
                },
            ],
            materials: [
                {
                    id: null,
                    name_en: null,
                    name_ar: null,
                },
            ],

            collections: [
                {
                    id: null,
                    name_en: null,
                    name_ar: null,
                },
            ],
            dimensions: [{}],
            colors: [
                {
                    id: null,
                    name_en: null,
                    name_ar: null,
                },
            ],
        };
    },
    created() {
        this.getCategory();
        this.getTag();
        this.getMaterial();
        this.getCollection();
        this.getColor();
        this.getDimension();
    },
    methods: {
        // handleFileChange(event) {
        //     const file = event.target.files[0];

        //     // Update the data property with the selected file
        //     this.item.product_details_image = file;

        //     // You can also preview the image if needed
        //     this.previewImage(file);
        // },

        // previewImage(file) {
        //     // Perform image preview logic if needed
        //     // For example, using FileReader to display a preview
        //     const reader = new FileReader();

        //     reader.onload = (e) => {
        //         // Access the image URL
        //         const imageUrl = e.target.result;

        //         // Update the image preview logic here
        //         // For example, setting a preview image in your component
        //         // this.previewImageUrl = imageUrl;
        //     };

        //     reader.readAsDataURL(file);
        // },
        getCategory() {
            axios
                .get("category/all")
                .then((response) => {
                    this.categories = response.data.data;
                })
                .catch((err) => console.log(err));
        },
        getDimension() {
            axios
                .get("dimension/all")
                .then((response) => {
                    this.dimensions = response.data.data;
                })
                .catch((err) => console.log(err));
        },
        getColor() {
            axios
                .get("color/all")
                .then((response) => {
                    this.colors = response.data.data;
                })
                .catch((err) => console.log(err));
        },
        getTag(value = null) {
            axios
                .get("tag/all?category_id=" + (value ? value : 0))
                .then((response) => {
                    this.tags = response.data.data;
                })
                .catch((err) => console.log(err));
        },
        getMaterial() {
            axios
                .get("material/all")
                .then((response) => {
                    this.materials = response.data.data;
                })
                .catch((err) => console.log(err));
        },
        getCollection() {
            axios
                .get("collection/all")
                .then((response) => {
                    this.collections = response.data.data;
                })
                .catch((err) => console.log(err));
        },
        createItem() {
            // console.log(.this.item.new_arrival);
            this.disableButton = true;
            let data = this.getFormData();
            console.log(data);

            axios
                .post("/product/create", data)
                .then((response) => {
                    this.$router.push("/admin/product");
                    swal(
                        "Good job!",
                        "A new product has been added!",
                        "success"
                    );
                })
                .catch((err) => {
                    this.errorMessages(err.response.data);
                    console.log(err);
                });
            this.disableButton = false;
        },
        addVariant() {
            this.item.variants.push({
                image: null,
                additional_price: 0,
                stock: 1,
                color_id: null,
                dimension_id: null,
                images: [],
            });
        },
        selectCategory: function (e) {
            this.getTag(e.target.value);
            // console.log(e.target.value);
        },

        uploadVariantImage(index) {
            console.log(this.$refs["mainImages" + index][0]);
            Array.from(this.$refs["mainImages" + index][0].files).forEach(
                (item, indx) => {
                    this.item.variants[index].images.push(item);
                    console.log(this.item.variants[index].images);
                }
            );

            // this.item.variants[index].image = this.$refs['variant' + index][0].files[0];
            //
            // let reader = new FileReader();
            //
            // reader.readAsDataURL(this.item.variants[index].image);
            //
            // reader.addEventListener('load', function () {
            //     this.$refs['imageDisplay_' + index][0].src = reader.result;
            //     console.log(reader);
            // }.bind(this), false);
        },
        getFormData() {
            let formData = new FormData();
            this.buildFormData(formData, this.item, null);
            return formData;
        },
        buildFormData(formData, data, parentKey) {
            if (
                data &&
                typeof data === "object" &&
                !(data instanceof Date) &&
                !(data instanceof File) &&
                !(data instanceof Blob)
            ) {
                Object.keys(data).forEach((key) => {
                    this.buildFormData(
                        formData,
                        data[key],
                        parentKey ? `${parentKey}[${key}]` : key
                    );
                });
            } else {
                let value = data == null ? "" : data;
                if (typeof data === "boolean" && data === false) {
                    value = "0";
                }
                if (typeof data === "boolean" && data === true) {
                    value = "1";
                }
                formData.append(parentKey, value);
            }
        },
        fillPriceAfterDiscount() {
            this.item.price_after_discount = this.item.price;
        },
    },
};
</script>

<style scoped></style>
