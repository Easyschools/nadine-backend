<template>
    <nav class="pcoded-navbar menu-light">
        <div class="navbar-wrapper">
            <div class="navbar-content scroll-div">
                <ul class="nav pcoded-inner-navbar ">

                    <li class="nav-item pcoded-menu-caption">
                        <label>المناطق</label>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/city">
                            <span class="pcoded-micon">
                                <i class="fas fa-city"></i>
                            </span>
                            <span class="pcoded-mtext">المدن</span>
                        </router-link>
                    </li>

                    <li class="nav-item pcoded-menu-caption">
                        <label>الواجهات</label>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/slider">
                            <span class="pcoded-micon">
                                <i class="fas fa-images"></i>
                            </span>
                            <span class="pcoded-mtext">صور الواجهة</span>
                        </router-link>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/information">
                            <span class="pcoded-micon">
                                <i class="fas fa-id-card"></i>
                            </span>
                            <span class="pcoded-mtext">معلومات الإتصال</span>
                        </router-link>
                    </li>

                    <li class="nav-item pcoded-menu-caption">
                        <label>الأنواع</label>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/category">
                            <span class="pcoded-micon">
                                <i class="fas fa-th-large"></i>
                            </span>
                            <span class="pcoded-mtext">فئات</span>
                        </router-link>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/tag">
                            <span class="pcoded-micon">
                                    <i class="fas fa-tags"></i>
                            </span>
                            <span class="pcoded-mtext">أنواع</span>
                        </router-link>
                    </li>

                    <!--                    <li class="nav-item pcoded-hasmenu">-->
                    <!--                        <router-link to="/admin/definition">-->
                    <!--                            <span class="pcoded-micon">-->
                    <!--                                <i class="feather icon-align-center"></i>-->
                    <!--                            </span>-->
                    <!--                            <span class="pcoded-mtext">التعريفات</span>-->
                    <!--                        </router-link>-->
                    <!--                    </li>-->
                    <!--                    <li class="nav-item pcoded-hasmenu">-->
                    <!--                        <router-link to="/admin/preposition">-->
                    <!--                            <span class="pcoded-micon">-->
                    <!--                                <i class="feather icon-sliders"></i>-->
                    <!--                            </span>-->
                    <!--                            <span class="pcoded-mtext">الادوات العامله</span>-->
                    <!--                        </router-link>-->
                    <!--                    </li>-->


                    <!--<li class="nav-item pcoded-menu-caption">-->
                    <!--<label>Features</label>-->
                    <!--</li>-->

                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/material">
                            <span class="pcoded-micon">
                                <i class="fas fa-thumbtack"></i>
                            </span>
                            <span class="pcoded-mtext">خامات</span>
                        </router-link>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/collection">
                            <span class="pcoded-micon">
                                <i class="fas fa-clone"></i>
                            </span>
                            <span class="pcoded-mtext">مجموعات</span>
                        </router-link>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/dimension">
                            <span class="pcoded-micon">
                                <i class="feather icon-edit-1"></i>
                            </span>
                            <span class="pcoded-mtext">مقاسات</span>
                        </router-link>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/color">
                            <span class="pcoded-micon">
                                <i class="fas fa-palette"></i>
                            </span>
                            <span class="pcoded-mtext">ألوان</span>
                        </router-link>
                    </li>

                    <!--<li class="nav-item pcoded-hasmenu">-->
                        <!--<router-link to="/admin/brand">-->
                            <!--<span class="pcoded-micon">-->
                                <!--<i class="fas fa-copyright"></i>-->
                            <!--</span>-->
                            <!--<span class="pcoded-mtext">Brands</span>-->
                        <!--</router-link>-->
                    <!--</li>-->


                    <li class="nav-item pcoded-menu-caption">
                        <label>المنتجات</label>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/product">
                            <span class="pcoded-micon">
                                <i class="fas fa-couch"></i>
                            </span>
                            <span class="pcoded-mtext">منتجات</span>
                        </router-link>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/favourite">
                            <span class="pcoded-micon">
                                <i class="fas fa-star"></i>
                            </span>
                            <span class="pcoded-mtext">مُفضلة</span>
                        </router-link>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/coupon">
                            <span class="pcoded-micon">
                                <i class="fas fa-book-open"></i>
                            </span>
                            <span class="pcoded-mtext">كوبونات</span>
                        </router-link>
                    </li>
                    <!--                    <li class="nav-item pcoded-hasmenu">-->
                    <!--                        <router-link to="/admin/lesson">-->
                    <!--                            <span class="pcoded-micon">-->
                    <!--                                <i class="fas fa-book-open"></i>-->
                    <!--                            </span>-->
                    <!--                            <span class="pcoded-mtext">الدروس</span>-->
                    <!--                        </router-link>-->
                    <!--                    </li>-->

                    <!--                    <li class="nav-item pcoded-hasmenu">-->
                    <!--                        <router-link to="/admin/exercise">-->
                    <!--                            <span class="pcoded-micon">-->
                    <!--                                <i class="fas fa-file-excel"></i>-->
                    <!--                            </span>-->
                    <!--                            <span class="pcoded-mtext">التدريبات</span>-->
                    <!--                        </router-link>-->
                    <!--                    </li>-->

                    <li class="nav-item pcoded-menu-caption">
                        <label>الطلبات</label>
                    </li>

                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/offer">
                            <span class="pcoded-micon">
                                <i class="fas fa-percentage"></i>
                            </span>
                            <span class="pcoded-mtext">عروض</span>
                        </router-link>
                    </li>

                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/status">
                            <span class="pcoded-micon">
                                <i class="fas fa-battery-quarter"></i>
                            </span>
                            <span class="pcoded-mtext">حالات</span>
                        </router-link>
                    </li>

                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/order">
                            <span class="pcoded-micon">
                                <i class="feather icon-shopping-cart"></i>
                            </span>
                            <span class="pcoded-mtext">طلبات</span>
                        </router-link>
                    </li>

                    <li class="nav-item pcoded-menu-caption">
                        <label>المستخدمين</label>
                    </li>

                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/customer">
                            <span class="pcoded-micon">
                                <i class="feather icon-users"></i>
                            </span>
                            <span class="pcoded-mtext">مستخدمين</span>
                        </router-link>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/message">
                            <span class="pcoded-micon">
                                <i class="fas fa-mail-bulk"></i>
                            </span>
                            <span class="pcoded-mtext">رسائل</span>
                        </router-link>
                    </li>

                </ul>

            </div>
        </div>
    </nav>
</template>

<script>
    export default {
        name: "TheSideBar"
    }
</script>

<style scoped>

</style>
