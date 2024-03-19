<template>
    <div class="col-md-12">
        <div class="card" style="min-height: 720px">
            <div class="card-header">
                <h5 style="font-size: 35px">المقاس</h5>
                <button
                    type="button"
                    data-toggle="modal" data-target="#exampleModal"
                    data-backdrop="static" data-keyboard="false"
                    data-whatever="@getbootstrap"
                    class="btn btn-outline-primary float-right">
                    اضافة جديد
                </button>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive text-center">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>المقاس</th>
                            <th>الخيارات</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item,index) in items">
                            <td>{{item.id}}</td>
                            <td>{{item.dimension}}</td>
                            <td>
                                <router-link
                                    :to="{path:'/admin/dimension/edit/' +item.id,params: { id: item.id }}"
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
                    v-if="show" v-model="currentPage" @input="getAll" :total-rows="rows" :per-page="perPage"
                                       :first-text="translations.general.first"
          :prev-text="translations.general.previous"
          :next-text="translations.general.next"
          :last-text="translations.general.last"
                ></b-pagination>
            </div>

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">اضافة جديد المقاس</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">المقاس</label>
                                    <input type="text" v-model="newItem.dimension" class="form-control"
                                           id="recipient-name">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                            <button type="button" @click="createItem()" class="btn btn-primary">Add</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {Chrome} from 'vue-color'

    export default {
        name: "List",
        components: {
            'chrome-picker': Chrome,
        },
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
                    dimension: '',
                },
                newItem: {
                    dimension: null,
                }
            }
        },
        created() {
            this.show = true;
            this.getAll();
        },
        methods: {
            getAll() {
                axios.get('/dimension/all', {params: {page: this.currentPage, is_paginate: 1}}).then(response => {
                    this.items = response.data.data.data;
                    this.currentPage = response.data.data.current_page
                    this.perPage = response.data.data.per_page
                    this.rows = response.data.data.total
                })
                    .catch(err => console.log(err));
            },
            createItem() {
                // let color = this.colors.hex;
                // this.newItem.color = color;
                axios.post('/dimension/create', this.newItem).then(response => {
                    console.log(response.data.data);
                    this.newItem = {name_ar: null, name_en: null};
                    this.getAll();
                    // this.items.unshift(this.newItem);
                    $('#exampleModal').modal('hide');
                    swal("Good job!", "A new Dimension has been added!", "success");
                })
                    .catch(err => {
                        this.errorMessages(err.response.data);
                        console.log(err)
                    });
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
                            .delete("dimension/delete?id=" + id)
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
