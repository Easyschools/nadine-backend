<template>
    <div class="row">
        <div class="offset-2 col-md-10">
            <div class="card">
                <div class="card-header">
                    <h5>Add New Brand</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row form-group">

                            <div class="col-sm-9">
                                <input type="text" class="form-control" v-model="item.name_ar">
                            </div>
                            <div class="col-sm-3">
                                <label class="col-form-label">Name AR</label>
                            </div>
                        </div>
                        <div class="row form-group">

                            <div class="col-sm-9">
                                <input type="text" class="form-control" v-model="item.name_en">
                                <!--<select class="form-control" v-model="item.name_en">-->
                                <!--<option v-for="type in types" :value="type.id">{{type.name}}</option>-->
                                <!--</select>-->
                            </div>
                            <div class="col-sm-3">
                                <label class="col-form-label">Name EN</label>
                            </div>
                        </div>



                        <div class="row form-group " v-if="item.image">
                            <img src="" ref="imageDisplay" class="mr-auto imageDisplay"/>
                        </div>

                        <div class="row form-group">

                            <div class="col-sm-9">
                                <input type="file" ref="myImage" v-on:change="attachImage" class="form-control">
                            </div>

                            <div class="col-sm-3">
                                <label class="col-form-label ">Image</label>
                            </div>

                        </div>

                        <div class="text-center mt-5">
                            <router-link to="/admin/brand" class="btn btn-secondary">Cancel</router-link>
                            <button type="button" @click="createItem()" class="btn btn-primary">Add</button>
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
                    image: null
                }

            };
        },
        created() {

        },
        methods: {
            createItem() {

                let formData = new FormData();
                for (const property in this.item) {
                    if (this.item[property] != null) {
                        formData.append(property, this.item[property])
                    }
                }

                axios.post('/brand/create', formData)
                    .then(response => {
                        this.$router.push('/admin/brand');
                        swal("Good job!", "A new brand has been added!", "success");
                    }).catch(err => {
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
