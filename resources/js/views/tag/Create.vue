<template>
  <div class="row">
    <div class="offset-2 col-md-10">
      <div class="card">
        <div class="card-header">
          <h5>{{ translations.general.add }} {{ translations.tag.tags }}</h5>
        </div>
        <div class="card-body">
          <form>
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
                <!--<select class="form-control" v-model="item.name_en">-->
                <!--<option v-for="type in types" :value="type.id">{{type.name}}</option>-->
                <!--</select>-->
              </div>
            </div>
            <!-- 
                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">{{translations.tag.shippingWithinCairo}}</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" v-model="item.cost_inside_cairo"> -->
            <!--<select class="form-control" v-model="item.name_en">-->
            <!--<option v-for="type in types" :value="type.id">{{type.name}}</option>-->
            <!--</select>-->
            <!-- </div>
                        </div> -->

            <!-- 
                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">{{translations.tag.shippingOutsideCairo}}</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" v-model="item.cost_outside_cairo"> -->
            <!--<select class="form-control" v-model="item.name_en">-->
            <!--<option v-for="type in types" :value="type.id">{{type.name}}</option>-->
            <!--</select>-->
            <!-- </div>
                        </div> -->

            <div class="row form-group">
              <div class="col-sm-3">
                <label class="col-form-label">{{
                  translations.category.categories
                }}</label>
              </div>
              <div class="col-sm-9">
                <select class="form-control" v-model="item.category" multiple>
                  <option v-for="category in categories" :value="category.id">
                    {{ category.name_ar }} -
                    {{ category.name_en }}
                  </option>
                </select>
              </div>
            </div>
            <!-- 
                        <div class="row form-group " v-if="item.image">
                            <img src="" ref="imageDisplay" class="mr-auto imageDisplay"/>
                        </div> -->

            <!-- <div class="row form-group"> -->

            <!-- <div class="col-sm-3">
                                <label class="col-form-label ">{{translations.general.image}}</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="file" ref="myImage" v-on:change="attachImage" class="form-control">
                            </div> -->
            <!--<div class="col-sm-9">-->
            <!--<b-form-tags input-id="tags-basic" v-model="item.text" class="mb-2"></b-form-tags>-->
            <!--</div>-->
            <!--<div class="col-sm-3">-->
            <!--<label class="col-form-label">النص</label>-->
            <!--</div>-->
            <!-- </div> -->

            <div class="text-center mt-5">
              <router-link to="/admin/tag" class="btn btn-secondary">{{
                translations.general.cancel
              }}</router-link>
              <button type="button" @click="createItem()" class="btn btn-primary">
                {{ translations.general.add }}
              </button>
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
        cost_inside_cairo: null,
        cost_outside_cairo: null,
        category_id: null,
        image: null,
        category: [], // This is already an array to handle multiple selections
      },
      categories: [],
    //   categories: [
    //     {
    //       id: null,
    //       name_en: null,
    //       name_ar: null,
    //     },
    //   ],
    };
  },
  created() {
    this.getCategory();
  },
  methods: {
    getCategory() {
      axios
        .get("category/all")
        .then((response) => {
          this.categories = response.data.data;
        })
        .catch((err) => console.log(err));
    },
    createItem() {
      let formData = new FormData();
      for (const property in this.item) {
        if (this.item[property] != null) {
          formData.append(property, this.item[property]);
        }
      }
      

      axios
        .post("/tag/create", formData)
        .then((response) => {
          this.$router.push("/admin/tag");
          swal("Good job!", "A new tag has been added!", "success");
        })
        .catch((err) => {
          this.errorMessages(err.response.data);
          console.log(err);
        });
    },
    attachImage() {
      this.item.image = this.$refs.myImage.files[0];
      let reader = new FileReader();
      reader.addEventListener(
        "load",
        function () {
          this.$refs.imageDisplay.src = reader.result;
        }.bind(this),
        false
      );

      reader.readAsDataURL(this.item.image);
    },
  },
};
</script>

<style scoped></style>
