<template>
    <div>
        <the-side-bar></the-side-bar>
        <the-header></the-header>
        <div class="pcoded-main-container">
            <div class="pcoded-content">
                <!-- [ breadcrumb ] start -->
                <div class="page-header">
                    <div class="page-block">
                        <!--                        <div class="row align-items-center">-->
                        <!--                            <div class="col-md-12">-->
                        <!--                                <div class="page-header-title">-->
                        <!--                                    <h5 class="m-b-10">Dashboard </h5>-->
                        <!--                                </div>-->

                        <!--                            </div>-->
                        <!--                        </div>-->
                    </div>
                </div>
                <!-- [ breadcrumb ] end -->
                <!-- [ Main Content ] start -->
                <!--                <div class="row">-->
                <router-view></router-view>

                <!--                </div>-->
                <!-- [ Main Content ] end -->

            </div>
        </div>
    </div>

</template>

<script>
    import TheHeader from "./../containers/TheHeader.vue";
    import TheSideBar from "./../containers/TheSideBar.vue";
    export default {
        name: "View",
        components: {TheSideBar, TheHeader}
    }
</script>

<style scoped>

</style>
