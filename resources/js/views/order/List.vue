<template>
    <div class="col-md-12">
        <div class="card" style="min-height: 720px">
            <div class="card-header">
                <h5 style="font-size: 35px">Products</h5>
                <router-link
                    to="/admin/product/create"
                    class="btn btn-outline-primary float-right">
                    Add New
                </router-link>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive text-center">
                    <div class="row ">

                        <div class="col-md-4">
                            <div id="report-table_filter" class="dataTables_filter"><label>Code:
                                <input type="search"
                                       class="form-control form-control-sm"
                                       placeholder=""
                                       v-model="search.code"
                                       v-on:keyup="getAll"
                                       aria-controls="report-table"></label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div  class="dataTables_filter"><label>Category:
                                <input type="search"
                                       class="form-control form-control-sm"
                                       placeholder=""
                                       v-model="search.category"
                                       v-on:keyup="getAll"
                                       aria-controls="report-table"></label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div  class="dataTables_filter"><label>Tag:
                                <input type="search"
                                       class="form-control form-control-sm"
                                       placeholder=""
                                       v-model="search.tag"
                                       v-on:keyup="getAll"
                                       aria-controls="report-table"></label>
                            </div>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>User Name</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Payment Type</th>
                            <th>Coupon</th>
                            <th>subtotal</th>
                            <th>Coupon Price</th>
                            <th>Shipping Price</th>
                            <th>Grand Total</th>
                            <th>Notes</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item,index) in items">
                            <td>{{ item.id }}</td>
                            <td>{{ item.code }}</td>
                            <td>{{ item.user.name }}</td>
                            <td>{{ item.address.address }}</td>
                            <td v-if="item.order_status">{{ item.order_status.name }}</td>
                            <td>{{ item.payment_type.name }}</td>
                            <td >{{ item.coupon ? item.coupon.code : ''}}</td>
                            <td>{{ item.subtotal}}</td>
                            <td>{{ item.coupon_price}}</td>
                            <td>{{ item.shipping_price}}</td>
                            <td>{{ item.grand_total}}</td>
                            <td>{{ item.notes}}</td>
                            <td>
                                <router-link
                                    :to="{path:'/admin/order/edit/' +item.id,params: { id: item.id }}"
                                    class="btn btn-outline-warning"
                                >Edit
                                </router-link>
                                <button type="button"
                                        @click="deleteItem(item.id,index)"
                                        class="btn btn-outline-danger">Delete
                                </button>
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
                    first-text="First"
                    prev-text="Previous"
                    next-text="Next"
                    last-text="Last"
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
                    tag: null,
                    category: null
                },
                show: false,
                colors: "#194d33",
                item: {
                    id: null,
                    code: '',
                    coupon_price: 0,
                    shipping_price: 0,
                    payment_type: null,
                    coupon: null,
                    user: null,
                    subtotal: '',
                    grand_total: '',
                    notes: '',
                    items: [
                        {
                            id: null,
                            variant: null,
                            offer: null,
                            quantity: 0,
                            item_price: 0,
                            total_item_price: 0,
                        },
                    ]
                },
                newItem: {
                    id: null,
                    code: '',
                    coupon_price: 0,
                    shipping_price: 0,
                    paymentType: '',
                    coupon: '',
                    subtotal: '',
                    grand_total: '',
                    notes: '',
                    items: [
                        {
                            id: null,
                            variant: null,
                            offer: null,
                            quantity: 0,
                            item_price: 0,
                            total_item_price: 0,
                        },
                    ]
                }
            }
        },
        created() {
            this.show = true;
            this.getAll();
        },
        methods: {
            getAll() {
                axios.get('/order', {
                    params: {
                        page: this.currentPage,
                        code: this.search.code,
                        tag: this.search.tag,
                        category: this.search.category,
                        is_paginate: 1,
                        sendResponse: 1
                    }
                }).then(response => {
                    this.items = response.data.data.data;
                    this.currentPage = response.data.data.current_page
                    this.perPage = response.data.data.per_page
                    this.rows = response.data.data.total
                })
                    .catch(err => console.log(err));
            },
            deleteItem(id, index) {
                swal({
                    title: "Are you sure ?",
                    text: "you will not be able to revert deleted items.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true
                }).then(willDelete => {
                    if (willDelete) {
                        axios
                            .delete("order/delete?id=" + id)
                            .then(res => {
                                this.items.splice(index, 1);
                                swal("Deleted Successfully", {
                                    icon: "success"
                                });
                            })
                            .catch(error => console.log(error));
                    } else {
                        swal("Items are not deleted, please check again!");
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>
