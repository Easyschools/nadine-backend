<template>
  <div class="col-md-12">
    <div class="card" style="min-height: 720px">
      <div class="card-header">
        <h5 style="font-size: 35px">طلبات</h5>
        <!--<router-link-->
        <!--to="/admin/product/create"-->
        <!--class="btn btn-outline-primary float-right">-->
        <!--اضافة جديد-->
        <!--</router-link>-->
      </div>
      <div class="card-body table-border-style">
        <div class="table-responsive text-center">
          <div class="row">
            <div class="col-md-4">
              <div id="report-table_filter" class="dataTables_filter">
                <label>
                  الكود:
                  <input
                    type="search"
                    class="form-control form-control-sm"
                    placeholder
                    v-model="search.code"
                    v-on:keyup="getAll"
                    aria-controls="report-table"
                  />
                </label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="dataTables_filter">
                <label>
                  التليفون:
                  <input
                    type="search"
                    class="form-control form-control-sm"
                    placeholder
                    v-model="search.phone"
                    v-on:keyup="getAll"
                    aria-controls="report-table"
                  />
                </label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="dataTables_filter">
                <label>
                  الاسم:
                  <input
                    type="search"
                    class="form-control form-control-sm"
                    placeholder
                    v-model="search.username"
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
                <th>الكود</th>
                <th>المستخدم</th>
                <th>التليفون</th>
                <th>العنوان</th>
                <th>الحالة</th>
                <th>نوع الدفع</th>
                <th>كوبون</th>
                <th>القيمة الكلية</th>
                <th>سعر الكوبون</th>
                <th>تكلفة التوصيل</th>
                <th>المبلغ المدفوع</th>
                <th>ملاحظات</th>
                <th>الخيارات</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in items" :key="index">
                <td>{{ item.id }}</td>
                <td>{{ item.code }}</td>
                <td>{{ item.user.name }}</td>
                <td>{{ item.user.phone }}</td>
                <td>{{ item.address.address }}</td>
                <td>{{ item.order_status ? item.order_status.name : "" }}</td>
                <td>{{ item.payment_type.name }}</td>
                <td>{{ item.coupon ? item.coupon.code : "" }}</td>
                <td>{{ item.subtotal }}</td>
                <td>{{ item.coupon_price }}</td>
                <td>{{ item.shipping_price }}</td>
                <td>{{ item.grand_total }}</td>
                <td>{{ item.notes }}</td>
                <td>
                  <router-link
                    :to="{
                      path: '/admin/order/show/' + item.id,
                      params: { id: item.id },
                    }"
                    class="btn btn-outline-primary"
                  >التفاصيل</router-link>
                  <router-link
                    :to="{
                      path: '/admin/order/edit/' + item.id,
                      params: { id: item.id },
                    }"
                    class="btn btn-outline-warning"
                  >تعديل</router-link>
                  <button
                    type="button"
                    @click="deleteItem(item.id, index)"
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
export default {
  name: "List",
  data() {
    return {
      perPage: 3,
      currentPage: 1,
      rows: 15,
      items: [],
      search: {
        code: null,
        phone: null,
        category: null,
      },
      show: false,
      colors: "#194d33",
      item: {
        id: null,
        code: "",
        coupon_price: 0,
        shipping_price: 0,
        payment_type: null,
        coupon: null,
        user: null,
        subtotal: "",
        grand_total: "",
        notes: "",
        items: [
          {
            id: null,
            variant: null,
            offer: null,
            quantity: 0,
            item_price: 0,
            total_item_price: 0,
          },
        ],
      },
      newItem: {
        id: null,
        code: "",
        coupon_price: 0,
        shipping_price: 0,
        paymentType: "",
        coupon: "",
        subtotal: "",
        grand_total: "",
        notes: "",
        items: [
          {
            id: null,
            variant: null,
            offer: null,
            quantity: 0,
            item_price: 0,
            total_item_price: 0,
          },
        ],
      },
    };
  },
  created() {
    this.show = true;
    this.getAll();
  },
  methods: {
    getAll() {
      axios
        .get("/order", {
          params: {
            page: this.currentPage,
            code: this.search.code,
            phone: this.search.phone,
            username: this.search.username,
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
            .delete("order/delete?order_id=" + id)
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
