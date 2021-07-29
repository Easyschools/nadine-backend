<template>
  <div class="row">
    <div class="offset-2 col-md-10">
      <div class="card">
        <div class="card-header">
          <h5>تعديل العرض</h5>
        </div>
        <div class="card-body">
          <form>
            <div class="row form-group">
              <div class="col-sm-9">
                <input type="text" class="form-control" v-model="item.name_ar" />
              </div>
              <div class="col-sm-3">
                <label class="col-form-label">الاسم بالعربية</label>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-sm-9">
                <input type="text" class="form-control" v-model="item.name_en" />
              </div>
              <div class="col-sm-3">
                <label class="col-form-label">الاسم بالانجليزية</label>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-sm-9">
                <input type="checkbox" class="form-control" v-model="item.is_percentage" />
              </div>
              <div class="col-sm-3">
                <label class="col-form-label">نسبة مئوية</label>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-sm-9">
                <input
                  type="number"
                  autocomplete="off"
                  class="form-control"
                  v-model="item.discount"
                />
              </div>
              <div class="col-sm-3">
                <label class="col-form-label">التخفيض</label>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-sm-9 text-center">
                <date-picker v-model="item.expire_at" value-type="format"></date-picker>
                <!--<datetime ></datetime>-->
                <!--<input type="date" class="form-control" v-model="item.expire_at">-->
              </div>
              <div class="col-sm-3">
                <label class="col-form-label">تاريخ الانتهاء</label>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-sm-9">
                <select class="form-control" v-model="item.category_id">
                  <option v-for="(category,index) in categories" :key="index" :value="category.id">
                    {{category.name_ar }} -
                    {{category.name_en}}
                  </option>
                </select>
              </div>

              <div class="col-sm-3">
                <label class="col-form-label">الفئة</label>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-sm-9">
                <select class="form-control" multiple v-model="item.tags">
                  <option v-for="(tag,index) in tags" :key="index" :value="tag.id">
                    {{tag.name_ar }} -
                    {{tag.name_en}}
                  </option>
                </select>
              </div>

              <div class="col-sm-3">
                <label class="col-form-label">الانواع</label>
              </div>
            </div>

            <div class="text-center mt-5">
              <router-link to="/admin/offer" class="btn btn-secondary">الغاء</router-link>
              <button type="button" @click="editItem()" class="btn btn-primary">تعديل</button>
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
  components: {
    DatePicker,
  },
  data() {
    return {
      url: null,
      show: false,
      item: {
        category_id: null,
        id: null,
        name_ar: "",
        name_en: "",
        discount: "",
        is_percentage: 1,
        expire_at: "",
        tags: [],
      },
      categories: [{ id: null, name_ar: null, name_en: null }],
      tags: [],
    };
  },
  created() {
    this.item.id = this.$route.params.id;
    this.getItem();
    this.getCategories();
  },
  methods: {
    getCategories() {
      axios
        .get("category/all")
        .then((response) => {
          this.categories = response.data.data;
          const selected = this.categories.find(
            (item) => item.id == this.item.category_id
          );

          this.tags = selected.tags;
          //   this.tags = this.
        })
        .catch((err) => console.log(err));
    },
    getItem() {
      axios
        .get("/offer/get?id=" + this.item.id)
        .then((response) => {
          this.item = response.data.data;
          this.item.tags = this.item.tags ?? [];
          let tags = [];
          this.item.tags.forEach((item) => {
            tags.push(item.id);
          });
          this.item.tags = tags;
          console.log(this.item);
        })
        .catch((err) => console.log(err));
    },
    editItem() {
      let data = new FormData();
      for (const property in this.item) {
        if (this.item[property] != null) {
          if (property == "is_percentage") {
            data.append(property, this.item[property] ? 1 : 0);
          } else {
            data.append(property, this.item[property]);
          }
        }
      }

      // data.append('id', this.item.id);
      axios
        .post("/offer/edit", data)
        .then((response) => {
          // this.$router.push('/admin/offer');
          swal("Good job!", "a offer has been updated!", "success");
          this.getItem();
          window.scrollTo(0, 0);
          console.log(response?.data);
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

<style scoped>
</style>
