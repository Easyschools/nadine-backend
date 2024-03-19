<template>
  <div class="col-md-12">
    <div class="card" style="min-height: 720px">
      <div class="card-header">
        <h5 style="font-size: 35px">{{translations.offer.offer}}</h5>
        <router-link to="/admin/offer/create" class="btn btn-outline-primary float-right">{{translations.general.add}}</router-link>
      </div>
      <div class="card-body table-border-style">
        <div class="table-responsive text-center">
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>{{translations.general.nameAr}}</th>
                <th>{{translations.general.nameEn}}</th>

                <th>{{translations.offer.percentage}}</th>
                <th>{{translations.offer.discount}}</th>
                <th>{{translations.offer.expireDate}}</th>
                <th>{{translations.category.categories}}</th>
                <th>{{translations.general.options}}</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item,index) in items" :key="index">
                <td>{{item.id}}</td>
                <td>{{item.name_ar}}</td>
                <td>{{item.name_en}}</td>
                <td>{{item.is_percentage}}</td>
                <td>{{item.discount}}</td>
                <td>{{solveDate(item.expire_at)}}</td>
                <td>{{item.category.name_ar}} - {{item.category.name_en}}</td>

                <td>
                  <router-link
                    :to="{path:'/admin/offer/edit/' +item.id,params: { id: item.id }}"
                    class="btn btn-outline-warning"
                  >{{translations.general.edit}}</router-link>
                  <button
                    type="button"
                    @click="deleteItem(item.id,index)"
                    class="btn btn-outline-danger"
                  >{{translations.general.delete}}</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="offset-3 col-md-6">
        <b-pagination
          v-if="show"
          v-model="currentPage"
          @input="getAll"
          :total-rows="rows"
          :per-page="perPage"
                     :first-text="translations.general.first"
          :prev-text="translations.general.previous"
          :next-text="translations.general.next"
          :last-text="translations.general.last"
        ></b-pagination>
      </div>
    </div>
  </div>
</template>

<script>
import moment from "moment";
export default {
  name: "List",
  data() {
    return {
      perPage: 3,
      currentPage: 1,
      rows: 15,
      items: [],
      show: false,
      item: {
        id: null,
        name_ar: "",
        name_en: "",
        discount: "",
        expire_at: "",
        is_percentage: "",
        category: "",
        image: null,
      },
      newItem: {
        name_ar: "",
        name_en: "",
        discount: "",
        expire_at: "",
        is_percentage: "",
        category: "",
        image: null,
      },
    };
  },
  created() {
    this.show = true;
    this.getAll();
  },
  methods: {
    solveDate(date) {
      return moment(date).format("ll");
    },
    getAll() {
      axios
        .get("/offer/all", {
          params: { page: this.currentPage, is_paginate: 1 },
        })
        .then((response) => {
          this.items = response.data.data.data;
          this.currentPage = response.data.data.current_page;
          this.perPage = response.data.data.per_page;
          this.rows = response.data.data.total;
        })
        .catch((err) => console.log(err));
    },
    deleteItem(id, index) {
      swal({
        title: "Are you sure ?",
        text: "you will not be able to revert deleted items.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
          axios
            .delete("offer/delete?id=" + id)
            .then((res) => {
              this.items.splice(index, 1);
              swal("Deleted Successfully", {
                icon: "success",
              });
            })
            .catch((error) => console.log(error));
        } else {
          swal("Items are not deleted, please check again!");
        }
      });
    },
  },
};
</script>

<style scoped>
</style>
