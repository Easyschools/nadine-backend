<template>
  <div class="row">
    <div class="offset-2 col-md-10">
      <div class="card">
        <div class="card-header">
          <h5>
            {{ translations.general.add }} {{ translations.celebrities.celebrities }}
          </h5>
        </div>
        <div class="card-body">
          <form>
            <div class="row form-group">
              <div class="col-sm-3">
                <label class="col-form-label">{{ translations.general.nameAr }} </label>
              </div>
              <div class="col-sm-9">
                <input type="text" class="form-control" v-model="item.name_ar" />
              </div>
            </div>
            <div class="row form-group">
              <div class="col-sm-3">
                <label class="col-form-label">{{ translations.general.nameEn }} </label>
              </div>
              <div class="col-sm-9">
                <input type="text" class="form-control" v-model="item.name_en" />
              </div>
            </div>

            <div class="row form-group" v-if="item.image">
              <img :src="item.image" ref="imageDisplay" class="mr-auto imageDisplay" />
            </div>

            <div class="row form-group">
              <div class="col-sm-3">
                <label class="col-form-label">{{ translations.general.image }} </label>
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
            <div class="text-center mt-5">
              <router-link to="/admin/celebrity" class="btn btn-secondary"
                >{{ translations.general.cancel }}
              </router-link>
              <button type="button" @click="editItem()" class="btn btn-primary">
                {{ translations.general.edit }}
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
      url: null,
      show: false,
      image_is_changed: false,
      item: {
        id: null,
        name_en: null,
        name_ar: null,
        image: null,
      },
    };
  },
  created() {
    this.item.id = this.$route.params.id;
    this.getItem();
  },
  methods: {
    attachImage() {
      const fileInput = this.$refs.myImage;

      if (fileInput.files.length > 0) {
        this.item.image = fileInput.files[0];

        let reader = new FileReader();

        reader.addEventListener("load", () => {
          this.url = reader.result;
          this.$refs.imageDisplay.src = this.url;
          this.image_is_changed = true;
        });

        reader.readAsDataURL(this.item.image);
      }
    },
    getItem() {
      axios
        .get("/celebrity/get?id=" + this.item.id)
        .then((response) => {
          this.item = response.data.data;
        })
        .catch((err) => console.log(err));
    },
    editItem() {
      let data = new FormData();

      // Append non-image properties
      for (const property in this.item) {
        if (property !== "image") {
          data.append(property, this.item[property]);
        }
      }

      // Append image only if it has changed
      if (this.image_is_changed) {
        data.append("image", this.item.image);
      }

      // data.append('id', this.item.id);
      axios
        .post("/celebrity/edit", data)
        .then((response) => {
          // this.$router.push('/admin/slider');
          swal("Good job!", "a celebrity has been updated!", "success");
          this.getItem();
          window.scrollTo(0, 0);
        })
        .catch((err) => {
          this.errorMessages(err.response.data);
          console.log(err);
        });
    },
    // attachImage() {
    //   this.item.image = this.$refs.myImage.files[0];
    //   let reader = new FileReader();
    //   reader.addEventListener(
    //     "load",
    //     function () {
    //       this.$refs.imageDisplay.src = reader.result;
    //     }.bind(this),
    //     false
    //   );

    //   reader.readAsDataURL(this.item.image);
    //   this.image_is_changed = true;
    //   this.url = URL.createObjectURL(this.item.image);
    // },
  },
};
</script>

<style scoped></style>
