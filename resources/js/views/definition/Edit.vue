<template>
    <div class="row">
        <div class="offset-2 col-md-10">
            <div class="card">
                <div class="card-header">
                    <h5>تعديل على درس اللتعريفات</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label">الاسم</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" v-model="item.name">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label">النوع</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control" v-model="item.type_id">
                                    <option v-for="type in types" :value="type.id">{{type.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <label class="col-form-label">النص</label>
                            </div>
                            <div class="col-sm-9">
                                <vue-editor v-model="item.text"></vue-editor>
                            </div>
                        </div>
                        <div class="text-center mt-5">
                            <router-link to="/admin/definition" class="btn btn-secondary">الغاء</router-link>
                            <button type="button" @click="editItem()" class="btn btn-primary">تعديل</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import {VueEditor} from "vue2-editor";

    export default {
        name: "Edit",
        components: {
            VueEditor
        },
        data() {
            return {
                show: false,
                item: {
                    type_id: null,
                    name: null
                },
                types: [{id: null, name: null}]
            };
        },
        created() {
            this.item.id = this.$route.params.id;
            this.getItem();
            this.getTypes();
        },
        methods: {
            getTypes() {
                axios.get('types')
                    .then(response => {
                        this.types = response.data.data
                    })
                    .catch(err => console.log(err))
            },
            getItem() {
                axios.get('/definitions/' + this.item.id)
                    .then(response => {
                        this.item = response.data.data
                    })
                    .catch(err => console.log(err))
            },
            editItem() {
                axios.put('/definitions/' + this.item.id, {
                    text: this.item.text,
                    name: this.item.name,
                    type_id: this.item.type_id,
                })
                    .then(response => {
                        this.$router.push('/admin/definition');
                        swal("Good job!", "A new type has been updated!", "success");
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
