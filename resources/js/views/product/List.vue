<template>
  <div class="col-md-12">
    <div class="card" style="min-height: 720px">
      <div class="card-header">
        <h5 style="font-size: 35px">{{translations.product.product}}</h5>
        <router-link
          to="/admin/product/create"
          class="btn btn-outline-primary float-right"
        >{{translations.general.add}}</router-link>
      </div>
      <div class="card-body table-border-style">
        <div class="table-responsive text-center">
          <div class="row">
            <div class="col-md-4">
              <div id="report-2" class="dataTables_filter">
                <label>
                  {{translations.product.number}}:
                  <input
                    type="search"
                    class="form-control form-control-sm"
                    placeholder
                    v-model="search.id"
                    v-on:keyup="getAll"
                    aria-controls="report-table"
                  />
                </label>
              </div>
            </div>
            <div class="col-md-4">
              <div id="report-table_filter" class="dataTables_filter">
                <label>
                  {{translations.general.name}}:
                  <input
                    type="search"
                    class="form-control form-control-sm"
                    placeholder
                    v-model="search.name"
                    v-on:keyup="getAll"
                    aria-controls="report-table"
                  />
                </label>
              </div>
            </div>
            <div class="col-md-4">
              <div id class="dataTables_filter">
                <label>
                  {{translations.category.categories}}:
                  <input
                    type="search"
                    class="form-control form-control-sm"
                    placeholder
                    v-model="search.category"
                    v-on:keyup="getAll"
                    aria-controls="report-table"
                  />
                </label>
              </div>
            </div>
            <div class="col-md-4">
              <div id class="dataTables_filter">
                <label>
                  {{translations.product.type}}:
                  <input
                    type="search"
                    class="form-control form-control-sm"
                    placeholder
                    v-model="search.tag"
                    v-on:keyup="getAll"
                    aria-controls="report-table"
                  />
                </label>
              </div>
            </div>
          </div>
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>{{translations.product.sku}}</th>
                <th>{{translations.general.nameAr}}</th>
                <th>{{translations.general.nameEn}}</th>
                <th>{{translations.product.type}}</th>
                <th>{{translations.category.categories}}</th>
                <th>{{translations.product.price}}</th>
                <th>{{translations.general.image}}</th>
                <th>{{translations.general.options}}</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item,index) in items" :key="index">
                <td>{{ item.id }}</td>
                <td>{{ item.sku }}</td>
                <td>{{ item.name_ar }}</td>
                <td>{{ item.name_en }}</td>
                <td>{{ item.tag ? item.tag.name : '' }}</td>
                <td>{{ item.category ? item.category.name : '' }}</td>
                <td>{{ item.price }}</td>
                <td>
                  <img v-if="item.image" :src="item.image" class="imageDisplay" alt="no Image" />
                  <img
                    v-else
                    src="../../../images/no_image.jpg"
                    class="imageDisplay"
                    alt="no Image"
                  />
                </td>
                <td>
                  <router-link
                    :to="{path:'/admin/product/edit/' +item.slug +'/'+currentPage,params: {
                                     slug: item.slug,
                                     page: currentPage,
                                     }}"
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
      <!--            {{// this.currentPage}}-->
      <div class="offset-3 col-md-6">
        <b-pagination
          v-if="show"
          v-model="currentPage"
          @input="getAll"
          :total-rows="rows"
          :per-page="perPage"
          first-text="الاولى"
          prev-text="السابق"
          next-text="التالى"
          last-text="الاخير"
        ></b-pagination>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "List",
  data() {
    return {
      perPage: 1,
      currentPage: 1,
      rows: 15,
      items: [],
      search: {
        name: null,
        tag: null,
        category: null,
        id: null,
      },
      show: false,
      item: {
        id: null,
        name_ar: "",
        name_en: "",
        tag: "",
        category: "",
        sku: "",
        price: "",
        image: null,
        variants: [
          {
            id: null,
            image: null,
            stock: 1,
            additional_price: 0,
            color_id: null,
            dimension_id: null,
          },
        ],
      },
      newItem: {
        name_ar: "",
        name_en: "",
        tag: "",
        category: "",
        slug: "",
        price: "",
        variants: [
          {
            id: null,
            image: null,
            stock: 1,
            additional_price: 0,
            color_id: null,
            dimension_id: null,
          },
        ],
      },
    };
  },
  created() {
    this.show = true;
    this.currentPage = this.$route.query.page;
    this.getAll();
  },
  methods: {
    getAll() {
      axios
        .get("product/all", {
          params: {
            page: this.currentPage,
            name: this.search.name,
            tag: this.search.tag,
            category: this.search.category,
            id: this.search.id,
            is_paginate: 1,
            sendResponse: 1,
          },
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
            .delete("product/delete?id=" + id)
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
