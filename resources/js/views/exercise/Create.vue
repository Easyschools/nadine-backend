<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>اضف تدريب جديد</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row form-group">
                            <div class="col-sm-1">
                                <label class="col-form-label">الاسم</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" v-model="item.name">
                            </div>
                            <div class="col-sm-1">
                            </div>
                            <div class="col-md-2 custom-control custom-checkbox mt-3">
                                <input v-model="forLesson" type="checkbox" class="custom-control-input"
                                       id="customCheck1">
                                <label class="custom-control-label" for="customCheck1">اضافته الى درس</label>
                            </div>
                        </div>
                        <div class="row form-group mt-3">
                            <div v-if="forLesson" class="col-sm-1">
                                <label class="col-form-label">اسم الدرس</label>
                            </div>
                            <div v-if="forLesson" class="col-sm-8">
                                <select class="form-control form-control-lg" v-model="item.lesson_id">
                                    <option v-for="lesson in lessons" :value="lesson.id">{{lesson.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group mt-5">
                            <div class="col-sm-1">
                                <label class="col-form-label">النص</label>
                            </div>
                            <!--<div class="col-sm-10" v-if="!forLesson">-->
                                <!--<textarea class="form-control" rows="5" v-model="item.text">-->
                                <!--</textarea>-->
                            <!--</div>-->
                            <div class="col-sm-10">
                                <vue-editor v-model="item.text"></vue-editor>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row mb-3 " style="display: flex; margin: 10px;">
                                    <h5 class="">الاقسام</h5>
                                    <button class="btn btn-outline-info text-right"
                                            type="button"
                                            @click="item.parts.push({title: null,questions:[{question:null,answer: null}]})"
                                            style="display: flex ; margin-right: auto">
                                        اضافة قسم جديد
                                    </button>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2 col-sm-12">
                                                <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                                    aria-orientation="vertical">
                                                    <li v-for="(part,index ) in item.parts">
                                                        <a
                                                            :class="(index)?'nav-link text-left':'nav-link text-left active'"
                                                            data-toggle="pill"
                                                            :href="'#part'+index" role="tab"
                                                            aria-controls="v-pills-home" aria-selected="true">
                                                            القسم {{index}}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-10 col-sm-12">
                                                <div class="tab-content" id="v-pills-tabContent">
                                                    <div v-for="(part,index ) in item.parts"
                                                         :class="(index==0)?'tab-pane fade active show':'tab-pane fade'"
                                                         :id="'part'+index"
                                                         role="tabpanel" aria-labelledby="v-pills-home-tab">
                                                        <button type="button"
                                                                class="float-right btn btn-icon btn-outline-danger"
                                                                v-if="index!=0||item.parts.length>1"
                                                                @click="item.parts.splice(index,1)"
                                                        >
                                                            <i class="feather icon-x"></i>
                                                        </button>
                                                        <div class="row form-group mt-3">
                                                            <div class="col-sm-2">
                                                                <label class="col-form-label">عنوان السؤال</label>
                                                            </div>
                                                            <vue-editor v-model="part.title"
                                                                        style="height: 50px;"></vue-editor>
                                                            <!--<div v-if="!forLesson" class="col-sm-8">-->
                                                            <!--<input type="text" class="form-control"-->
                                                            <!--v-model="part.title">-->
                                                            <!--</div>-->
                                                            <!--<div v-if="forLesson" class="col-sm-8">-->
                                                            <!--<select class="form-control form-control-lg"-->
                                                            <!--v-model="part.title">-->
                                                            <!--<option v-for="title in titles" :value="title"-->
                                                            <!--v-html="title">-->
                                                            <!--</option>-->
                                                            <!--</select>-->
                                                            <!--</div>-->
                                                        </div>
                                                        <div class="row form-group" style="margin-top: 100px;">
                                                            <div class="col-sm-12 mt-3">
                                                                <label class="col-form-label">الاسئله</label>
                                                                <button type="button" style="width: 120px;"
                                                                        @click="part.questions.push({question:null,answer: null})"
                                                                        class="float-right btn btn-sm btn-outline-primary">
                                                                    <i class="feather icon-plus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-5"
                                                             v-for="(question,questionIndex) in part.questions">
                                                            <div class="col-5">
                                                                <input type="text" placeholder="السؤال"
                                                                       class="form-control" v-model="question.question">
                                                            </div>
                                                            <div class="col-5">
                                                                <input type="text" placeholder="الاجابه"
                                                                       class="form-control" v-model="question.answer">
                                                            </div>
                                                            <div class="col-2">
                                                                <button
                                                                    type="button"
                                                                    v-if="part.questions.length>1"
                                                                    @click="part.questions.splice(questionIndex,1)"
                                                                    class="btn btn-sm btn-outline-danger">
                                                                    <i class="feather icon-x"></i>
                                                                </button>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="text-center mt-5">
                            <router-link to="/admin/exercise" class="btn btn-secondary">الغاء</router-link>
                            <button type="button" :disabled="disableButton" @click="createItem()"
                                    class="btn btn-primary">اضافة
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import {VueEditor} from "vue2-editor";
    import partTitles from './select.json';

    export default {
        name: "Create",
        components: {
            VueEditor,
        },
        data() {
            return {
                disableButton: false,
                forLesson: false,
                titles: [],
                lessons: [],
                show: false,
                item: {
                    name: null,
                    text: null,
                    lesson_id: null,
                    parts: [
                        {
                            title: null,
                            questions: [
                                {
                                    question: null,
                                    answer: null
                                }
                            ]
                        }
                    ],
                }
            };
        },
        created() {
            this.readFileJson();
            this.getLessons();
        },
        watch: {
            forLesson: function (val) {
                if (!val) {
                    this.item.lesson_id = null;
                }
            }
        },
        methods: {
            createItem() {
                this.disableButton = true;
                this.item.forLesson = this.forLesson;
                axios.post('/exercises', this.item)
                    .then(() => {
                        this.disableButton = false;
                        this.$router.push('/admin/exercise');
                        swal("Good job!", "A new exercise has been added!", "success");
                    })
                    .catch(err => {
                        this.disableButton = false;
                        this.errorMessages(err.response.data);
                        console.log(err)
                    });
            },
            readFileJson() {
                this.titles = partTitles.data
            },
            getLessons() {
                axios.get('/lessons?is_paginate=0')
                    .then(response => {
                        this.lessons = response.data.data
                    })
                    .catch(err => {
                        this.errorMessages(err.response.data);
                        console.log(err)
                    });
            }
        }
    }
</script>

<style scoped>

</style>
