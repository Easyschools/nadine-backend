<template>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h5>تفاصيل الطلب</h5>
        </div>
        <div class="card-body">
          <div class="row form-group">
            <div class="col-sm-3">
              <label class="col-form-label">الكود</label>
            </div>
            <div class="col-sm-9">
              <div class="form-control">{{item.code}}</div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-3">
              <label class="col-form-label">المستخدم</label>
            </div>
            <div class="col-sm-9">
              <div class="form-control">{{item.user.name}}</div>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-sm-3">
              <label class="col-form-label">رقم التلفون</label>
            </div>
            <div class="col-sm-9">
              <div class="form-control">{{item.user.phone}}</div>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-sm-3">
              <label class="col-form-label">العنوان</label>
            </div>

            <div class="col-sm-9">
              <div class="form-control">{{getCurrentAddress()}} - {{getCurrentCity()}}</div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-3">
              <label class="col-form-label">حالة الطلب</label>
            </div>
            <div class="col-sm-9">
              <div class="form-control">{{getCurrentStatus()}}</div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-3">
              <label class="col-form-label">كوبون</label>
            </div>
            <div class="col-sm-9">
              <div class="form-control">{{getCurrentCoupon()}}</div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-3">
              <label class="col-form-label">كوبون</label>
            </div>
            <div class="col-sm-9">
              <div class="form-control">{{getCurrentCoupon()}}</div>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-sm-3">
              <label class="col-form-label">نوع الدفع</label>
            </div>
            <div class="col-sm-9">
              <div class="form-control">{{getCurrentPaymentType()}}</div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-3">
              <label class="col-form-label">القيمة الكلية</label>
            </div>
            <div class="col-sm-9">
              <div class="form-control">{{item.subtotal}}</div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-3">
              <label class="col-form-label">سعر الكوبون</label>
            </div>
            <div class="col-sm-9">
              <div class="form-control">{{item.coupon_price}}</div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-3">
              <label class="col-form-label">تكلفة التوصيل</label>
            </div>
            <div class="col-sm-9">
              <div class="form-control">{{item.shipping_price}}</div>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-sm-3">
              <label class="col-form-label">المبلغ المدفوع</label>
            </div>
            <div class="col-sm-9">
              <div class="form-control">{{item.grand_total}}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <h1 class="card-header" v-if="item.order_items.length > 0">المنتجات</h1>
      <div class="card" v-for="(item, index) in item.order_items" :key="index">
        <div class="form-group row">
          <div class="col-sm-3">
            <label class="col-form-label">رابط المنتج</label>
          </div>
          <div class="col-sm-9">
            <div class="form-control">
              <a
                :href="`https://www.unitart.net/product/${item.variant.product.slug}`"
                target="_blank"
                rel="noopener noreferrer"
              >https://www.unitart.net/product/{{item.variant.product.slug}}</a>
            </div>
          </div>
        </div>

        <div class="form-group row">
          <div class="col-sm-3">
            <label class="col-form-label">اسم المنتج</label>
          </div>
          <div class="col-sm-9">
            <div
              class="form-control"
            >{{item.variant.product.name_en}} - {{item.variant.product.name_ar}}</div>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-3">
            <label class="col-form-label">صورة المنتج</label>
          </div>
          <div class="col-sm-9">
            <img :src="item.variant.image" alt class="img-thumbnail" width="200px" height="200px" />
          </div>
        </div>

        <div class="form-group row">
          <div class="col-sm-3">
            <label class="col-form-label">الكميه</label>
          </div>
          <div class="col-sm-9">
            <div class="form-control">{{item.quantity}}</div>
          </div>
        </div>

        <div class="form-group row">
          <div class="col-sm-3">
            <label class="col-form-label">السعر قبل الخصم</label>
          </div>
          <div class="col-sm-9">
            <div class="form-control">{{item.variant.product.price}}</div>
          </div>
        </div>

        <div class="form-group row">
          <div class="col-sm-3">
            <label class="col-form-label">اجمالى السعر</label>
          </div>
          <div class="col-sm-9">
            <div class="form-control">{{item.total_item_price}}</div>
          </div>
        </div>
      </div>
      <div class="text-center">
        <router-link to="/admin/order" class="btn btn-secondary">الغاء</router-link>
        <router-link :to="`/admin/order/edit/${item.id}`" class="btn btn-primary">تعديل</router-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user_id: null,
      addresses: [],
      orderStatuses: [],
      coupons: [],
      paymentTypes: [],
      item: {
        id: null,
        code: "",
        coupon_price: 0,
        address_id: null,
        shipping_price: 0,
        payment_type: null,
        coupon: null,
        user_id: 0,
        subtotal: "",
        grand_total: "",
        order_status: null,
        notes: "",
        user: {
          id: null,
          name: null,
        },
        order_items: [
          {
            id: null,
            order_item: null,
            offer: null,
            quantity: 0,
            item_price: 0,
            variant: {
              product_id: null,
              product: {
                tag_id: null,
                category_id: null,
                id: null,
                name_ar: null,
                name_en: null,
              },
            },
            variant_id: null,
            offer_id: null,
            total_item_price: 0,
          },
        ],
      },
    };
  },

  created() {
    this.item.id = this.$route.params.id;
    this.getItem();
    this.getOrderStatus();
    this.getCoupon();
    this.getPaymentType();
  },
  methods: {
    getPaymentType() {
      axios
        .get("payment-type/all")
        .then((response) => {
          this.paymentTypes = response.data.data;
        })
        .catch((err) => console.log(err));
    },
    async getItem() {
      try {
        const response = await axios.get(
          "/order/order-details?order_id=" + this.item.id
        );
        this.item = response.data.data;
        this.user_id = this.item.user_id;
        this.getAddress();
      } catch (err) {
        this.errorMessages(err.response.data);
        console.log(err);
      }
    },
    getCurrentAddress() {
      const addresss = this.addresses.find(
        (item) => item.id === this.item.address_id
      );
      return addresss?.address;
    },

    getCurrentCity() {
      const addresss = this.addresses.find(
        (item) => item.id === this.item.address_id
      );
      return (
        addresss?.district?.name_ar + " - " + addresss?.district?.city?.name_ar
      );
    },

    getAddress() {
      axios
        .get("customer/get?id=" + this.user_id, {
          params: {
            is_paginate: 1,
            sendResponse: 1,
          },
        })
        .then((response) => {
          this.addresses = response.data.data.addresses;
        })
        .catch((err) => console.log(err));
    },
    getCoupon() {
      axios
        .get("coupon/all")
        .then((response) => {
          this.coupons = response.data.data;
        })
        .catch((err) => console.log(err));
    },

    getOrderStatus() {
      axios
        .get("order-status/all")
        .then((response) => {
          this.orderStatuses = response.data.data;
        })
        .catch((err) => console.log(err));
    },
    getCurrentStatus() {
      const status = this.orderStatuses.find(
        (item) => item.id === this.item.order_status_id
      );
      return status?.name_ar + " - " + status?.name_en;
    },
    getCurrentCoupon() {
      const coupon = this.coupons.find(
        (item) => item.id === this.item.coupon_id
      );

      return coupon?.code ?? "لا يوجد";
    },

    getCurrentPaymentType() {
      const active = this.paymentTypes.find(
        (item) => item.id === this.item.payment_type_id
      );
      return active ? active.name_ar + " - " + active.name_en : "لا يوجد";
    },
  },
};
</script>
