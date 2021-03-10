<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>تعديل منتج</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">الكود</label>
                            </div>
                            <div class="col-sm-9">
                                <input disabled type="text" class="form-control" v-model="item.code">
                            </div>
                        </div>
                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">المستخدم</label>
                            </div>
                            <div class="col-sm-9">
                                <input disabled type="text" class="form-control" v-model="item.user.name">
                            </div>
                        </div>
                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">العنوان</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control" v-model="item.address_id">
                                    <option v-for="address in addresses" :value="address.id">{{address.address}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">حالة الطلب</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control" v-model="item.order_status_id">
                                    <option v-for="order_status in orderStatuses" :value="order_status.id">
                                        {{order_status.name}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">كوبون</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control" v-model="item.coupon_id">
                                    <option v-for="coupon in coupons" :value="coupon.id">
                                        {{coupon.code}}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">نوع الدفع</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control" v-model="item.payment_type_id">
                                    <option v-for="paymentType in paymentTypes" :value="paymentType.id">
                                        {{paymentType.name}}
                                    </option>
                                </select>
                            </div>
                        </div>


                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">القيمة الكلية</label>
                            </div>
                            <div class="col-sm-9">
                                <input disabled type="number" class="form-control" v-model="item.subtotal">

                            </div>
                        </div>
                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">سعر الكوبون</label>
                            </div>
                            <div class="col-sm-9">
                                <input disabled type="number" class="form-control" v-model="item.coupon_price">

                            </div>
                        </div>
                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">تكلفة التوصيل</label>
                            </div>
                            <div class="col-sm-9">
                                <input disabled type="number" class="form-control" v-model="item.shipping_price">

                            </div>
                        </div>
                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">المبلغ المدفوع</label>
                            </div>
                            <div class="col-sm-9">
                                <input disabled type="number" class="form-control" v-model="item.grand_total">

                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>


        <!--        //here-->


        <div class="col-sm-12">
            <div class="col-md-12 text-right">
                <button class="btn btn-secondary mb-3" type="button" @click="addOrderItem()">
                    اضافة جديد منتج القطع
                </button>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 col-sm-12">
                            <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                <li v-for="(order_item,index) in item.order_items">
                                    <a :class="(index)?'nav-link text-left':'nav-link text-left active'"
                                       id="v-pills-home-tab" data-toggle="pill"
                                       :href="'#order_item'+index" role="tab"
                                       aria-controls="v-pills-home" aria-selected="true">
                                        قطعة {{ index }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-10 col-sm-12">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div v-for="(order_item,index) in item.order_items"
                                     :class="(index==0)?'tab-pane fade active show':'tab-pane fade'"
                                     :id="'order_item'+index" role="tabpanel"
                                     aria-labelledby="v-pills-home-tab">
                                    <div>
                                        <div class="row mb-4">
                                            <strong class="col-md-5 text-capitalize"
                                                    style="font-size: 18px">
                                                قطعة {{ index }}
                                            </strong>

                                            <button type="button"
                                                    class="float-right btn btn-icon btn-outline-danger"
                                                    v-if="index!=0||item.order_items.length>1"
                                                    @click="item.order_items.splice(index,1)"
                                            >
                                                <i class="feather icon-x"></i>
                                            </button>

                                        </div>
                                        <div class="row ">

                                            <div class="col-md-12">

                                                <div class="row form-group">

                                                    <div class="col-sm-12 pb-3 text-center"
                                                         v-if="order_item.variant.image">
                                                        <img
                                                            :src="order_item.variant ? order_item.variant.image : null "
                                                            :ref="'imageDisplay_'+ index"
                                                            class="mr-auto imageDisplay"/>
                                                    </div>

                                                    <!--<div class="col-sm-3">-->
                                                    <!--<label style="font-weight: bold;"-->
                                                    <!--class="col-form-label ">Image</label>-->
                                                    <!--</div>-->

                                                    <!--<div class="col-md-9">-->
                                                    <!--<input type="file" :ref="'order_item'+index"-->
                                                    <!--@change="uploadOrderItemImage(index)">-->
                                                    <!--</div>-->

                                                </div>
                                            </div>


                                            <div class="col-md-3 mt-4 mb-3">
                                                <label style="font-weight: bold;">منتج</label>
                                            </div>
                                            <div class="col-md-9 mt-3">
                                                <select class="form-control" v-on:change="getVariants"
                                                        v-model="order_item.variant.product_id">
                                                    <option v-for="product in products" :value="product.id">
                                                        {{ product.name }}
                                                    </option>
                                                </select>
                                            </div>


                                            <div class="col-md-3 mt-4 mb-3">
                                                <label style="font-weight: bold;">نوع</label>
                                            </div>
                                            <div class="col-md-9 mt-3">
                                                <select class="form-control" @change="uploadOrderItemImage(index)"
                                                        v-model="order_item.variant_id">
                                                    <option
                                                        v-for="variant in ( (variants[0].id ) ? variants : order_item.variant.product.variants)"
                                                        :value="variant.id">
                                                        {{ variant.color ? variant.color.name : ''}} -
                                                        {{ variant.dimension? variant.dimension.dimension : ''}}
                                                    </option>
                                                </select>
                                            </div>




                                            <div class="col-md-3 mt-4 mb-3">
                                                <label style="font-weight: bold;">الكمية</label>
                                            </div>
                                            <div class="col-md-9 mt-3">

                                                <input type="number" v-model="order_item.quantity"
                                                       class="form-control mob_no"
                                                       autocomplete="off" maxlength="2">
                                            </div>

                                            <div class="col-md-3 mt-4 mb-3">
                                                <label style="font-weight: bold;">سعر القطعة</label>
                                            </div>
                                            <div class="col-md-9 mt-3">

                                                <input disabled type="number" v-model="order_item.item_price"
                                                       class="form-control mob_no"
                                                       autocomplete="off" maxlength="2">
                                            </div>

                                            <div class="col-md-3 mt-4 mb-3">
                                                <label style="font-weight: bold;">السعر الكلي</label>
                                            </div>
                                            <div class="col-md-9 mt-3">

                                                <input disabled type="number" v-model="order_item.total_item_price"
                                                       class="form-control mob_no"
                                                       autocomplete="off" maxlength="2">
                                            </div>


                                        </div>


                                    </div>


                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <router-link to="/admin/order" class="btn btn-secondary">
                    الغاء
                </router-link>
                <button type="button" @click="editItem" class="btn btn-primary">
                    اضافة
                </button>
            </div>
        </div>

    </div>
</template>


<script>

    export default {
        name: "Edit",
        components: {},
        data() {
            return {
                disableButton: false,
                item: {
                    id: null,
                    code: '',
                    coupon_price: 0,
                    address_id: null,
                    shipping_price: 0,
                    payment_type: null,
                    coupon: null,
                    user_id: null,
                    subtotal: '',
                    grand_total: '',
                    order_status: null,
                    notes: '',
                    user: {
                        id: null,
                        name: null
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
                                    id: null,
                                    name_ar: null,
                                    name_en: null,
                                }
                            },
                            variant_id: null,
                            offer_id: null,
                            total_item_price: 0,
                        },
                    ]
                },
                paymentTypes: [{
                    id: null,
                    name_en: '',
                    name_ar: ''
                }],
                products: [{
                    id: null,
                    name_en: null,
                    name_ar: null,
                    name: null,
                    variants: []
                }],
                orderStatuses: [{
                    id: null,
                    name_en: null,
                    name_ar: null,
                }],
                coupons: [{
                    id: null,
                    name_en: null,
                    name_ar: null,
                }],
                offers: [{
                    id: null,
                    name_en: null,
                    name_ar: null,
                }],
                addresses: [{
                    id: null,
                    address: null,
                }],
                variants: [{
                    id: 0,
                    color: {
                        name: 'test'
                    },
                    dimension: {
                        dimension: 'dimension test'
                    },
                    image: null,
                }],

            };
        },
        created() {
            this.item.id = this.$route.params.id;
            this.getItem();
            this.getPaymentType();
            this.getOrderStatus();
            this.getCoupon();
            this.getAddress();
            this.getOffer();
            this.getProduct();

        },
        watch: {
            '$route.params': 'getItem()',
        },
        methods: {
            getPaymentType() {
                axios.get('payment-type/all')
                    .then(response => {
                        this.paymentTypes = response.data.data

                    })
                    .catch(err => console.log(err))
            },
            getVariants(e) {
                axios.get('product/get', {
                    params: {
                        sendResponse: 1,
                        id: e.target.value
                    }
                }).then(response => {
                    this.variants = response.data.data.variants;
                })
                    .catch(err => console.log(err))
            },
            getProduct() {
                axios.get('product/all', {
                    params: {
                        sendResponse: 1
                    }
                }).then(response => {
                    this.products = response.data.data;
                })
                    .catch(err => console.log(err))
            },
            getAddress() {
                axios.get('customer/get?id=' + 7, {
                    params: {
                        id: this.item.user_id,
                        page: this.currentPage,
                        // code: this.search.code,
                        // tag: this.search.tag,
                        // category: this.search.category,
                        is_paginate: 1,
                        sendResponse: 1
                    }
                }).then(response => {
                    this.addresses = response.data.data.addresses

                })
                    .catch(err => console.log(err))
            },
            getOrderStatus() {
                axios.get('order-status/all')
                    .then(response => {
                        this.orderStatuses = response.data.data
                    })
                    .catch(err => console.log(err))
            },
            getCoupon() {
                axios.get('coupon/all')
                    .then(response => {
                        this.coupons = response.data.data
                    })
                    .catch(err => console.log(err))
            },
            getOffer() {
                axios.get('offer/all')
                    .then(response => {
                        this.offers = response.data.data
                    })
                    .catch(err => console.log(err))
            },
            getItem() {
                axios.get('/order/order-details?order_id=' + this.item.id)
                    .then(response => {
                        this.item = response.data.data;
                        // this.variants = this.item.variant.product.variants;
                        // this.variants = this.item.order_items.variant.product.variants;

                        console.log(this.variants);
                    }).catch(err => {
                    this.errorMessages(err.response.data);
                    console.log(err);
                });
            },
            editItem() {
                this.disableButton = true;
                let formData = new FormData();
                // formData.append('id', this.item.id);
                let data = this.getFormData(formData);
                axios.post('/order/update/', data).then(response => {
                    this.disableButton = false;
                    swal("Good job!", "A new order has been updated!", "success");
                    window.scrollTo(0, 0);
                    this.getItem()
                }).catch(err => {
                    this.disableButton = false;
                    this.errorMessages(err.response.data);
                    console.log(err)
                });
            },
            addOrderItem() {
                this.item.order_items.push({
                    id: null,
                    order_item: null,
                    offer: null,
                    quantity: 0,
                    item_price: 0,
                    variant: {
                        product_id: null,
                        product: {
                            id: null,
                            name_ar: null,
                            name_en: null,
                        }
                    },
                    variant_id: null,
                    offer_id: null,
                    total_item_price: 0,
                })
            },
            getFormData(formData) {
                this.buildFormData(formData, this.item, null);
                return formData;
            },
            uploadOrderItemImage(index) {
                this.item.order_items[index].image = this.$refs['order_item' + index][0].files[0];

                let reader = new FileReader();
                reader.addEventListener('load', function () {
                    this.$refs['imageDisplay_' + index][0].src = reader.result;
                }.bind(this), false);

                reader.readAsDataURL(this.item.order_items[index].image);

            },
            buildFormData(formData, data, parentKey) {
                if (data && typeof data === 'object' && !(data instanceof Date) && !(data instanceof File) && !(data instanceof Blob)) {
                    Object.keys(data).forEach(key => {
                        this.buildFormData(formData, data[key], parentKey ? `${parentKey}[${key}]` : key);
                    });
                } else {
                    let value = data == null ? '' : data;
                    if (typeof (value) === 'string' && parentKey.search('content') > 0) {
                        return;
                    }
                    if (typeof (data) === 'boolean' && data === false) {
                        value = '0'
                    }
                    if (typeof (data) === 'boolean' && data === true) {
                        value = '1'
                    }
                    formData.append(parentKey, value);
                }
            }
        }
    }
</script>

<style scoped>
    li {
        transition: width 1s;
        width: 100px;
        margin-right: -30px;
    }

    li:hover {
        width: 120px;
    }

    li a:hover {
        background: aliceblue;

    }
</style>
