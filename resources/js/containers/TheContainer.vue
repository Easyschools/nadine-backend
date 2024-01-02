<template>
   <!-- <div>
        <the-side-bar></the-side-bar>
        <the-header></the-header>
        <div class="pcoded-main-container">
            <div class="pcoded-content">
                &lt;!&ndash; [ breadcrumb ] start &ndash;&gt;
                <div class="page-header">
                    <div class="page-block">
&lt;!&ndash;                        <div class="row align-items-center">&ndash;&gt;
&lt;!&ndash;                            <div class="col-md-12">&ndash;&gt;
&lt;!&ndash;                                <div class="page-header-title">&ndash;&gt;
&lt;!&ndash;                                    <h5 class="m-b-10">Dashboard </h5>&ndash;&gt;
&lt;!&ndash;                                </div>&ndash;&gt;

&lt;!&ndash;                            </div>&ndash;&gt;
&lt;!&ndash;                        </div>&ndash;&gt;
                    </div>
                </div>-->
                <!-- [ breadcrumb ] end -->
                <!-- [ Main Content ] start -->
<!--                <div class="row">-->
                    <router-view></router-view>
<!--                </div>-->
                <!-- [ Main Content ] end -->
<!--

            </div>
        </div>
    </div>
-->

</template>

<script>
    import TheHeader from "./TheHeader.vue";
    import TheSideBar from "./TheSideBar.vue";
    export default {
        name: "TheContainer",
        components: {TheSideBar, TheHeader}
    }
</script>

<style scoped>
.pcoded-main-container{
 min-height: 82vh;
}
</style>
