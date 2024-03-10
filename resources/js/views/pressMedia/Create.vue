<template>
  <div class="row">
    <div class="offset-2 col-md-10">
      <div class="card">
        <div class="card-header">
          <h5>{{translations.general.add}} {{translations.journalisticMedia.journalisticMedia}}</h5>
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
                <!--<select class="form-control" v-model="item.name_en">-->
                <!--<option v-for="type in types" :value="type.id">{{type.name}}</option>-->
                <!--</select>-->
              </div>
            </div>

            <div class="row form-group">
              <div class="col-sm-3">
                <label class="col-form-label">{{translations.journalisticMedia.type}}</label>
              </div>
              <div class="col-sm-9">
                <select v-model="item.type" class="form-control">
                  <option value="image">{{translations.general.image}}</option>
                  <option value="article">{{translations.journalisticMedia.article}}</option>
                  <option value="video">{{translations.journalisticMedia.video}}</option>
                </select>
              </div>
            </div>

            <!-- Conditional rendering based on selected type -->
               <div v-if="item.type === 'image'" class="row form-group">
              <div class="col-sm-3">
                <label class="col-form-label">{{translations.general.image}}</label>
              </div>
              <div class="col-sm-9">
                <input
                  type="file"
                  ref="myImage"
                  v-on:change="attachImage"
                  class="form-control"
                />
              </div>
            </div>
      <div v-if="item.type === 'article'" class="row form-group">
              <div class="col-sm-3">
                <label class="col-form-label">{{translations.general.image}}</label>
              </div>
              <div class="col-sm-9">
                <input
                  type="file"
                  ref="myImage"
                  v-on:change="attachImage"
                  class="form-control"
                />
              </div>
              <div class="col-sm-3">
                <label class="col-form-label">{{translations.journalisticMedia.link}}</label>
              </div>
              <div class="col-sm-9">
                <input type="text" class="form-control" v-model="item.url" />
              </div>
            </div>

            <div v-if="item.type === 'video'" class="row form-group">
              <div class="col-sm-3">
                <label class="col-form-label">{{translations.journalisticMedia.link}}</label>
              </div>
              <div class="col-sm-9">
                <input type="text" class="form-control" v-model="item.url" />
              </div>
            </div>

            <div class="text-center mt-5">
              <router-link to="/admin/pressMedia" class="btn btn-secondary"
                >{{translations.general.cancel}}</router-link
              >
              <button type="button" @click="createItem()" class="btn btn-primary">
                {{translations.general.add}}
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
        image: null,
        type: "image", // Default type
        url: null,
      },
  
    };
  },
  created() {
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
        .post("/media/create", formData)
        .then((response) => {
          this.$router.push("/admin/pressMedia");
          swal("Good job!", "A new media has been added!", "success");
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
