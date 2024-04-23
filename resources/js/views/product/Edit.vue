<template>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h5>{{ translations.general.edit }} {{ translations.product.product }}</h5>
        </div>
        <div class="card-body">
          <form>
            <div class="row form-group">
              <div class="col-sm-3">
                <label class="col-form-label">{{ translations.product.sku }}</label>
              </div>
              <div class="col-sm-9">
                <input type="text" class="form-control" v-model="item.sku" />
              </div>
            </div>
            <div class="row form-group">
              <div class="col-sm-3">
                <label class="col-form-label">{{ translations.general.nameAr }}</label>
              </div>
              <div class="col-sm-9">
                <input type="text" class="form-control" v-model="item.name_ar" />
              </div>
            </div>
            <div class="row form-group">
              <div class="col-sm-3">
                <label class="col-form-label">{{ translations.general.nameEn }}</label>
              </div>
              <div class="col-sm-9">
                <input type="text" class="form-control" v-model="item.name_en" />
              </div>
            </div>
            <div class="row form-group">
              <div class="col-sm-3">
                <label class="col-form-label">{{
                  translations.general.descriptionAr
                }}</label>
              </div>
              <div class="col-sm-9">
                <input type="text" class="form-control" v-model="item.description_ar" />
              </div>
            </div>
            <div class="row form-group">
              <div class="col-sm-3">
                <label class="col-form-label">{{
                  translations.general.descriptionEn
                }}</label>
              </div>
              <div class="col-sm-9">
                <input type="text" class="form-control" v-model="item.description_en" />
              </div>
            </div>

            <div class="row form-group">
              <div class="col-sm-3">
                <label class="col-form-label">{{ translations.product.price }}</label>
              </div>
              <div class="col-sm-9">
                <input
                  type="number"
                  v-on:keyup="fillPriceAfterDiscount"
                  class="form-control"
                  v-model="item.price"
                />
              </div>
            </div>
            <div class="row form-group">
              <div class="col-sm-3">
                <label class="col-form-label">{{
                  translations.product.priceAfterDiscount
                }}</label>
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
                <label class="col-form-label">{{
                  translations.category.categories
                }}</label>
              </div>
              <div class="col-sm-9">
                <select
                  class="form-control"
                  @change="selectCategory()"
                  v-model="item.tag.category_id"
                >
                  <option
                    v-for="(category, index) in categories"
                    :key="index"
                    :value="category.id"
                  >
                    {{ category.name_ar }} - {{ category.name_en }}
                  </option>
                </select>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-sm-3">
                <label class="col-form-label">{{ translations.product.type }}</label>
              </div>
              <div class="col-sm-9">
                <select class="form-control" v-model="item.tag_id">
                  <option v-for="tag in tags" :value="tag.id">
                    {{ tag.name_ar }} - {{ tag.name_en }}
                  </option>
                </select>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-sm-3">
                <label class="col-form-label">{{
                  translations.collection.collection
                }}</label>
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

            <div class="row form-group">
              <div class="col-sm-3">
                <label class="col-form-label">{{ translations.product.new }}</label>
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
                <label class="col-form-label">{{
                  translations.product.LimitedProduct
                }}</label>
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
                  {{ translations.product.bestSeller }}</label
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
            <div class="row form-group">
              <div class="col-sm-3">
                <label class="col-form-label">Old File:</label>
              </div>
              <div class="col-sm-9">
                <div class="form-check align-bottom mt-2">
                  <!-- Display the name of the old file -->
                  <div v-if="item.files">
                    <p>
                      <a :download="item.files" :href="item.files"> {{ item.files }}</a>
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-sm-3">
                <label class="col-form-label">upload pdf</label>
              </div>
              <div class="col-sm-9">
                <div class="form-check align-bottom mt-2">
                  <!-- Display the name of the old file -->

                  <!-- Input field to upload a new file -->
                  <input
                    type="file"
                    class="form-control"
                    id="pdfUpload"
                    ref="fileInput"
                    @change="handleFileChange"
                  />
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!--        //here-->
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h5>{{ translations.general.add }} {{ translations.product.subProduct }}</h5>
        </div>
        <div class="card-body">
          <!-- <form> -->

          <div class="row form-group">
            <div class="col-sm-3">
              <label class="col-form-label">Make a look</label>
            </div>
            <div class="col-sm-9">
              <!-- <select class="form-control" v-model="item.sub_products" multiple>
                <option v-for="product in products" :value="product.id">
                  {{ product.name_ar }} -
                  {{ product.name_en }}
                </option>
              </select> -->
              <v-select
                v-model="item.sub_products"
                :options="formattedOptions"
                multiple
                searchable
                label="name"
                placeholder="Select options..."
              ></v-select>
            </div>
          </div>

          <!-- </form> -->
        </div>
      </div>
    </div>

    <div class="col-sm-12">
      <div class="col-md-12 text-right">
        <button class="btn btn-secondary mb-3" type="button" @click="addVariant()">
          {{ translations.general.add }} {{ translations.general.new }}
          {{ translations.general.product }}
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
                    :class="index ? 'nav-link text-left' : 'nav-link text-left active'"
                    id="v-pills-home-tab"
                    data-toggle="pill"
                    :href="'#variant' + index"
                    role="tab"
                    aria-controls="v-pills-home"
                    aria-selected="true"
                  >
                    {{ translations.product.type }} {{ index }}
                  </a>
                </li>
              </ul>
            </div>
            <div class="col-md-10 col-sm-12">
              <div class="tab-content" id="v-pills-tabContent">
                <div
                  v-for="(variant, index) in item.variants"
                  :class="index == 0 ? 'tab-pane fade active show' : 'tab-pane fade'"
                  :id="'variant' + index"
                  role="tabpanel"
                  aria-labelledby="v-pills-home-tab"
                >
                  <div>
                    <div class="row mb-4">
                      <strong class="col-md-5 text-capitalize" style="font-size: 18px">
                        {{ translations.product.type }} {{ index }}
                      </strong>

                      <button
                        type="button"
                        class="float-right btn btn-icon btn-outline-danger"
                        v-if="index != 0 || item.variants.length > 1"
                        @click="item.variants.splice(index, 1)"
                      >
                        <i class="feather icon-x"></i>
                      </button>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="row form-group">
                          <div
                            class="col-md-3 m-2"
                            v-if="variant.images.length > 0"
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
                            <label style="font-weight: bold" class="col-form-label">{{
                              translations.general.image
                            }}</label>
                          </div>

                          <div class="col-md-9">
                            <input
                              type="file"
                              :ref="'mainImages' + index"
                              @change="uploadVariantImage(index)"
                              multiple
                            />
                          </div>
                        </div>
                      </div>

                      <div class="col-md-3 mt-4 mb-3">
                        <label style="font-weight: bold">{{
                          translations.color.colors
                        }}</label>
                      </div>
                      <div class="col-md-9 mt-3">
                        <!-- <select class="form-control" v-model="variant.color_id">
                          <option value=""></option>
                          <option v-for="color in colors" :value="color.id">
                            {{ color.name_ar }} -
                            {{ color.name_en }}
                          </option>
                        </select> -->

                        <v-select
                          v-model="variant.color_variant"
                          :options="formattedColor"
                          multiple
                          searchable
                          label="name"
                          placeholder="Select options..."
                        ></v-select>
                      </div>

                      <div class="col-md-3">
                        <label class="col-form-label">{{
                          translations.material.materials
                        }}</label>
                      </div>
                      <div class="col-md-9">
                        <select class="form-control" v-model="variant.material_id">
                          <option v-for="material in materials" :value="material.id">
                            {{ material.name_ar }} -
                            {{ material.name_en }}
                          </option>
                        </select>
                      </div>

                      <div class="col-md-3 mt-4 mb-3">
                        <label style="font-weight: bold">{{
                          translations.size.size
                        }}</label>
                      </div>
                      <div class="col-md-9 mt-3">
                        <v-select
                          v-model="variant.dimension_variant"
                          :options="formattedDimension"
                          multiple
                          searchable
                          label="dimension"
                          placeholder="Select options..."
                        ></v-select>
                        <!-- <select class="form-control" v-model="variant.dimension_id">
                          <option value=""></option>
                          <option v-for="dimension in dimensions" :value="dimension.id">
                            {{ dimension.dimension }}
                          </option>
                        </select> -->
                      </div>

                      <div class="col-md-3 mt-4 mb-3">
                        <label style="font-weight: bold">{{
                          translations.product.additionalPrice
                        }}</label>
                      </div>
                      <div class="col-md-9 mt-3">
                        <input
                          type="number"
                          v-model="variant.additional_price"
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
          :to="{
            path: '/admin/product/',
            query: {
              page: current_page,
            },
          }"
          class="btn btn-secondary"
        >
          {{ translations.general.cancel }}
        </router-link>
        <button type="button" @click="editItem" class="btn btn-primary">
          {{ translations.general.edit }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
// import vSelect from "vue-select";
import vSelect from "vue-select/dist/vue-select.js";


export default {
  name: "Edit",
  components: {
    vSelect,
  },
  data() {
    return {
      disableButton: false,
      current_page: 0,
      item: {
        product_id: [], // Holds the selected product IDs

        sub_products: [], // Initialize as an empty array for multiple selections
        dimension_variant: [], // Initialize as an empty array for multiple selections
        color_variant: [], // Initialize as an empty array for multiple selections

        // fileData: null, // Assuming file data is retrieved from the database and stored here
        sku: "",
        name_ar: "",
        name_en: "",
        description_ar: "",
        description_en: "",
        slug: "",
        images: [],
        weight: 0,
        new_arrival: "",
        best_selling: "",
        limited_edition: "",
        files: null, // Assuming file data will be stored here
        tags: [], // Initialize tags array
        tag_id: null, // Initialize tag_id

        tag: {
          category_id: null,
          category: {
            id: null,
          },
        },
        category: "",
        collection: "",
        price: 1,
        price_after_discount: 1,
        variants: [
          {
            image: null,
            variant_image: null,
            additional_price: 0,
            color_id: null,
            dimension_id: null,
            // color_variant: [null],
            // dimension_variant: [null],
            // dimension_value: null,
            images: [null],
          },
        ],
      },

      products: [
        {
          id: null,
          name_en: null,
          name_ar: null,
        },
      ],

      categories: [],
      tags: [], // Store all tags here
      selectedCategory: null,
      selectedTags: [],
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
      dimensions: [
        {
          id: null,
          dimension: null,
          // dimension_value:null,
          // name_ar: null,
        },
      ],
      colors: [
        {
          id: null,
          name_en: null,
          name_ar: null,
        },
      ],
    };
  },
  computed: {
    formattedOptions() {
      return this.products.map((product) => ({
        id: product.id,
        name: `${product.name} - ${product.sku}`, // Concatenate name and SKU
        // ...product // Include other properties from the product
      }));
    },
    formattedColor() {
      return this.colors.map((color) => ({
        id: color.id,
        name: color.name_en, // You can customize this based on your color object structure
      }));
    },
    formattedDimension() {
      return this.dimensions.map((dimension) => ({
        id: dimension.id,
        dimension: dimension.dimension, // You can customize this based on your color object structure
      }));
    },
  },
  created() {
    this.item.slug = this.$route.params.slug;
    this.current_page = this.$route.params.page;
    this.getItem();
    this.getCategory();
    this.getProduct();
    // this.getTags();
    this.getMaterial();
    this.getCollection();
    this.getColor();
    this.getDimension();
    // this.selectCategory(category.id); // Call selectCategory with initial category_id

    // this.fetchTags(this.item.tag.category_id);
  },
  methods: {
    openFileInput() {
      this.$refs.fileInput.click(); // Trigger the file input click event
    },

    handleFileChange(event) {
      const file = event.target.files; // Get the selected file
      if (file) {
        this.item.files = file; // Store the selected file object
      }
    },

    selectCategory() {
      const selectedCategory = this.categories.find(
        (cat) => cat.id === this.item.tag.category_id
      );

      if (selectedCategory) {
        this.selectedCategory = selectedCategory;
        axios
          .get("tag/all?categoryId=" + selectedCategory.id)
          .then((response) => {
            this.tags = response.data.data;
            // Populate item.tags with default tag IDs
            this.item.tags = this.tags.map((tag) => tag.id);
          })
          .catch((err) => {
            console.log(err);
          });
      } else {
        this.selectedCategory = null;
        this.tags = [];
        this.item.tags = [];
      }
    },

    getCategory() {
      axios
        .get("category/all")
        .then((response) => {
          this.categories = response.data.data;
        })
        .catch((err) => console.log(err));
    },
    getProduct() {
      axios
        .get("product/all")
        .then((response) => {
          console.log("product", response.data.data.data);
          this.products = response.data.data.data;
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
    getTags(category_id) {
      console.log("this.item.tag.category_id fistt =" + category_id);

      axios
        //   .get("tag/all?categoryId=" + this.item.category[0])
        .get("tag/all?categoryId=" + category_id)
        .then((response) => {
          this.tags = response.data.data;
          // Populate item.tags with default tag IDs
          this.item.tags = this.tags.map((tag) => tag.id);
        })
        .catch((err) => {
          console.log(err);
        });

      //  axios
      //   .get("tag/all?categoryId=" + this.item.category[0])
      //   .then((response) => {
      //     console.log('this.item.tag.category_id'+this.item.tag.category_id);
      //     this.tags = response.data.data;
      //     // Populate item.tags with default tag IDs
      //     this.item.tags = this.tags.map((tag) => tag.id);
      //   })
      //   .catch((err) => {
      //     console.log(err);
      //   });

      // } else {
      //   this.selectedCategory = null;
      //   this.tags = [];
      //   this.item.tags = [];
      // }
      // },
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
    getItem() {
      axios
        .get("/product/get?slug=" + this.item.slug)
        .then((response) => {
          this.item = response.data.data;
          this.item.tag_id = response.data.data.tag_id;
          this.item.category_id = response.data.data.tag.category_id;
          // console.log(this.item.category_id);
          console.log("getIrem", this.item.category_id);
          this.getTags(response.data.data.tag.category_id);

          this.item.product_details = this.item.product_detail.details;
          // Map category IDs to category objects
          if (this.item.category && Array.isArray(this.item.category)) {
            this.item.category.forEach((categoryId, index) => {
              // Assuming you have access to categories data
              const category = this.categories.find((cat) => cat.id === categoryId);
              if (category) {
                // Replace category ID with category object
                this.item.category[index] = category;
              }
              // Call getTags after category_id is set
            });
          }

          // Call getTags() here
        })
        .catch((err) => {
          this.errorMessages(err.response.data);
          console.log(err);
        });
    },

    editItem() {
      this.disableButton = true;
      let formData = new FormData();
      let data = this.getFormData(formData);

      if (data.variants && Array.isArray(data.variants)) {
        console.log("yes");
        data.variants.forEach((variant, variantIndex) => {
          if (variant.images && Array.isArray(variant.images)) {
            variant.images.forEach((image, imageIndex) => {
              // Check if image is a File object
              if (image instanceof File) {
                // Append new image to FormData
                formData.append(
                  `variants[${variantIndex}][images][${imageIndex}]`,
                  image
                );
              }
            });
          }
        });
      }
      //         else{
      //              formData.append('variants.images', []);
      // console.log('no');
      //         }

      axios
        .post("product/update", data)
        .then((response) => {
          this.disableButton = false;
          this.$router.push({
            path: "/admin/product",
            query: {
              page: this.current_page,
            },
          });
          swal("Good job!", "A new product has been updated!", "success");
          this.getItem();
          window.scrollTo(0, 0);
        })
        .catch((err) => {
          this.disableButton = false;
          this.errorMessages(err.response.data);
          console.log(err);
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
        // dimension: null,
      });
    },
    getFormData(formData) {
      this.buildFormData(formData, this.item, null);
      return formData;
    },

    uploadVariantImage(index) {
      // console.log(this.$refs['mainImages'+index][index].files[0])
      console.log(this.$refs["mainImages" + index][0]);
      Array.from(this.$refs["mainImages" + index][0].files).forEach((item, indx) => {
        this.item.variants[index].images.push(item);
        console.log(this.item.variants[index].images);
      });
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
        if (typeof value === "string" && parentKey.search("content") > 0) {
          return;
        }
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
