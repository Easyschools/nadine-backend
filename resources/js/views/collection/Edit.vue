<template>
    <div class="row">
        <div class="offset-2 col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Edit Collection</h5>
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
                        <div class="text-center mt-5">
                            <router-link to="/admin/collection" class="btn btn-secondary">Cancel</router-link>
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
