<template>
    <div class="col-md-12">
        <div class="card" style="min-height: 720px">
            <div class="card-header">
                <h5 style="font-size: 35px">الرسائل</h5>

            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive text-center">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>الاسم الأول</th>
                            <th>الاسم الأخير</th>
                            <th>الهاتف</th>
                            <th>البريد الإلكتروني</th>
                            <th>الرسالة</th>
                            <th>مقروءة</th>
                            <th>الخيارات</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item,index) in items">
                            <td>{{item.id}}</td>
                            <td>{{item.first_name}}</td>
                            <td>{{item.last_name}}</td>
                            <td>{{item.phone}}</td>
                            <td>{{item.email}}</td>
                            <td>
                                {{ substringMessage(item.message)}}
                            </td>
                            <td>{{item.is_read ? 'نعم' : 'لا'}}</td>
                            <td>
                                <button
                                    @click="showMessage(item.message , item.id)"
                                    class="btn btn-outline-success"
                                >عرض
                                </button>
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
            }
        },
        created() {
            this.show = true;
            this.getAll();
        },
        methods: {
            getAll() {
                axios.get('/contact/all', {params: {page: this.currentPage, is_paginate: 1}}).then(response => {
                    this.items = response.data.data.data;
                    this.currentPage = response.data.data.current_page
                    this.perPage = response.data.data.per_page
                    this.rows = response.data.data.total
                })
                    .catch(err => console.log(err));
            },
            showMessage(message, id = null) {
                if (id) {
                    axios.get('/contact/get', {
                        params: {
                            id: id
                        }
                    }).then(response => {
                        swal(message);
                    })
                        .catch(err => console.log(err));
                }
                swal(message);
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
                            .delete("contact/delete?id=" + id)
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
            },
            substringMessage(message) {
                return message.length > 30 ? message.substring(0, 30) + '....' : message;
            }
        }
    }
</script>

<style scoped>

</style>
