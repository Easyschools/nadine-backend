<template>
    <div class="col-md-12">
        <div class="card" style="min-height: 720px">
            <div class="card-header">
                <h5 style="font-size: 35px">التدريبات</h5>
                <router-link
                    to="/admin/exercise/create"
                    class="btn btn-outline-primary float-right">
                    اضف جديدا
                </router-link>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive text-center">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>الدرس الخاص به</th>
                            <th>الخيارات</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item,index) in items">
                            <td>{{item.id}}</td>
                            <td>{{item.name}}</td>
                            <td>{{(item.lesson)?item.lesson.name:'-'}}</td>
                            <td>
                                <router-link
                                    :to="{path:'/admin/exercise/edit/' +item.id,params: { id: item.id }}"
                                    class="btn btn-outline-warning"
                                >تعديل
                                </router-link>
                                <button type="button"
                                        @click="deleteItem(item.id,index)"
                                        class="btn btn-outline-danger">حذف
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
                show: false,
                colors: "#194d33",
                item: {
                    id: null,
                    name: '',
                    color: '',
                    lesson: {
                        name: ''
                    }
                },
                newItem: {
                    name: null,
                    color: null
                }
            }
        },
        created() {
            this.show = true;
            this.getAll();
        },
        methods: {
            getAll() {
                axios.get('/exercises', {params: {page: this.currentPage, is_paginate: 1}}).then(response => {
                    this.items = response.data.data.data;
                    this.currentPage = response.data.data.current_page;
                    this.perPage = response.data.data.per_page;
                    this.rows = response.data.data.total;
                })
                    .catch(err => console.log(err));
            },
            deleteItem(id, index) {
                swal({
                    title: "هل انت متاكد ؟",
                    text:
                        "بمجرد الحذف لا يمكنك استرجاعه مره اخره, تاكيد؟",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true
                }).then(willDelete => {
                    if (willDelete) {
                        axios
                            .delete("exercises/" + id)
                            .then(res => {
                                this.items.splice(index, 1);
                                swal("تم الحذف بنجاح", {
                                    icon: "success"
                                });
                            })
                            .catch(error => console.log(error));
                    } else {
                        swal("لم يتم الحذف يرجى التاكد من البيانات!");
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>
