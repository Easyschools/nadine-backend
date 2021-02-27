<template>
    <div class="container">

        <div class="row">
            <div class="mx-auto col-md-4" style="margin-top: 25vh">
                <div class="card">
                    <div class="card-header text-center">
                        <h4 class="mb-3 f-w-400">Login</h4>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="form-group fill">
                                <label class="form-label">Email</label>
                                <input v-model="form.email" type="text" class="form-control" placeholder="Email">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group fill">
                                <label class="form-label">Password</label>
                                <input v-model="form.password" type="password" class="form-control"
                                       placeholder="Password">
                            </div>
                        </div>
                        <div class="col-md-12 text-center" v-if="showError">
                            <p class="text-danger">Wrong in Password or Email</p>
                        </div>

                        <div class="col-md-12">
                            <button @click="submit" class="btn btn-outline-primary float-right" type="button">Login
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapActions} from 'vuex';

    export default {
        name: "Login",
        data() {
            return {
                form: {
                    email: null,
                    password: null,
                },
                showError: false
            }
        },
        methods: {
            ...mapActions({
                login: 'auth/login'
            }),
            submit() {
                this.login(this.form)
                    .then(() => {
                        this.$router.push('/admin/home')
                    })
                    .catch(() => {
                        this.showError = true;
                    })
            }

        }
    }
</script>

<style scoped>

</style>
