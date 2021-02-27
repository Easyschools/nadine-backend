<template>
    <div class="col-md-12">
        <div class="card" style="min-height: 720px">
            <div class="card-header">
                <h5 style="font-size: 35px">Colors</h5>
                <button
                    type="button"
                    data-toggle="modal" data-target="#exampleModal"
                    data-backdrop="static" data-keyboard="false"
                    data-whatever="@getbootstrap"
                    class="btn btn-outline-primary float-right">
                    Add New
                </button>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive text-center">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name AR</th>
                            <th>Name EN</th>
                            <th>Color</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item,index) in items">
                            <td>{{ item.id }}</td>
                            <td>{{ item.name_ar }}</td>
                            <td>
                                {{ item.name_en }}
                            </td>
                            <td  class="DisplayColor" >
                                <div  class="myDisplayDiv" v-bind:style="{ backgroundColor: item.code}" >
<!--                                {{ item.color }}-->
                                    &nbsp;
                                </div>
                            </td>
                            <td>
                                <router-link
                                    :to="{path:'/admin/color/edit/' +item.id,params: { id: item.id }}"
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

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add New Color</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Name Ar:</label>
                                    <input type="text" v-model="newItem.name_ar" class="form-control"
                                           id="recipient-name">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Name EN:</label>
                                    <input type="text" v-model="newItem.name_en" class="form-control"
                                           id="recipient-name_ar">

                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Color:</label>
                                    <div class="col-md-4 text-center" style="margin-left: 100px">
                                        <chrome-picker v-if="show" :value="colors" v-model="colors"></chrome-picker>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">cancel</button>
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
                name_ar: '',
                name_en: '',
                code: ''
            },
            newItem: {
                name_ar: null,
                name_en: null,
                code: null
            }
        }
    },
    created() {
        this.show = true;
        this.getAll();
    },
    methods: {
        getAll() {
            axios.get('/color/all', {params: {page: this.currentPage, is_paginate: 1}}).then(response => {
                this.items = response.data.data.data;
                this.currentPage = response.data.data.current_page
                this.perPage = response.data.data.per_page
                this.rows = response.data.data.total
            })
                .catch(err => console.log(err));
        },
        createItem() {
            let color = this.colors.hex;
            this.newItem.code = color;
            axios.post('/color/create', this.newItem).then(response => {
                console.log(response.data.data);
                this.newItem = {name_ar: null, name_en: null, code: null};
                this.getAll();
                // this.items.unshift(this.newItem);
                $('#exampleModal').modal('hide');
                swal("Good job!", "A new Color has been added!", "success");
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
                        .delete("color/delete?id=" + id)
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

.DisplayColor{
    width: 50px;

}

.myDisplayDiv{
    content: "";
}
</style>
