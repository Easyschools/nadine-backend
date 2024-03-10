<template>
    <div class="row">
        <div class="offset-2 col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>{{translations.general.edit}} {{translations.color.colors}}</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label">{{translations.general.nameAr}} :</label>
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

                        <div class="row form-group " v-if="item.image">
                            <img :src="item.image" ref="imageDisplay" class="mr-auto imageDisplay"/>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">{{translations.general.image}}:</label>
                            <input type="file" ref="myImage" v-on:change="attachImage"
                                   class="form-control"
                                   id="recipient-image">
                        </div>

                        <div class="text-center mt-5">
                            <router-link to="/admin/color" class="btn btn-secondary">{{translations.general.cancel}}</router-link>
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
            colors: "#194d33",
            item: {
                id: null,
                image: null,
                name: null
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
            axios.get('color/get?id=' + this.item.id)
                .then(response => {
                    this.item = response.data.data;
                    this.colors = this.item.code;
                })
                .catch(err => console.log(err))
        },

        editItem() {
            let formData = new FormData();
            for (const property in this.item) {
                if (this.item[property] != null) {
                    formData.append(property, this.item[property])

                }
            }
            // let color = (this.colors.hex) ? this.colors.hex : this.colors;
            // console.log(color)
            axios.post('color/edit',formData)
                .then(response => {
                    // this.$router.push('/admin/color');
                    swal("Good job!", "A new type has been updated!", "success");
                    this.getItem();
                    window.scrollTo(0,0);
                })
                .catch(err => {
                    this.errorMessages(err.response.data);
                    console.log(err)
                });
        },
        attachImage() {
            this.item.image = this.$refs.myImage.files[0];
            let reader = new FileReader();
            reader.addEventListener('load', function () {
                this.$refs.imageDisplay.src = reader.result;
            }.bind(this), false);

            reader.readAsDataURL(this.item.image);
        },
    }
}
</script>

<style scoped>

</style>
