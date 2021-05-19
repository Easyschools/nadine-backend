<template>
    <div class="col-md-12">
        <div class="card" style="min-height: 720px">
            <div class="card-header">
                <h5 style="font-size: 35px">حالات الطلب </h5>
                <router-link
                    to="/admin/status/create"
                    class="btn btn-outline-primary float-right">
                    اضافة جديد
                </router-link>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive text-center">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>الاسم بالعربية</th>
                            <th>الاسم بالانجليزية</th>
                            <th>الحالات</th>
                            <th>الخيارات</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item,index) in items">
                            <td>{{item.id}}</td>
                            <td>{{item.name_ar}}</td>
                            <td>{{item.name_en}}</td>
                            <td v-if="item.type == 'active'">نشطة</td>
                            <td v-else-if="item.type == 'inactive'">غير نشطة</td>
                            <td v-else></td>
                            <td>
                                <router-link
                                    :to="{path:'/admin/status/edit/' +item.id,params: { id: item.id }}"
                                    class="btn btn-outline-warning"
                                >تعديل
                                </router-link>
                                <!--<button type="button"-->
                                        <!--@click="deleteItem(item.id,index)"-->
                                        <!--class="btn btn-outline-danger">حذف-->
                                <!--</button>-->
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="offset-3 col-md-6">
                <b-pagination
                    v-if="show" v-model="currentPage" @input="getAll" :total-rows="rows" :per-page="perPage"
                    first-text="الاولى" prev-text="السابق" next-text="التالى" last-text="الاخير"
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
                    name_ar: '',
                    name_en: '',
                    type: '',
                },
                newItem: {
                    name_ar: '',
                    name_en: '',
                    type: '',
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
                axios.get('/order-status/all', {params: {page: this.currentPage, is_paginate: 1}}).then(response => {
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
                            .delete("order-status/delete?id=" + id)
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
