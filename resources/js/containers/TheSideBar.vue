<template>
    <nav class="pcoded-navbar menu-light">
        <div class="navbar-wrapper">
            <div class="navbar-content scroll-div">
                <ul class="nav pcoded-inner-navbar ">

                    <li class="nav-item pcoded-menu-caption">
                        <label>Regions</label>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/city">
                            <span class="pcoded-micon">
                                <i class="fas fa-list-ol"></i>
                            </span>
                            <span class="pcoded-mtext">Cities</span>
                        </router-link>
                    </li>

                    <li class="nav-item pcoded-menu-caption">
                        <label>Sliders</label>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/slider">
                            <span class="pcoded-micon">
                                <i class="fas fa-list-ol"></i>
                            </span>
                            <span class="pcoded-mtext">Sliders</span>
                        </router-link>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/information">
                            <span class="pcoded-micon">
                                <i class="fas fa-list-ol"></i>
                            </span>
                            <span class="pcoded-mtext">Contact Info</span>
                        </router-link>
                    </li>

                    <li class="nav-item pcoded-menu-caption">
                        <label>Types</label>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/category">
                            <span class="pcoded-micon">
                                <i class="fas fa-list-ol"></i>
                            </span>
                            <span class="pcoded-mtext">Categories</span>
                        </router-link>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/tag">
                            <span class="pcoded-micon">
                                <i class="feather icon-edit-1"></i>
                            </span>
                            <span class="pcoded-mtext">Tags</span>
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
                                <i class="feather icon-edit-1"></i>
                            </span>
                            <span class="pcoded-mtext">Materials</span>
                        </router-link>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/collection">
                            <span class="pcoded-micon">
                                <i class="feather icon-edit-1"></i>
                            </span>
                            <span class="pcoded-mtext">Collections</span>
                        </router-link>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/dimension">
                            <span class="pcoded-micon">
                                <i class="feather icon-edit-1"></i>
                            </span>
                            <span class="pcoded-mtext">Dimensions</span>
                        </router-link>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/color">
                            <span class="pcoded-micon">
                                <i class="feather icon-edit-1"></i>
                            </span>
                            <span class="pcoded-mtext">Colors</span>
                        </router-link>
                    </li>

                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/brand">
                            <span class="pcoded-micon">
                                <i class="feather icon-edit-1"></i>
                            </span>
                            <span class="pcoded-mtext">Brands</span>
                        </router-link>
                    </li>


                    <li class="nav-item pcoded-menu-caption">
                        <label>Products</label>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/product">
                            <span class="pcoded-micon">
                                <i class="fas fa-book-open"></i>
                            </span>
                            <span class="pcoded-mtext">Products</span>
                        </router-link>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/favourite">
                            <span class="pcoded-micon">
                                <i class="fas fa-book-open"></i>
                            </span>
                            <span class="pcoded-mtext">Favourites</span>
                        </router-link>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/coupon">
                            <span class="pcoded-micon">
                                <i class="fas fa-book-open"></i>
                            </span>
                            <span class="pcoded-mtext">Coupons</span>
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
                        <label>Orders</label>
                    </li>

                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/offer">
                            <span class="pcoded-micon">
                                <i class="feather icon-users"></i>
                            </span>
                            <span class="pcoded-mtext">Offers</span>
                        </router-link>
                    </li>

                    <li class="nav-item pcoded-menu-caption">
                        <label>Users</label>
                    </li>

                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/customer">
                            <span class="pcoded-micon">
                                <i class="feather icon-users"></i>
                            </span>
                            <span class="pcoded-mtext">Customers</span>
                        </router-link>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/message">
                            <span class="pcoded-micon">
                                <i class="fas fa-mail-bulk"></i>
                            </span>
                            <span class="pcoded-mtext">Messages</span>
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
