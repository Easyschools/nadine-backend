<template>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h5>اضافة جديد مدينة</h5>
        </div>
        <!--                ;-->
        <div class="card-body">
          <form>
            <div class="row form-group">
              <div class="col-sm-3">
                <label class="col-form-label">الاسم بالعربية</label>
              </div>
              <div class="col-sm-9">
                <input type="text" class="form-control" v-model="item.name_ar" />
              </div>
            </div>
            <div class="row form-group">
              <div class="col-sm-3">
                <label class="col-form-label">الاسم بالانجليزية</label>
              </div>
              <div class="col-sm-9">
                <input type="text" class="form-control" v-model="item.name_en" />
              </div>
            </div>
            <div class="row form-group">
              <div class="col-sm-3">
                <label class="col-form-label">تكلفة الشحن</label>
              </div>
              <div class="col-sm-9">
                <input type="number" step="0.01" class="form-control" v-model="item.shipping_cost" />
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-sm-12">
      <div class="col-md-12 text-right">
        <button class="btn btn-secondary mb-3" type="button" @click="addDistrict()">اضافة جديد منطقة</button>
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
                <li v-for="(district,index) in item.districts" :key="index">
                  <a
                    :class="(index)?'nav-link text-left':'nav-link text-left active'"
                    id="v-pills-home-tab"
                    data-toggle="pill"
                    :href="'#district'+index"
                    role="tab"
                    aria-controls="v-pills-home"
                    aria-selected="true"
                  >منطقة {{ index }}</a>
                </li>
              </ul>
            </div>
            <div class="col-md-10 col-sm-12">
              <div class="tab-content" id="v-pills-tabContent">
                <div
                  v-for="(district,index) in item.districts"
                  :key="index"
                  :class="(index==0)?'tab-pane fade active show':'tab-pane fade'"
                  :id="'district'+index"
                  role="tabpanel"
                  aria-labelledby="v-pills-home-tab"
                >
                  <div>
                    <div class="row mb-4">
                      <strong
                        class="col-md-5 text-capitalize"
                        style="font-size: 18px"
                      >منطقة {{ index }}</strong>

                      <button
                        type="button"
                        class="float-right btn btn-icon btn-outline-danger"
                        v-if="index!=0||item.districts.length>1"
                        @click="item.districts.splice(index,1)"
                      >
                        <i class="feather icon-x"></i>
                      </button>
                    </div>
                    <div class="row">
                      <div class="col-sm-3">
                        <label class="col-form-label">الاسم بالعربية</label>
                      </div>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" v-model="district.name_ar" />
                      </div>

                      <div class="col-sm-3">
                        <label class="col-form-label">الاسم بالانجليزية</label>
                      </div>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" v-model="district.name_en" />
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
        <router-link to="/admin/city" class="btn btn-secondary">الغاء</router-link>
        <button type="button" @click="createItem" class="btn btn-primary">اضافة</button>
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

      show: false,
      item: {
        name_ar: "",
        name_en: "",
        shipping_cost: "",
        districts: [
          {
            name_ar: "",
            name_en: "",
          },
        ],
      },
    };
  },
  created() {},
  methods: {
    createItem() {
      this.disableButton = true;
      let data = this.getFormData();
      axios
        .post("city/create", data)
        .then((response) => {
          this.$router.push("/admin/city");
          swal("Good job!", "A new city has been added!", "success");
        })
        .catch((err) => {
          this.errorMessages(err.response.data);
          console.log(err);
        });
    },
    addDistrict() {
      this.item.districts.push({
        image: null,
        additional_price: 0,
        stock: 1,
        color_id: null,
        dimension_id: null,
      });
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
  },
};
</script>

<style scoped>
</style>
