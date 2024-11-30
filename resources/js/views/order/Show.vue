<template>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h5>{{translations.general.show}} {{translations.order.orders}}</h5>
        </div>
        <div class="card-body">
          <div class="row form-group">
            <div class="col-sm-3">
              <label class="col-form-label">{{translations.order.code}}</label>
            </div>
            <div class="col-sm-9">
              <div class="form-control">{{item.code}}</div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-3">
              <label class="col-form-label">{{translations.order.user}}</label>
            </div>
            <div class="col-sm-9">
              <div class="form-control">{{item.user.name}}</div>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-sm-3">
              <label class="col-form-label">{{translations.order.phone}}</label>
            </div>
            <div class="col-sm-9">
              <div class="form-control">{{item.user.phone}}</div>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-sm-3">
              <label class="col-form-label">{{translations.order.address}}</label>
            </div>

            <div class="col-sm-9">
              <div class="form-control">{{getCurrentAddress()}} - {{getCurrentCity()}}</div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-3">
              <label class="col-form-label">{{translations.order.status}}</label>
            </div>
            <div class="col-sm-9">
              <div class="form-control">{{getCurrentStatus()}}</div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-3">
              <label class="col-form-label">{{translations.order.copoun}}</label>
            </div>
            <div class="col-sm-9">
              <div class="form-control">{{getCurrentCoupon()}}</div>
            </div>
          </div>
          <!-- <div class="row form-group">
            <div class="col-sm-3">
              <label class="col-form-label">كوبون</label>
            </div>
            <div class="col-sm-9">
              <div class="form-control">{{getCurrentCoupon()}}</div>
            </div>
          </div> -->

          <div class="row form-group">
            <div class="col-sm-3">
              <label class="col-form-label">{{translations.order.typeOfPayment}}</label>
            </div>
            <div class="col-sm-9">
              <div class="form-control">{{getCurrentPaymentType()}}</div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-3">
              <label class="col-form-label">{{translations.order.TheAmountPaid}}</label>
            </div>
            <div class="col-sm-9">
              <div class="form-control">{{item.subtotal}}</div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-3">
              <label class="col-form-label">{{translations.order.couponPrice}}</label>
            </div>
            <div class="col-sm-9">
              <div class="form-control">{{item.coupon_price}}</div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-3">
              <label class="col-form-label">{{translations.order.deliveryCost}}</label>
            </div>
            <div class="col-sm-9">
              <div class="form-control">{{item.shipping_price}}</div>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-sm-3">
              <label class="col-form-label">{{translations.order.theAmountPaid}}</label>
            </div>
            <div class="col-sm-9">
              <div class="form-control">{{item.grand_total}}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <h1 class="card-header" v-if="item.order_items.length > 0">{{translations.order.orders}}</h1>
      <div class="card" v-for="(item, index) in item.order_items" :key="index">
        <div class="form-group row">
          <div class="col-sm-3">
            <label class="col-form-label"> {{translations.product.product}} {{translations.journalisticMedia.link}}</label>
          </div>
          <div class="col-sm-9">
            <div class="form-control">
              <a
                :href="`https://nadinesherifjewellery.com/product/${item.variant.product.id}`"
                target="_blank"
                rel="noopener noreferrer"
              >https://nadinesherifjewellery.com/product/{{item.variant.product.id}}</a>
            </div>
          </div>
        </div>

        <div class="form-group row">
          <div class="col-sm-3">
            <label class="col-form-label">{{translations.product.product}} {{translations.general.name}} </label>
          </div>
          <div class="col-sm-9">
            <div
              class="form-control"
            >{{item.variant.product.name_en}} - {{item.variant.product.name_ar}}</div>
          </div>
        </div>

<div class="form-group row">
  <div class="col-sm-3">
    <label class="col-form-label">Color </label>
  </div>
  <div class="col-sm-9">
    <div class="form-control">
      {{ (item.color && item.color.name_en) ? item.color.name_en : 'No color available' }}
    </div>
  </div>
</div>



        <div class="form-group row">
          <div class="col-sm-3">
            <label class="col-form-label">material </label>
          </div>
          <div class="col-sm-9">
            <div
              class="form-control"
            >{{ (item.material && item.material.name_en) ? item.material.name_en : 'No material available' }}</div>
          </div>
        </div>
        
        <div class="form-group row">
          <div class="col-sm-3">
            <label class="col-form-label">dimension </label>
          </div>
          <div class="col-sm-9">
            <div
              class="form-control"
            >{{ item.dimension && item.dimension.dimension ? item.dimension.dimension : 'No dimension available' }}</div>
          </div>
        </div>

        <div class="form-group row">
          <div class="col-sm-3">
            <label class="col-form-label">{{translations.product.product}} {{translations.general.image}}</label>
          </div>
          <div class="col-sm-9">
            <img :src="item.variant.product.image" alt class="img-thumbnail" width="200px" height="200px" />
          </div>
        </div>

        <div class="form-group row">
          <div class="col-sm-3">
            <label class="col-form-label">{{translations.order.amount}}</label>
          </div>
          <div class="col-sm-9">
            <div class="form-control">{{item.quantity}}</div>
          </div>
        </div>

        <div class="form-group row">
          <div class="col-sm-3">
            <label class="col-form-label">{{translations.product.priceAfterDiscount}}</label>
          </div>
          <div class="col-sm-9">
            <div class="form-control">{{item.variant.product.price}}</div>
          </div>
        </div>

        <div class="form-group row">
          <div class="col-sm-3">
            <label class="col-form-label">{{translations.product.totalPrice}}</label>
          </div>
          <div class="col-sm-9">
            <div class="form-control">{{item.total_item_price}}</div>
          </div>
        </div>
      </div>
      <div class="text-center">
        <router-link to="/admin/order" class="btn btn-secondary">{{translations.general.cancel}}</router-link>
        <router-link :to="`/admin/order/edit/${item.id}`" class="btn btn-primary">{{translations.general.edit}}</router-link>
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
                image: null,
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
