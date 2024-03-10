<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{translations.general.edit}} {{translations.contact.contact}}</h5>
                </div>
                <div class="card-body">
                    <form>

                        <div class="row form-group" v-for="(phone,key) in item.phone" :key="key">

                            <div class="col-sm-3">
                                <label class="col-form-label">{{translations.contact.phone}}  {{key+1}}</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" v-model="item.phone[key]">
                            </div>
                        </div>

                        <div class="row form-group" v-for="(email,key) in item.email" :key="key">

                            <div class="col-sm-3">
                                <label class="col-form-label">{{translations.contact.email}}</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" v-model="item.email[key]">
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>


        <!--        //here-->


        <div class="col-sm-12">
            <div class="col-md-12 text-right">
                <button class="btn btn-secondary mb-3" type="button" @click="addAddress()">
                    {{translations.general.add}} {{translations.contact.newAddress}}
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
                                        {{translations.contact.address}} {{ index }}
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
                                                {{translations.contact.address}} {{ index }}
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
                                                <label style="font-weight: bold;">{{translations.contact.address}}</label>
                                            </div>
                                            <div class="col-md-9 mt-3">
                                                <input type="text" class="form-control" v-model="address.address"/>
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
                <router-link to="/admin/information" class="btn btn-secondary">
                    {{translations.general.delete}}
                </router-link>
                <button type="button" @click="editItem" class="btn btn-primary">
                    {{translations.general.add}}
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
                    id: null,
                    phone: [],
                    email: [],
                    addresses: [
                        {
                            address: null,
                            longitude: 1,
                            latitude: 0,
                        },
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
                axios.get('/contact-info/get')
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

                let data = this.getFormData(formData);
                axios.post('contact-info/update', data).then(response => {
                    this.disableButton = false;
                    // this.$router.push('/admin/information');
                    swal("Good job!", "A new contact-info has been updated!", "success");
                    this.getItem();
                    window.scrollTo(0,0);
                }).catch(err => {
                    this.disableButton = false;
                    this.errorMessages(err.response.data);
                    console.log(err)
                });
            },
            addAddress() {
                this.item.addresses.push({
                    address: null,
                    longitude: 1,
                    latitude: 0,
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
