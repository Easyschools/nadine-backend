<template>
    <div class="row">
        <div class="offset-2 col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Create User</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label">Image</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="file" ref="image" v-on:change="uploadImage()">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label">Name</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" v-model="item.name">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label">Email</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" v-model="item.email">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label">Phone</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" v-model="item.phone">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label">Password</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" v-model="item.password">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label class="col-form-label">Confirm Password</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" v-model="item.password_confirmation">
                            </div>
                        </div>
                        <div class="text-center mt-5">
                            <router-link to="/admin/user" class="btn btn-secondary">Close</router-link>
                            <button type="button" @click="createItem()" class="btn btn-primary">Create</button>
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
            item: {
                image: null,
                name: null,
                email: null,
                phone: null,
                password: null,
                password_confirmation: null,
            },
        };
    },
    methods: {
        createItem() {
            let formData = new FormData();
            for (const property in this.item) {
                if (this.item[property] != null) {
                    formData.append(property, this.item[property])
                }
            }
            axios.post('/users', formData)
                .then(response => {
                    this.$router.push('/admin/user');
                    swal("Good job!", "A new user has been added!", "success");
                })
                .catch(err => {
                    this.errorMessages(err.response.data);
                    console.log(err)
                });
        },
        uploadImage() {
            this.item.image = this.$refs.image.files[0];
        }
    }
}
</script>

<style scoped>

</style>
