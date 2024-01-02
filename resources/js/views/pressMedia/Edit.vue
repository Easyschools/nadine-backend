<template>
  <div class="row">
    <div class="offset-2 col-md-10">
      <div class="card">
        <div class="card-header">
          <h5>تعديل واجهة المستخدم</h5>
        </div>
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
                <label class="col-form-label">اختر النوع</label>
              </div>
              <div class="col-sm-9">
                <select v-model="item.type" class="form-control">
                  <option value="image">صورة</option>
                  <option value="article">مقال</option>
                  <option value="video">فيديو</option>
                </select>
              </div>
            </div>
            <div
              class="row form-group"
              v-if="item.type === 'image' || item.type === 'article'"
            >
              <img :src="item.image" ref="imageDisplay" class="mr-auto imageDisplay" />
            </div>

            <!-- Conditional rendering based on selected type -->
            <div v-if="item.type === 'image'" class="row form-group">
              <div class="col-sm-3">
                <label class="col-form-label">صورة</label>
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
                <label class="col-form-label">صورة</label>
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
                <label class="col-form-label">الرابط</label>
              </div>
              <div class="col-sm-9">
                <input type="text" class="form-control" v-model="item.url" />
              </div>
            </div>

            <div v-if="item.type === 'video'" class="row form-group">
              <div class="col-sm-3">
                <label class="col-form-label">الرابط</label>
              </div>
              <div class="col-sm-9">
                <input type="text" class="form-control" v-model="item.url" />
              </div>
              <!-- Hide image input for video type -->
            </div>

            <div class="text-center mt-5">
              <router-link to="/admin/pressMedia" class="btn btn-secondary"
                >الغاء</router-link
              >
              <button type="button" @click="editItem()" class="btn btn-primary">
                تعديل
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

  if (this.item.type === "video") {
    // If the selected type is video, set image to null
    this.item.image = null;

    // Disable and hide the file input
    fileInput.disabled = true;
    fileInput.style.display = "none";
  } else {
    // For other types, enable and show the file input
    fileInput.disabled = false;
    fileInput.style.display = "block";

    if (fileInput.files.length > 0) {
      this.item.image = fileInput.files[0];

      let reader = new FileReader();

      reader.addEventListener("load", () => {
        this.url = reader.result;
        this.$refs.imageDisplay.src = this.url;
      });

      reader.readAsDataURL(this.item.image);
    }
  }
},


    getItem() {
      axios
        .get("/media/get?id=" + this.item.id)
        .then((response) => {
          this.item = response.data.data;
        })
        .catch((err) => console.log(err));
    },
    editItem() {
      let data = new FormData();

      // Append non-image properties
      for (const property in this.item) {
        if (property !== "image" && property !== "url") {
          data.append(property, this.item[property]);
        }
      }

      // Append image or URL based on media type
      if (this.item.type == "image") {
        data.append("image", this.item.image);
        data.append("url", null);
      } else if (this.item.type === "article") {
        data.append("image", this.item.image); // Append image for article type
        data.append("url", this.item.url);
      } else if (this.item.type === "video") {
        data.append("url", this.item.url);
        data.append("image", null);
      }
      // data.append('id', this.item.id);
      axios
        .post(`/media/edit`, data)
        .then((response) => {
          swal("Good job!", "A media has been updated!", "success");
          this.getItem(); // Refresh the data after successful update
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
