<template>
    <div class="row">
        <div class="offset-2 col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>{{translations.general.edit}} {{translations.collection.collection}}</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label">{{translations.general.nameAr}}:</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" v-model="item.name_ar">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label">{{translations.general.nameEn}}:</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" v-model="item.name_en">
                            </div>
                        </div>

                        <div class="row form-group" v-if="item.image">
              <img
                :src="item.image"
                ref="imageDisplay"
                class="mr-auto imageDisplay"
              />
            </div>

            <div class="row form-group">
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
                        <div class="text-center mt-5">
                            <router-link to="/admin/collection" class="btn btn-secondary">{{translations.general.cancel}}</router-link>
                            <button type="button" @click="editItem()" class="btn btn-primary">{{translations.general.edit}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import {Chrome} from 'vue-color'

export default {
    name: "Edit",
    components: {
        'chrome-picker': Chrome
    },
    data() {
        return {
            show: false,
      image_is_changed: false,

            item: {
                id: null,
                color: null,
                name: null,
        image: null,

            }
        };
    },
    created() {
        this.item.id = this.$route.params.id;
        this.show = true;
        this.getItem();
    },
    methods: {
        getItem() {
            axios.get('collection/get?id=' + this.item.id)
                .then(response => {
                    this.item = response.data.data
                })
                .catch(err => console.log(err))
        },

        editItem() {
            axios.post('collection/edit', {
                id: this.item.id,
                name_ar: this.item.name_ar,
                name_en: this.item.name_en,
                image: this.item.image,
                
            })
                .then(response => {
                    // this.$router.push('/admin/collection');
                    swal("Good job!", "A new collection has been updated!", "success");
                    this.getItem();
                    window.scrollTo(0,0);
                })
                .catch(err => {
                    this.errorMessages(err.response.data);
                    console.log(err)
                });
        }
    }
}
</script>

<style scoped>

</style>
