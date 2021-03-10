<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>اضافة جديد Customer</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row form-group">


                            <div class="col-md-12">

                                <div class="row form-group">

                                    <div class="col-sm-12 pb-3 text-center" v-if="item.image">
                                        <img :src="item.image" ref="imageDisplay"
                                             class="mr-auto imageDisplay"/>
                                    </div>

                                    <div class="col-sm-3">
                                        <label style="font-weight: bold;"
                                               class="col-form-label ">الصورة</label>
                                    </div>

                                    <div class="col-md-9">
                                        <input type="file" ref="myImage"
                                               @change="uploadCustomerImage(index)">
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">الاسم</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" v-model="item.name">
                            </div>
                        </div>


                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">البريد الالكترونى</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" v-model="item.email">
                            </div>
                        </div>


                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">محظور</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" v-model="item.is_ban">
                            </div>
                        </div>

                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label class="col-form-label">التليفون</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" v-model="item.phone">
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>


        <div class="col-sm-12">
            <div class="col-md-12 text-right">
                <button class="btn btn-secondary mb-3" type="button" @click="addAddress()">
                    اضافة جديد عنوان للمستخدم
                </button>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 col-sm-12">
                            <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                <li v-for="(address,index) in item.addresses">
                                    <a :class="(index)?'nav-link text-left':'nav-link text-left active'"
                                       id="v-pills-home-tab" data-toggle="pill"
                                       :href="'#address'+index" role="tab"
                                       aria-controls="v-pills-home" aria-selected="true">
                                        عنوان {{ index }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-10 col-sm-12">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div v-for="(address,index) in item.addresses"
                                     :class="(index==0)?'tab-pane fade active show':'tab-pane fade'"
                                     :id="'address'+index" role="tabpanel"
                                     aria-labelledby="v-pills-home-tab">
                                    <div>
                                        <div class="row mb-4">
                                            <strong class="col-md-5 text-capitalize"
                                                    style="font-size: 18px">
                                                عنوان {{ index }}
                                            </strong>

                                            <button type="button"
                                                    class="float-right btn btn-icon btn-outline-danger"
                                                    v-if="index!=0||item.addresses.length>1"
                                                    @click="item.addresses.splice(index,1)"
                                            >
                                                <i class="feather icon-x"></i>
                                            </button>

                                        </div>


                                        <div class="row ">

                                            <div class="col-md-3 mt-4 mb-3">
                                                <label style="font-weight: bold;">City</label>
                                            </div>

                                            <div class="col-md-9 mt-3">
                                                <select class="form-control" v-model="address.city_id">
                                                    <option v-for="city in cities" :value="city.id">
                                                        {{ city.name_ar }} -
                                                        {{ city.name_en }}
                                                    </option>
                                                </select>
                                            </div>


                                            <div class="col-md-3 mt-4 mb-3">
                                                <label style="font-weight: bold;">Address</label>
                                            </div>
                                            <div class="col-md-9 mt-3">

                                                <input type="text" v-model="address.address"
                                                       class="form-control ">
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
                    الغاء
                </router-link>
                <button type="button" @click="createItem" class="btn btn-primary">
                    اضافة
                </button>
            </div>
        </div>


    </div>

</template>

<script>
    import alertsMixin from "../../mixins/alertsMixin";

    export default {
        name: "Create",
        data() {
            return {
                disableButton: false,

                show: false,
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
                            city_id: null,
                        },
                    ]
                },
                cities: [{
                    id: null,
                    name_en: null,
                    name_ar: null
                }],

            };
        },
        created() {
            this.getCity();

        },
        methods: {
            getCity() {
                axios.get('city/all')
                    .then(response => {
                        this.cities = response.data.data
                    })
                    .catch(err => console.log(err))
            },
            createItem() {

                this.disableButton = true;
                let data = this.getFormData();
                axios.post('/customer/create', data)
                    .then(response => {
                        this.$router.push('/admin/customer');
                        swal("Good job!", "A new customer has been added!", "success");
                    }).catch(err => {
                    this.errorMessages(err.response.data);
                    console.log(err)
                });
            },
            addAddress() {
                this.item.addresses.push({
                    id: null,
                    address: null,
                    city_id: null,
                })
            },
            selectCategory: function (e) {
                this.getTag(e.target.value);
                // console.log(e.target.value);
            },
            uploadCustomerImage(index) {
                this.item.image = this.$refs['myImage'].files[0];

                let reader = new FileReader();
                reader.addEventListener('load', function () {
                    this.$refs['imageDisplay'].src = reader.result;
                }.bind(this), false);

                reader.readAsDataURL(this.item.image);

            },
            getFormData() {
                let formData = new FormData();
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

</style>
