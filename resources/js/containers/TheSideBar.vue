<template>
    <nav class="pcoded-navbar menu-light">
        <div class="navbar-wrapper">
            <div class="navbar-content scroll-div">
                <ul class="nav pcoded-inner-navbar ">
                    <li class="nav-item pcoded-menu-caption">
                        <label>Types</label>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/type">
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
                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/definition">
                            <span class="pcoded-micon">
                                <i class="feather icon-align-center"></i>
                            </span>
                            <span class="pcoded-mtext">التعريفات</span>
                        </router-link>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/preposition">
                            <span class="pcoded-micon">
                                <i class="feather icon-sliders"></i>
                            </span>
                            <span class="pcoded-mtext">الادوات العامله</span>
                        </router-link>
                    </li>
                    <li class="nav-item pcoded-menu-caption">
                        <label>المحتوى</label>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/lesson">
                            <span class="pcoded-micon">
                                <i class="fas fa-book-open"></i>
                            </span>
                            <span class="pcoded-mtext">الدروس</span>
                        </router-link>
                    </li>

                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/exercise">
                            <span class="pcoded-micon">
                                <i class="fas fa-file-excel"></i>
                            </span>
                            <span class="pcoded-mtext">التدريبات</span>
                        </router-link>
                    </li>

                    <li class="nav-item pcoded-menu-caption">
                        <label>المستخدمين</label>
                    </li>

                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/user">
                            <span class="pcoded-micon">
                                <i class="feather icon-users"></i>
                            </span>
                            <span class="pcoded-mtext">المستخدمين</span>
                        </router-link>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                        <router-link to="/admin/message">
                            <span class="pcoded-micon">
                                <i class="fas fa-mail-bulk"></i>
                            </span>
                            <span class="pcoded-mtext">الرسائل</span>
                        </router-link>
                    </li>
                    <!--<li class="nav-item pcoded-hasmenu">-->
                        <!--<router-link to="/admin/admin">-->
                            <!--<span class="pcoded-micon">-->
                                <!--<i class="fas fa-chalkboard-teacher"></i>-->
                            <!--</span>-->
                            <!--<span class="pcoded-mtext">Admins</span>-->
                        <!--</router-link>-->
                    <!--</li>-->
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
