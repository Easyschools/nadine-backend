<template>
  <div class="col-md-12">
    <div class="card" style="min-height: 720px">
      <div class="card-header">
        <h5 style="font-size: 35px">المدن</h5>
        <router-link to="/admin/city/create" class="btn btn-outline-primary float-right">اضافة جديد</router-link>
      </div>
      <div class="card-body table-border-style">
        <div class="table-responsive text-center">
          <div class="row">
            <div class="col-md-4">
              <div id="report-table_filter" class="dataTables_filter">
                <label>
                  الاسم:
                  <input
                    type="search"
                    class="form-control form-control-sm"
                    placeholder
                    v-model="name"
                    v-on:keyup="getAll"
                    aria-controls="report-table"
                  />
                </label>
              </div>
            </div>
          </div>
          <table id="report-table" class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>الاسم بالعربية</th>
                <th>الاسم بالانجليزية</th>
                <th>تكلفة الشحن</th>
                <th>الخيارات</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item,index) in items" :key="index">
                <td>{{ item.id }}</td>
                <td>{{ item.name_ar }}</td>
                <td>{{ item.name_en }}</td>
                <td>{{ item.shipping_cost }}</td>

                <td>
                  <router-link
                    :to="{path:'/admin/city/edit/' +item.id,params: { id: item.id }}"
                    class="btn btn-outline-warning"
                  >تعديل</router-link>
                  <button
                    type="button"
                    @click="deleteItem(item.id,index)"
                    class="btn btn-outline-danger"
                  >حذف</button>
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
// $('#report-table').DataTable();

export default {
  name: "List",
  data() {
    return {
      perPage: 3,
      currentPage: 1,
      name: "",
      rows: 15,
      items: [],
      show: false,
      item: {
        id: null,
        name_ar: "",
        name_en: "",
      },
      newItem: {
        name_ar: "",
        name_en: "",
      },
    };
  },
  created() {
    this.show = true;
    this.getAll();
  },
  methods: {
    getAll(entry = null) {
      console.log(entry);
      axios
        .get("/city/all?name=" + this.name, {
          params: {
            page: this.currentPage,
            is_paginate: 1,
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
            .delete("city/delete?id=" + id)
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
