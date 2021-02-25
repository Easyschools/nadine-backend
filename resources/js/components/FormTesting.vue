<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div v-for="(item,index) in items">
                        <label>product</label>
                        <select class="form-control" v-model="item.product_id"
                            @change="addItemsToProduct($event,index)"
                        >
                            <option v-for="product in products" :value="product.id">
                                {{product.name_en}}
                            </option>
                        </select>
                        <label>items</label>
                        <select class="form-control" v-model="item.item_id">
                            <option v-for="pitem in  item.product_items">
                                {{pitem.key_name}}
                            </option>
                        </select>
                        <button type="button" @click="items.push({product_id: null,item_id: null,product_items:[]})">
                            add
                        </button>

                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'FormTesting',
        data() {
            return {
                products: [
                    {
                        "id": 1,
                        "name_en": "chair",
                        "name_ar": "chair",
                        "image": "http://127.0.0.1:8000/uploads/product/DTZ8BkeFHNEPUc4xggAG0N3tzulSFRFHVoLyF6Rh.jpeg",
                        "category_id": 14,
                        "company_id": 4,
                        "created_at": "2020-09-17 10:49:45",
                        "updated_at": "2020-09-17 10:49:45",
                        "items": []
                    },
                    {
                        "id": 2,
                        "name_en": "test",
                        "name_ar": "test",
                        "image": "http://127.0.0.1:8000/uploads/product/4tnANqVrATAZKr0KrDRVX2KzZ3DG8uOZPxUkJhhm.jpeg",
                        "category_id": 13,
                        "company_id": 4,
                        "created_at": "2020-09-17 10:52:08",
                        "updated_at": "2020-09-17 10:52:08",
                        "items": []
                    },
                    {
                        "id": 3,
                        "name_en": "table",
                        "name_ar": "table",
                        "image": "http://127.0.0.1:8000/uploads/product/cosm4KTAPlY0vbyx2OAVzs2P41duWceRA6Na68iW.png",
                        "category_id": 14,
                        "company_id": 4,
                        "created_at": "2020-09-17 14:00:42",
                        "updated_at": "2020-09-17 14:00:42",
                        "items": []
                    },
                    {
                        "id": 4,
                        "name_en": "table",
                        "name_ar": "table",
                        "image": "http://127.0.0.1:8000/uploads/product/m3hUkBi9ojcJLWQSD0fPkEjkKvn2Ympeq1qJ2Pjd.png",
                        "category_id": 14,
                        "company_id": 4,
                        "created_at": "2020-09-17 14:01:09",
                        "updated_at": "2020-09-17 14:01:09",
                        "items": [
                            {
                                "id": 1,
                                "value": "50*120",
                                "key_id": 1,
                                "product_id": 4,
                                "created_at": "2020-09-17 14:01:09",
                                "updated_at": "2020-09-17 14:01:09",
                                "key_name": "size",
                                "key": {
                                    "id": 1,
                                    "name": "size",
                                    "created_at": null,
                                    "updated_at": null
                                }
                            }
                        ]
                    },
                    {
                        "id": 5,
                        "name_en": "test",
                        "name_ar": "test",
                        "image": "http://127.0.0.1:8000/uploads/product/cmZWocKSRdmhBqnWZCJKfYg6rnLkg7Yccbmh8pK7.jpeg",
                        "category_id": 15,
                        "company_id": 4,
                        "created_at": "2020-09-17 15:39:04",
                        "updated_at": "2020-09-17 15:39:04",
                        "items": [
                            {
                                "id": 2,
                                "value": "123",
                                "key_id": 1,
                                "product_id": 5,
                                "created_at": "2020-09-17 15:39:05",
                                "updated_at": "2020-09-17 15:39:05",
                                "key_name": "size",
                                "key": {
                                    "id": 1,
                                    "name": "size",
                                    "created_at": null,
                                    "updated_at": null
                                }
                            }
                        ]
                    },
                    {
                        "id": 6,
                        "name_en": "test",
                        "name_ar": "test",
                        "image": "http://127.0.0.1:8000/uploads/product/edIOtMtgmgpfxcgEcMXOb3oBG9VnxOXU3GcuiPU5.jpeg",
                        "category_id": 14,
                        "company_id": 4,
                        "created_at": "2020-09-17 15:40:50",
                        "updated_at": "2020-09-17 15:40:50",
                        "items": [
                            {
                                "id": 3,
                                "value": "123",
                                "key_id": 2,
                                "product_id": 6,
                                "created_at": "2020-09-17 15:40:50",
                                "updated_at": "2020-09-17 15:40:50",
                                "key_name": "price",
                                "key": {
                                    "id": 2,
                                    "name": "price",
                                    "created_at": null,
                                    "updated_at": null
                                }
                            }
                        ]
                    },
                    {
                        "id": 7,
                        "name_en": "chair",
                        "name_ar": "chair",
                        "image": "http://127.0.0.1:8000/uploads/product/s9jkxadAwmT38Up8QNVWtM4IR54qQx7dlPsJgSCI.jpeg",
                        "category_id": 15,
                        "company_id": 4,
                        "created_at": "2020-09-17 15:44:45",
                        "updated_at": "2020-09-17 15:44:45",
                        "items": [
                            {
                                "id": 4,
                                "value": "222",
                                "key_id": 2,
                                "product_id": 7,
                                "created_at": "2020-09-17 15:44:45",
                                "updated_at": "2020-09-17 15:44:45",
                                "key_name": "price",
                                "key": {
                                    "id": 2,
                                    "name": "price",
                                    "created_at": null,
                                    "updated_at": null
                                }
                            }
                        ]
                    },
                    {
                        "id": 8,
                        "name_en": "test",
                        "name_ar": "test",
                        "image": "http://127.0.0.1:8000/uploads/product/A4dQWufqMmjJy5NCtHs4wfuk558HpZSK0ipOdKnb.jpeg",
                        "category_id": 15,
                        "company_id": 4,
                        "created_at": "2020-09-17 15:50:25",
                        "updated_at": "2020-09-17 15:50:25",
                        "items": [
                            {
                                "id": 5,
                                "value": "123123",
                                "key_id": 2,
                                "product_id": 8,
                                "created_at": "2020-09-17 15:50:25",
                                "updated_at": "2020-09-17 15:50:25",
                                "key_name": "price",
                                "key": {
                                    "id": 2,
                                    "name": "price",
                                    "created_at": null,
                                    "updated_at": null
                                }
                            }
                        ]
                    }
                ],
                items: [{
                    product_id: null,
                    item_id: null,
                    product_items:[]
                }]
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            addItemsToProduct(event,index){
                let productId=event.target.value;
                this.products.forEach((product,key) =>{
                    if (product.id==productId){
                        this.items[index].product_items=product.items
                    }
                });
            },

        }
    }
</script>
