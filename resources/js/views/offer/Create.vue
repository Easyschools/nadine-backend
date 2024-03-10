<template>
  <div class="row">
    <div class="offset-2 col-md-10">
      <div class="card">
        <div class="card-header">
          <h5>{{translations.general.add}} {{translations.offer.offer}}</h5>
        </div>
        <div class="card-body">
          <form>
            <div class="row form-group">
              <div class="col-sm-3">
                <label class="col-form-label">{{translations.general.nameAr}}</label>
              </div>

              <div class="col-sm-9">
                <input type="text" class="form-control" v-model="item.name_ar" />
              </div>
            </div>
            <div class="row form-group">
              <div class="col-sm-3">
                <label class="col-form-label">{{translations.general.nameEn}}</label>
              </div>
              <div class="col-sm-9">
                <input type="text" class="form-control" v-model="item.name_en" />
              </div>
            </div>
            <div class="row form-group">
              <div class="col-sm-3">
                <label class="col-form-label">{{translations.offer.percentage}}</label>
              </div>
              <div class="col-sm-9">
                <input type="checkbox" class="form-control" v-model="item.is_percentage" />
              </div>
            </div>

            <div class="row form-group">
              <div class="col-sm-3">
                <label class="col-form-label">{{translations.offer.discount}}</label>
              </div>
              <div class="col-sm-9">
                <input
                  type="number"
                  autocomplete="off"
                  class="form-control"
                  v-model="item.discount"
                />
              </div>
            </div>

            <div class="row form-group">
              <div class="col-sm-3">
                <label class="col-form-label">{{translations.offer.expireDate}}</label>
              </div>
              <div class="col-sm-9 text-center">
                <!-- <date-picker v-model="item.expire_at" type="datetime"></date-picker> -->

                <date-picker format="YYYY-MM-DD" v-model="item.expire_at" value-type="format"></date-picker>
                <!--<datetime ></datetime>-->
                <!--<input type="date" class="form-control" v-model="item.expire_at">-->
              </div>
            </div>

            <div class="row form-group">
              <div class="col-sm-3">
                <label class="col-form-label">{{translations.category.categories}}</label>
              </div>
              <div class="col-sm-9">
                <select class="form-control" @change="selectTags()" v-model="item.category_id">
                  <option v-for="(category,index) in categories" :key="index" :value="category.id">
                    {{category.name_ar }} -
                    {{category.name_en}}
                  </option>
                </select>
              </div>
            </div>

            <div class="row form-group" v-show="tags.length > 0">
              <div class="col-sm-3">
                <label class="col-form-label">{{translations.category.types}}</label>
              </div>
              <div class="col-sm-9">
                <select id="tags_id" class="form-control" multiple v-model="item.tags">
                  <option
                    v-for="(item, index) in tags"
                    :key="index"
                    :value="item.id"
                  >{{item.name_ar }} - {{item.name_en}}</option>
                </select>
              </div>
            </div>

            <div class="row form-group" v-if="item.image">
              <img src ref="imageDisplay" class="mr-auto imageDisplay" />
            </div>

            <div class="text-center mt-5">
              <router-link to="/admin/offer" class="btn btn-secondary">{{translations.general.cancel}}</router-link>
              <button type="button" @click="createItem()" class="btn btn-primary">{{translations.general.add}}</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
export default {
  name: "Create",
  template: "...",
  components: {
    DatePicker,
  },
  data() {
    return {
      show: false,
      item: {
        name_ar: "",
        name_en: "",
        discount: "",
        is_percentage: 1,
        expire_at: "",
        category_id: null,
        tags: [],
      },
      categories: [
        {
          id: null,
          name_en: null,
          name_ar: null,
        },
      ],
      tags: [],
    };
  },
  created() {
    this.getCategory();
  },
  methods: {
    async selectTags() {
      const selected = await this.categories.find(
        (item) => item.id == this.item.category_id
      );
      this.tags = selected?.tags ?? [];
      await this.tags.forEach((item) => {
        this.item.tags.push(item.id);
      });

      document.getElementById("tags_id").focus();
    },
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
          if (property == "is_percentage") {
            formData.append(property, this.item[property] ? 1 : 0);
          } else {
            formData.append(property, this.item[property]);
          }
        }
      }

      axios
        .post("/offer/create", formData)
        .then((response) => {
          this.$router.push("/admin/offer");
          console.log(response?.data);
          swal("Good job!", "A new offer has been added!", "success");
        })
        .catch((err) => {
          this.errorMessages(err.response.data);
          console.error(err?.response?.data);
        });
    },
  },
};
</script>

<style scoped>
</style>
