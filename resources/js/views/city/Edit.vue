<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Edit City</h5>
                </div>
                <div class="card-body">
                    <form>

                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">Name AR</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" v-model="item.name_ar">
                            </div>
                        </div>

                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">Name En</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" v-model="item.name_en">
                                <!--<select class="form-control" v-model="item.name_en">-->
                                <!--<option v-for="type in types" :value="type.id">{{type.name}}</option>-->
                                <!--</select>-->
                            </div>
                        </div>



                    </form>
                </div>
            </div>
        </div>


        <!--        //here-->


        <div class="col-sm-12">
            <div class="col-md-12 text-right">
                <button class="btn btn-secondary mb-3" type="button" @click="addDistrict()">
                    Add New City District
                </button>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 col-sm-12">
                            <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                <li v-for="(district,index) in item.districts">
                                    <a :class="(index)?'nav-link text-left':'nav-link text-left active'"
                                       id="v-pills-home-tab" data-toggle="pill"
                                       :href="'#district'+index" role="tab"
                                       aria-controls="v-pills-home" aria-selected="true">
                                        District {{ index }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-10 col-sm-12">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div v-for="(district,index) in item.districts"
                                     :class="(index==0)?'tab-pane fade active show':'tab-pane fade'"
                                     :id="'district'+index" role="tabpanel"
                                     aria-labelledby="v-pills-home-tab">
                                    <div>
                                        <div class="row mb-4">
                                            <strong class="col-md-5 text-capitalize"
                                                    style="font-size: 18px">
                                                District {{ index }}
                                            </strong>

                                            <button type="button"
                                                    class="float-right btn btn-icon btn-outline-danger"
                                                    v-if="index!=0||item.districts.length>1"
                                                    @click="item.districts.splice(index,1)"
                                            >
                                                <i class="feather icon-x"></i>
                                            </button>

                                        </div>
                                        <div class="row ">


                                            <div class="col-md-3 mt-4 mb-3">
                                                <label style="font-weight: bold;">Name AR</label>
                                            </div>
                                            <div class="col-md-9 mt-3">
                                                <input type="text" v-model="district.name_ar"
                                                       class="form-control">
                                            </div>


                                            <div class="col-md-3 mt-4 mb-3">
                                                <label style="font-weight: bold;">Name EN</label>
                                            </div>
                                            <div class="col-md-9 mt-3">
                                                <input type="text" v-model="district.name_en"
                                                       class="form-control">
                                            </div>


                                        </div>


                                    </div>


                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <router-link to="/admin/lesson" class="btn btn-secondary">
                    Cancel
                </router-link>
                <button type="button" @click="editItem" class="btn btn-primary">
                    Add
                </button>
            </div>
        </div>

    </div>
</template>


<script>
import {VueEditor} from "vue2-editor";

export default {
    name: "Edit",
    components: {
        VueEditor
    },
    data() {
        return {
            disableButton: false,
            item: {
                name_ar: '',
                name_en: '',
                districts: [
                    {
                        name_ar: null,
                        name_en: null,
                    }
                ]
            },
        };
    },
    created() {
        this.item.id = this.$route.params.id;
        this.getItem();

    },
    methods: {
        getItem() {
            axios.get('/city/get?id=' + this.item.id)
                .then(response => {
                    this.item = response.data.data;
                }).catch(err => {
                this.errorMessages(err.response.data);
                console.log(err);
            });
        },
        editItem() {
            this.disableButton = true;
            let formData = new FormData();
            // formData.append('id', this.item.id);
            let data = this.getFormData(formData);
            axios.post('/city/edit/', data).then(response => {
                this.disableButton = false;
                this.$router.push('/admin/city');
                swal("Good job!", "A new city has been updated!", "success");
            }).catch(err => {
                this.disableButton = false;
                this.errorMessages(err.response.data);
                console.log(err)
            });
        },
        addDistrict() {
            this.item.districts.push({
                id: null,
                name_ar: null,
                name_en: null,
            })
        },
        getFormData(formData) {
            this.buildFormData(formData, this.item, null);
            return formData;
        },
        buildFormData(formData, data, parentKey) {
            if (data && typeof data === 'object' && !(data instanceof Date) && !(data instanceof File) && !(data instanceof Blob)) {
                Object.keys(data).forEach(key => {
                    this.buildFormData(formData, data[key], parentKey ? `${parentKey}[${key}]` : key);
                });
            } else {
                let value = data == null ? '' : data;
                if (typeof (value) === 'string' && parentKey.search('content') > 0) {
                    return;
                }
                if (typeof (data) === 'boolean' && data === false) {
                    value = '0'
                }
                if (typeof (data) === 'boolean' && data === true) {
                    value = '1'
                }
                formData.append(parentKey, value);
            }
        }
    }
}
</script>

<style scoped>
li {
    transition: width 1s;
    width: 100px;
    margin-right: -30px;
}

li:hover {
    width: 120px;
}

li a:hover {
    background: aliceblue;

}
</style>
