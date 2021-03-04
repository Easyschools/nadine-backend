<template>
    <div class="col-md-12">
        <div class="card" style="min-height: 720px">
            <div class="card-header">
                <h5 style="font-size: 35px">Offers</h5>
                <router-link
                    to="/admin/offer/create"
                    class="btn btn-outline-primary float-right">
                    Add New
                </router-link>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive text-center">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name AR</th>
                            <th>Name En</th>
                            <th>Image</th>
                            <th>Is Percentage</th>
                            <th>Discount</th>
                            <th>expire_at</th>
                            <th>Category</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item,index) in items">
                            <td>{{item.id}}</td>
                            <td>{{item.name_ar}}</td>
                            <td>{{item.name_en}}</td>
                            <td>
                                <img :src="item.image" class=" imageDisplay"/>
                            </td>
                            <td>{{item.is_percentage}}</td>
                            <td>{{item.discount}}</td>
                            <td>{{item.expire_at}}</td>
                            <td>{{item.category.name_ar}} - {{item.category.name_en}}</td>

                            <td>
                                <router-link
                                    :to="{path:'/admin/offer/edit/' +item.id,params: { id: item.id }}"
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
                show: false,
                item: {
                    id: null,
                    name_ar: '',
                    name_en: '',
                    discount: '',
                    expire_at: '',
                    is_percentage: '',
                    category: '',
                    image: null
                },
                newItem: {
                    name_ar: '',
                    name_en: '',
                    discount: '',
                    expire_at: '',
                    is_percentage: '',
                    category: '',
                    image: null
                }
            }
        },
        created() {
            this.show = true;
            this.getAll();
        },
        methods: {

            getAll() {
                axios.get('/offer/all', {params: {page: this.currentPage, is_paginate: 1}}).then(response => {
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
                            .delete("offer/delete?id=" + id)
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
