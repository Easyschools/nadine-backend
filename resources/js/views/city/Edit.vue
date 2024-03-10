<template>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h5>{{translations.general.edit}} {{translations.city.city}}</h5>
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
                <label class="col-form-label">{{translations.city.shippingCharges}}</label>
              </div>
              <div class="col-sm-9">
                <input type="number" step="0.01" class="form-control" v-model="item.shipping_cost" />
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!--        //here-->

    <div class="col-sm-12">
      <div class="col-md-12 text-right">
        <button class="btn btn-secondary mb-3" type="button" @click="addDistrict()">{{translations.general.add}} {{translations.city.newArea}}</button>
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
                  >{{translations.city.area}} {{ index }}</a>
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
                      >{{translations.city.area}} {{ index }}</strong>

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
                      <div class="col-md-3 mt-4 mb-3">
                        <label style="font-weight: bold;">{{translations.general.nameAr}} </label>
                      </div>
                      <div class="col-md-9 mt-3">
                        <input type="text" v-model="district.name_ar" class="form-control" />
                      </div>

                      <div class="col-md-3 mt-4 mb-3">
                        <label style="font-weight: bold;">{{translations.general.nameAr}} </label>
                      </div>
                      <div class="col-md-9 mt-3">
                        <input type="text" v-model="district.name_en" class="form-control" />
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
        <router-link to="/admin/city" class="btn btn-secondary">{{translations.general.cancel}} </router-link>
        <button type="button" @click="editItem" class="btn btn-primary">{{translations.general.edit}} </button>
      </div>
    </div>
  </div>
</template>


<script>
import { VueEditor } from "vue2-editor";

export default {
  name: "Edit",
  components: {
    VueEditor,
  },
  data() {
    return {
      disableButton: false,
      item: {
        name_ar: "",
        name_en: "",
        shipping_cost: "",
        districts: [
          {
            name_ar: null,
            name_en: null,
          },
        ],
      },
    };
  },
  created() {
    this.item.id = this.$route.params.id;
    this.getItem();
  },
  methods: {
    getItem() {
      axios
        .get("/city/get?id=" + this.item.id)
        .then((response) => {
          this.item = response.data.data;
        })
        .catch((err) => {
          this.errorMessages(err.response.data);
          console.log(err);
        });
    },
    editItem() {
      this.disableButton = true;
      let formData = new FormData();
      // formData.append('id', this.item.id);
      let data = this.getFormData(formData);
      axios
        .post("city/edit", data)
        .then((response) => {
          this.disableButton = false;
          // this.$router.push('/admin/city');
          swal("Good job!", "A new city has been updated!", "success");
          this.getItem();
          window.scrollTo(0, 0);
        })
        .catch((err) => {
          this.disableButton = false;
          this.errorMessages(err.response.data);
          console.log(err);
        });
    },
    addDistrict() {
      this.item.districts.push({
        id: null,
        name_ar: null,
        name_en: null,
      });
    },
    getFormData(formData) {
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
