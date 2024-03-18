<template>
  <nav id="lorem" class="pcoded-navbar menu-light">
    <div class="navbar-wrapper">
      <div class="navbar-content scroll-div">
        <button
          class="btn btn-outline-primary mt-2"
          id="closeSideBar"
          v-on:click="closeSideBar"
        >
          close
        </button>
        <ul class="nav pcoded-inner-navbar">
          <li class="nav-item pcoded-menu-caption">
            <label>{{translations.city.area}}</label>
          </li>
          <li class="nav-item pcoded-hasmenu">
            <router-link to="/admin/city">
              <span class="pcoded-micon">
                <i class="fas fa-city"></i>
              </span>
              <span class="pcoded-mtext">{{translations.sidebar.city}}</span>
            </router-link>
          </li>

          <li class="nav-item pcoded-menu-caption">
            <label>{{translations.sidebar.slider}}</label>
          </li>
          <li class="nav-item pcoded-hasmenu">
            <router-link to="/admin/slider">
              <span class="pcoded-micon">
                <i class="fas fa-images"></i>
              </span>
              <span class="pcoded-mtext">{{translations.sidebar.slider}}</span>
            </router-link>
          </li>
          <li class="nav-item pcoded-hasmenu">
            <router-link to="/admin/celebrity">
              <span class="pcoded-micon">
                <i class="fas fa-images"></i>
              </span>
              <span class="pcoded-mtext">{{translations.sidebar.celebrities}}</span>
            </router-link>
          </li>
          <li class="nav-item pcoded-hasmenu">
            <router-link to="/admin/pressMedia">
              <span class="pcoded-micon">
                <i class="fas fa-images"></i>
              </span>
              <span class="pcoded-mtext">{{translations.sidebar.journalisticMedia}}</span>
            </router-link>
          </li>

          <li class="nav-item pcoded-hasmenu">
            <router-link to="/admin/information">
              <span class="pcoded-micon">
                <i class="fas fa-id-card"></i>
              </span>
              <span class="pcoded-mtext">{{translations.sidebar.contact}}</span>
            </router-link>
          </li>

          <li class="nav-item pcoded-menu-caption">
            <label>{{translations.sidebar.categories}}</label>
          </li>
          <li class="nav-item pcoded-hasmenu">
            <router-link to="/admin/category">
              <span class="pcoded-micon">
                <i class="fas fa-th-large"></i>
              </span>
              <span class="pcoded-mtext">{{translations.sidebar.categories}}</span>
            </router-link>
          </li>
          <li class="nav-item pcoded-hasmenu">
            <router-link to="/admin/tag">
              <span class="pcoded-micon">
                <i class="fas fa-tags"></i>
              </span>
              <span class="pcoded-mtext">{{translations.sidebar.tags}}</span>
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
              <span class="pcoded-mtext">{{translations.sidebar.material}}</span>
            </router-link>
          </li>
          <li class="nav-item pcoded-hasmenu">
            <router-link to="/admin/collection">
              <span class="pcoded-micon">
                <i class="fas fa-clone"></i>
              </span>
              <span class="pcoded-mtext">{{translations.sidebar.collection}}</span>
            </router-link>
          </li>
          <li class="nav-item pcoded-hasmenu">
            <router-link to="/admin/dimension">
              <span class="pcoded-micon">
                <i class="feather icon-edit-1"></i>
              </span>
              <span class="pcoded-mtext">{{translations.sidebar.sizes}}</span>
            </router-link>
          </li>
          <li class="nav-item pcoded-hasmenu">
            <router-link to="/admin/color">
              <span class="pcoded-micon">
                <i class="fas fa-palette"></i>
              </span>
              <span class="pcoded-mtext">{{translations.sidebar.colors}}</span>
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
            <label>{{translations.sidebar.products}}</label>
          </li>
          <li class="nav-item pcoded-hasmenu">
            <router-link to="/admin/product">
              <span class="pcoded-micon">
                <i class="fas fa-couch"></i>
              </span>
              <span class="pcoded-mtext">{{translations.sidebar.products}}</span>
            </router-link>
          </li>
          <li class="nav-item pcoded-hasmenu">
            <router-link to="/admin/favourite">
              <span class="pcoded-micon">
                <i class="fas fa-star"></i>
              </span>
              <span class="pcoded-mtext">{{translations.sidebar.favourite}}</span>
            </router-link>
          </li>
          <li class="nav-item pcoded-hasmenu">
            <router-link to="/admin/coupon">
              <span class="pcoded-micon">
                <i class="fas fa-book-open"></i>
              </span>
              <span class="pcoded-mtext">{{translations.sidebar.coupon}}</span>
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
            <label>{{translations.sidebar.orders}}</label>
          </li>

          <li class="nav-item pcoded-hasmenu">
            <router-link to="/admin/offer">
              <span class="pcoded-micon">
                <i class="fas fa-percentage"></i>
              </span>
              <span class="pcoded-mtext">{{translations.sidebar.offers}}</span>
            </router-link>
          </li>

          <li class="nav-item pcoded-hasmenu">
            <router-link to="/admin/status">
              <span class="pcoded-micon">
                <i class="fas fa-battery-quarter"></i>
              </span>
              <span class="pcoded-mtext">{{translations.sidebar.status}}</span>
            </router-link>
          </li>

          <li class="nav-item pcoded-hasmenu">
            <router-link to="/admin/order">
              <span class="pcoded-micon">
                <i class="feather icon-shopping-cart"></i>
              </span>
              <span class="pcoded-mtext">{{translations.sidebar.orders}}</span>
            </router-link>
          </li>

          <li class="nav-item pcoded-menu-caption">
            <label>{{translations.sidebar.users}}</label>
          </li>

          <li class="nav-item pcoded-hasmenu">
            <router-link to="/admin/customer">
              <span class="pcoded-micon">
                <i class="feather icon-users"></i>
              </span>
              <span class="pcoded-mtext">{{translations.sidebar.users}}</span>
            </router-link>
          </li>
          <li class="nav-item pcoded-hasmenu">
            <router-link to="/admin/message">
              <span class="pcoded-micon">
                <i class="fas fa-mail-bulk"></i>
              </span>
              <span class="pcoded-mtext">{{translations.sidebar.message}}</span>
              <span
                v-if="cnt"
                class="unread"
                style="
                  background-color: red;
                  color: white;
                  padding: 7px;
                  margin-right: 5px;
                  border-radius: 50%;
                "
                >{{ cnt }}</span
              >
            </router-link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
import { mapActions } from "vuex";

export default {
  name: "TheSideBar",
  data() {
    return {
      cnt: 0,
    };
  },
  created() {
    this.getUnreadMessages();
  },
  methods: {
    ...mapActions({
      collapseNavBar: "auth/collapseNavBar",
      closeSideBar: "auth/closeSideBar",
    }),
    getUnreadMessages() {
      axios
        .get("contact/get-count-unread")
        .then((response) => {
          this.cnt = response.data.data;
        })
        .catch();
    },
  },
};
</script>

<style scoped></style>
