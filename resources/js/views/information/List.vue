<template>
    <div class="col-md-12">
        <div class="card" style="min-height: 720px">

            <div class="card-body table-border-style">
                <div class="table-responsive text-center">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>phone</th>
                            <th>email</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{ item.id }}</td>

                            <td>
                                <ul>
                                    <li v-for="(phone , key) in item.phone" :key="key">
                                        {{ phone }}
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    <li v-for="(email , key) in item.email" :key="key">
                                        {{ email }}
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <router-link
                                    :to="{path:'/admin/Information/edit/' +item.id,params: { id: item.id }}"
                                    class="btn btn-outline-warning"
                                >Edit
                                </router-link>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="offset-3 col-md-6">
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
                    phone: [],
                    email: [],
                    variants: [
                        {
                            id: null,
                            image: null,
                            stock: 1,
                            additional_price: 0,
                            color_id: null,
                            dimension_id: null,
                        },
                    ]
                },
                newItem: {
                    id: null,
                    phone: [],
                    email: [],
                    variants: [
                        {
                            id: null,
                            image: null,
                            stock: 1,
                            additional_price: 0,
                            color_id: null,
                            dimension_id: null,
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
                axios.get('/contact-info/get', {
                    params: {
                        page: this.currentPage,
                        is_paginate: 1,
                    }
                }).then(response => {
                    this.item = response.data.data;
                    // this.currentPage = response.data.data.current_page
                    // this.perPage = response.data.data.per_page
                    // this.rows = response.data.data.total
                })
                    .catch(err => console.log(err));
            },
        }
    }
</script>

<style scoped>

</style>
