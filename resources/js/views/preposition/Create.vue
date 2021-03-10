<template>
    <div class="row">
        <div class="offset-2 col-md-10">
            <div class="card">
                <div class="card-header">
                    <h5>اضافة درس للادوات العامله</h5>
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
                        <div class="row mb-4">
                            <div class="col-sm-3">
                                <label class="col-form-label">النص</label>
                            </div>
                            <div class="col-sm-9">
                                <textarea class="form-control" v-model="item.text"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <label class="col-form-label">اللون</label>
                            </div>
                            <div class="col-sm-9">
                                <chrome-picker v-if="show" :value="colors" v-model="colors"></chrome-picker>
                            </div>
                        </div>
                        <div class="text-center mt-5">
                            <router-link to="/admin/preposition" class="btn btn-secondary">الغاء</router-link>
                            <button type="button" @click="createItem()" class="btn btn-primary">اضافة</button>
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
        name: "Create",
        components: {
            'chrome-picker': Chrome
        },
        data() {
            return {
                show: false,
                colors: "#194d33",
                item: {
                    color: null,
                    name: null,
                    text: null
                }
            };
        },
        created() {
            this.show = true;
        },
        methods: {
            createItem() {
                let color = (this.colors.hex)?this.colors.hex:this.colors;
                axios.post('prepositions', {
                    color: color,
                    name: this.item.name,
                    text: this.item.text,
                })
                    .then(response => {
                        this.$router.push('/admin/preposition');
                        swal("Good job!", "A new type has been added!", "success");
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
