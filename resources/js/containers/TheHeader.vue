<template>
    <header class="navbar pcoded-header navbar-expand-lg navbar-light header-blue">
        <div class="m-header">
            <!--            <a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>-->
            <router-link to="/admin/home" class="b-brand" style="font-size: 40px">
                <a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
                <a href="#!" class="b-brand">
                    <!-- ========   change your logo hear   ============ -->
                    <img src="assets/images/logo.png" alt="" class="logo">

                </a>
                <a href="#!" class="mob-toggler">
                    <i class="feather icon-more-vertical"></i>
                </a>
                <!-- ========   change your logo hear   ============ -->
                Unitart
                <!--<img height="150" width="180" src="/img/logo.png" alt="" class="logo">-->
                <!--<pre>-->
                <!--تعليم وتعلم-->
                <!--الاعراب النحوى-->
                <!--بالالوان-->
                <!--</pre>-->
            </router-link>
            <a href="#!" class="mob-toggler">
                <i class="feather icon-more-vertical"></i>
            </a>
        </div>
        <div class="collapse navbar-collapse">

            <ul class="navbar-nav ml-auto">
                <li>
                    <div class="dropdown drp-user">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="feather icon-user"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-notification"
                             style="left: 0 !important; min-width: auto;">
                            <ul class="pro-body" style="padding: 0;">
                                <!--                                <li><a href="user-profile.html" class="dropdown-item"><i class="feather icon-user"></i> Profile</a></li>-->
                                <!--                                <li><a href="email_inbox.html" class="dropdown-item"><i class="feather icon-mail"></i> My Messages</a></li>-->
                                <li style="margin: 10px;">
                                    <a href="#" v-on:click="submit()" class="dropdown-item">
                                        <i class="feather icon-log-out"></i>

                                        تسجيل الخروج
                                    </a></li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </header>

</template>

<script>
import {mapActions} from 'vuex';

export default {
    name: "TheHeader",

    methods: {
        ...mapActions({
            logoutAction: 'auth/logout'
        }),
        submit() {
            this.logoutAction()
                .then(() => {
                    this.$router.push('/admin/login')
                })
            // axios.post('/admin/logout')
            //     .then((response) => {
            //         console.log('success');
            //         window.location.href = '/admin/login/';
            //     })
            //     .catch((error) => console.log(error))
        }
    }
}
</script>
<style scoped>

</style>
