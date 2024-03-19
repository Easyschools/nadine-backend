<template>
    <div class="col-md-12">
        <div class="card" style="min-height: 720px">
            <div class="card-header">
                <h5 style="font-size: 35px">{{translations.user.users}}</h5>
                <!--<router-link-->
                <!--to="/admin/customer/create"-->
                <!--class="btn btn-outline-primary float-right">-->
                <!--اضافة جديد-->
                <!--</router-link>-->
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive text-center">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{translations.general.name}}</th>
                            <th>{{translations.user.email}}</th>
                            <th>{{translations.user.phone}}</th>
                            <th>{{translations.user.ban}}</th>
                            <th>{{translations.general.image}}</th>
                            <th>{{translations.general.options}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item,index) in items">
                            <td>{{ item.id }}</td>
                            <td>{{ item.name }}</td>
                            <td>{{ item.email }}</td>
                            <td>{{ item.phone }}</td>
                            <td>{{ item.is_ban }}</td>
                            <td>
                                <img :src="item.image" class=" imageDisplay"/>
                            </td>
                            <td>
                                <router-link
                                    :to="{path:'/admin/customer/edit/' +item.id,params: { id: item.id }}"
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
                    name: '',
                    email: '',
                    tag: '',
                    phone: '',
                    is_ban: '',
                    type: '',
                    image: null,
                    addresses: [
                        {
                            id: null,
                            address: null,
                            user_id: null,
                            city_id: null,
                        },
                    ]
                },
                newItem: {
                    id: '',
                    name: '',
                    email: '',
                    tag: '',
                    phone: '',
                    is_ban: '',
                    type: '',
                    image: '',
                    addresses: [
                        {
                            id: null,
                            address: null,
                            customer_id: null,
                            city_id: null,
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
                axios.get('/customer/all', {
                    params: {
                        page: this.currentPage,
                        is_paginate: 1,
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
                            .delete("customer/delete?id=" + id)
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
