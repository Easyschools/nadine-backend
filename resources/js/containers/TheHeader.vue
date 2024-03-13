<template>
  <header class="navbar pcoded-header navbar-expand-lg navbar-light header-blue">
    <div class="m-header">
      <a class="mobile-menu" v-on:click="collapseNavBar" id="mobile-collapse " href="#!"
        ><span></span
      ></a>
      <router-link to="/admin/home" class="b-brand" style="font-size: 40px">
        Nadine
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

            <div
               class="dropdown-menu dropdown-menu-right profile-notification"
              :style="{
                left: currentLanguage === 'en' ? '0 !important' : 'auto',
                position: currentLanguage === 'en' ? 'static !important' : 'static',
                right: currentLanguage === 'ar' ? '0 !important' : 'auto',
                minWidth: 'auto',
              }"
            >
              <ul class="pro-body" style="padding: 0">
                <!--                                <li><a href="user-profile.html" class="dropdown-item"><i class="feather icon-user"></i> Profile</a></li>-->
                <!--                                <li><a href="email_inbox.html" class="dropdown-item"><i class="feather icon-mail"></i> My Messages</a></li>-->
                <li style="margin: 10px">
                  <a href="#" v-on:click="submit()" class="dropdown-item">
                    <i class="feather icon-log-out"></i>

                    تسجيل الخروج
                  </a>
                </li>
                <li style="margin: 10px" v-if="currentLanguage === 'ar'">
                  <language-mixin
                    href="#"
                    @click="switchLanguage('en')"
                    class="dropdown-item"
                    >English</language-mixin
                  >
                </li>
                <li style="margin: 10px" v-else>
                  <language-mixin
                    href="#"
                    @click="switchLanguage('ar')"
                    class="dropdown-item"
                    >Arabic</language-mixin
                  >
                </li>
              </ul>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </header>
</template>

<script>
import { mapActions } from "vuex";
// console.log(mapActions)
export default {
  name: "TheHeader",
  data() {
    return {
      flag: 0,
    };
  },
  methods: {
    ...mapActions({
      logoutAction: "auth/logout",
      collapseNavBar: "auth/collapseNavBar",
    }),
    submit() {
      this.logoutAction().then(() => {
        this.$router.push("/admin/login");
      });
    },
  },
};
</script>
<style scoped></style>
