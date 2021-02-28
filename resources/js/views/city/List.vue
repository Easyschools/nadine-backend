<template>
    <div class="col-md-12">
        <div class="card" style="min-height: 720px">
            <div class="card-header">
                <h5 style="font-size: 35px">Cities</h5>
                <router-link
                    to="/admin/city/create"
                    class="btn btn-outline-primary float-right">
                    Add New
                </router-link>
            </div>
            <div class="card-body table-border-style">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="dataTables_length" id="report-table_length"><label>Show <select
                            name="report-table_length" aria-controls="report-table"
                            class="custom-select custom-select-sm form-control form-control-sm">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select> entries</label></div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div id="report-table_filter" class="dataTables_filter"><label>Search:
                            <input type="search"
                                     class="form-control form-control-sm"
                                   placeholder=""
                                   aria-controls="report-table"></label>
                        </div>
                    </div>
                </div>
                <div class="table-responsive text-center">
                    <table id="report-table" class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name AR</th>
                            <th>Name EN</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item,index) in items">
                            <td>{{ item.id }}</td>
                            <td>{{ item.name_ar }}</td>
                            <td>{{ item.name_en }}</td>

                            <td>
                                <router-link
                                    :to="{path:'/admin/city/edit/' +item.id,params: { id: item.id }}"
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

    // $('#report-table').DataTable();


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
                },
                newItem: {
                    name_ar: '',
                    name_en: '',
                }
            }
        },
        created() {
            this.show = true;
            this.getAll();
        },
        methods: {
            getAll() {
                axios.get('/city/all', {params: {page: this.currentPage, is_paginate: 1}}).then(response => {
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
                            .delete("city/delete?id=" + id)
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
