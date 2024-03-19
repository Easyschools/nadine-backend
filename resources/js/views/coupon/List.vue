<template>
    <div class="col-md-12">
        <div class="card" style="min-height: 720px">
            <div class="card-header">
                <h5 style="font-size: 35px">{{translations.copoun.copouns}}</h5>
                <router-link
                    to="/admin/coupon/create"
                    class="btn btn-outline-primary float-right">
                    {{translations.general.add}}
                </router-link>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive text-center">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{translations.copoun.code}}</th>
                            <th>{{translations.copoun.allUsers}}</th>
                            <th>{{translations.copoun.percentage}}</th>
                            <th>{{translations.copoun.value}}</th>
                            <th>{{translations.copoun.maximumNumberOfUsage}}</th>
                            <th>{{translations.copoun.numberOfTimesUsed}}</th>
                            <th>{{translations.copoun.orderValue}}</th>
                            <!--<th>min Total</th>-->
                            <th>{{translations.general.options}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item,index) in items">
                            <td>{{item.id}}</td>
                            <td>{{item.code}}</td>
                            <td>
                                <ul v-if="item.users_of_coupon.length != 0">
                                    <li v-for="(user,phone) in item.users_of_coupon">

                                        {{user}} - {{phone}}
                                    </li>
                                </ul>
                                <p v-else>{{translations.copoun.allUsers}}</p>
                            </td>
                            <td>{{item.is_percentage === 1 ? 'نعم' : 'لا'}}</td>
                            <td>{{item.value }}  {{item.is_percentage === 1 ? '%' : 'Pound '}}</td>
                            <td>{{item.max_usage}}</td>
                            <td>{{item.used_times}}</td>
                            <td>{{item.min_total}}</td>


                            <td>
                                <router-link
                                    :to="{path:'/admin/coupon/edit/' +item.id,params: { id: item.id }}"
                                    class="btn btn-outline-warning"
                                >{{translations.general.edit}}
                                </router-link>
                                <button type="button"
                                        @click="deleteItem(item.id,index)"
                                        class="btn btn-outline-danger">{{translations.general.delete}}
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="offset-3 col-md-6">
                <b-pagination
                    v-if="show" v-model="currentPage" @input="getAll" :total-rows="rows" :per-page="perPage"
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

    export default {
        name: "List",
        data() {
            return {
                perPage: 3,
                currentPage: 1,
                rows: 15,
                items: [],
                show: false,
                colors: "#194d33",
                item: {
                    id: null,
                    code: '',
                    users: {},
                    is_percentage: '',
                    max_usage: '',
                    used_times: '',
                    min_total: '',
                    users_of_coupon: []
                },
                newItem: {
                    id: null,
                    code: '',
                    users: {},
                    is_percentage: '',
                    max_usage: '',
                    used_times: '',
                    min_total: '',
                }
            }
        },
        created() {
            this.show = true;
            this.getAll();
        },
        methods: {
            getAll() {
                axios.get('/coupon/all', {params: {page: this.currentPage, is_paginate: 1}}).then(response => {
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
                            .delete("coupon/delete?id=" + id)
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
