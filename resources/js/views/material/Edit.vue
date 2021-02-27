<template>
    <div class="row">
        <div class="offset-2 col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Edit Material</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label">Name AR:</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" v-model="item.name_ar">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label">Name EN:</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" v-model="item.name_en">
                            </div>
                        </div>
                        <!--<div class="row">-->
                        <!--<div class="col-sm-3">-->
                        <!--<label class="col-form-label">اللون</label>-->
                        <!--</div>-->
                        <!--<div class="col-sm-9">-->
                        <!--<chrome-picker v-if="show" :value="colors" v-model="colors"></chrome-picker>-->
                        <!--</div>-->
                        <!--</div>-->
                        <div class="text-center mt-5">
                            <router-link to="/admin/material" class="btn btn-secondary">Cancel</router-link>
                            <button type="button" @click="editItem()" class="btn btn-primary">Edit</button>
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
                    color: null,
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
                axios.get('material/get?id=' + this.item.id)
                    .then(response => {
                        this.item = response.data.data
                        // this.colors = this.item.color
                    })
                    .catch(err => console.log(err))
            },

            editItem() {
                // let color = (this.colors.hex)?this.colors.hex:this.colors;
                // console.log(color)
                axios.post('material/edit', {
                    id: this.item.id,
                    name_ar: this.item.name_ar,
                    name_en: this.item.name_en,
                })
                    .then(response => {
                        this.$router.push('/admin/material');
                        swal("Good job!", "A new material has been updated!", "success");
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
