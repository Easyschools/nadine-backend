<template>
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5> Add درس جديد</h5>
            </div>
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="name">الاسم</label>
                                    <input type="text" v-model="item.name" class="form-control" id="name">
                                </div>

                                <div class="form-group col-4">
                                    <label for="number">الرقم</label>
                                    <input type="number" v-model="item.number" class="form-control" id="number">
                                </div>

                            </div>
                            <div class="col-sm-12">
                                <div class="col-md-12 text-right">
                                    <button class="btn btn-secondary mb-3" type="button" @click="addSection()">
                                        Add قسم جديد
                                    </button>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2 col-sm-12">
                                                <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                                    aria-orientation="vertical">
                                                    <li v-for="(section,index) in item.sections">
                                                        <a :class="(index)?'nav-link text-left':'nav-link text-left active'"
                                                           id="v-pills-home-tab" data-toggle="pill"
                                                           :href="'#section'+index" role="tab"
                                                           aria-controls="v-pills-home" aria-selected="true">
                                                            القسم {{index}}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-10 col-sm-12">
                                                <div class="tab-content" id="v-pills-tabContent">
                                                    <div v-for="(section,index) in item.sections"
                                                         :class="(index==0)?'tab-pane fade active show':'tab-pane fade'"
                                                         :id="'section'+index" role="tabpanel"
                                                         aria-labelledby="v-pills-home-tab">
                                                        <div>
                                                            <div class="row mb-4">
                                                                <strong class="col-md-5 text-capitalize"
                                                                        style="font-size: 18px">
                                                                    قسم {{index}}
                                                                </strong>
                                                                <div
                                                                    class="custom-control custom-checkbox col-md-6 mt-2">
                                                                    <input type="checkbox"
                                                                           v-model="section.has_questions"
                                                                           class="custom-control-input"
                                                                           :id="'customCheck'+index">
                                                                    <label class="custom-control-label"
                                                                           :for="'customCheck'+index">
                                                                        لديه اسئله
                                                                    </label>
                                                                </div>
                                                                <button type="button"
                                                                        class="float-right btn btn-icon btn-outline-danger"
                                                                        v-if="index!=0||item.sections.length>1"
                                                                        @click="item.sections.splice(index,1)"
                                                                >
                                                                    <i class="feather icon-x"></i>
                                                                </button>

                                                            </div>
                                                            <div class="row ml-1">

                                                                <div class="col-md-12">
                                                                    <label
                                                                        style="font-weight: bold;margin-left: 160px;">المحتوى</label>
                                                                    <input type="file" :ref="'section'+index"
                                                                           @change="uploadSectionImage(index)">
                                                                </div>
                                                                <div class="col-md-2 mt-4 mb-3">
                                                                    <label style="font-weight: bold;">رقم القسم</label>
                                                                </div>
                                                                <div class="col-md-6 mt-3">
                                                                    <input type="number" v-model="section.number"
                                                                           class="form-control mob_no"
                                                                           autocomplete="off" maxlength="2">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 mb-4 mt-2"
                                                                 v-if="section.has_questions==true">
                                                                <strong style="font-size: 14px;color: darkred">الاسئله</strong>
                                                                <button type="button"
                                                                        class="btn  btn-icon btn-outline-info float-right"
                                                                        @click="section.questions.push({text: '',type: 0, answers: [{key: null,color: '',text: ''}]})"
                                                                >
                                                                    <i class="feather icon-plus"></i>
                                                                </button>
                                                            </div>
                                                            <div class="row mt-5"
                                                                 v-if="section.has_questions==true"
                                                                 v-for="(question,qindex) in section.questions">
                                                                <div class="offset-1 col-md-6">
                                                                    <div class="form-group fill">
                                                                        <label
                                                                            class="text-danger"
                                                                        > س {{qindex}}</label>
                                                                        <!--<textarea v-model="question.question"-->
                                                                        <!--class="form-control"-->
                                                                        <!--placeholder="Enter question"></textarea>-->
                                                                        <vue-editor
                                                                            v-model="question.question"></vue-editor>

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 form-group fill">
                                                                    <label>Type</label>
                                                                    <select class="form-control" v-model="question.type"
                                                                            @change="changeQuestionType(question.type,question.question,index,qindex)">
                                                                        <option value="0">سؤال واجابه</option>
                                                                        <option value="1">الاعراب</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <label></label>
                                                                    <button class="btn btn-sm btn-outline-danger"
                                                                            type="button"
                                                                            v-if="qindex!==0||section.questions.length>1"
                                                                            @click="section.questions.splice(qindex,1)"
                                                                    >
                                                                        <i class="feather icon-x"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="offset-1 col-md-9">
                                                                    <label>الاجابه</label>
                                                                    <div v-for="(answer,answerIndex) in question.answers"
                                                                         class="col-md-12 form-group fill">
                                                                        <div class="row mt-5">
                                                                            <label class="col-md-4 mt-3"
                                                                                   :style="{'color':answer.color,'font-weight':'bold'}"
                                                                                   v-if="question.type==1">{{answer.key}}</label>
                                                                            <div class="col-md-7"
                                                                                 v-if="question.type==1">
                                                                                <button v-for="pcolor in presetColors"
                                                                                        type="button"
                                                                                        @click="putColorValue(answerIndex,qindex,index,pcolor)"
                                                                                        class="btn btn-sm mr-2 mb-2"
                                                                                        :style="{'background-color':pcolor,'border-color':pcolor,'color':'#fff'}">
                                                                                    <i class="feather icon-sun"></i>
                                                                                </button>
                                                                            </div>
                                                                            <input type="text" v-model="answer.text"
                                                                                   class="form-control mt-3">
                                                                        </div>
                                                                    </div>

                                                                    <hr>
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
                                    <button type="button" @click="createItem" :disabled="disableButton" class="btn btn-primary">
                                        Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import {VueEditor} from "vue2-editor";
    // import Material from "vue-color/src/components/Material";

    export default {
        name: "Create",
        components: {
            // Material,
            VueEditor,
        },
        data() {
            return {
                disableButton:false,
                 presetColors:
                     ['#ffd700', '#f78c00', '#7cfc00', '#008000', '#00b0f0', '#c00000', '#808080', '#5f497a', '#948a54', '#ff00ff', '#32cd32', '#0070c0', '#ff0000', '#000000']
                 ,
                 presetColors2: [
                    'rgb(255, 215, 0)', 'rgb(247, 140, 0)',
                    'rgb(124, 252, 0)', 'rgb(0, 128, 0)',
                    'rgb(0, 176, 240)', 'rgb(192, 0, 0)',
                    'rgb(128, 128, 128)', 'rgb(95, 73, 122)',
                    'rgb(148, 138, 84)', 'rgb(255, 0, 255)',
                    'rgb(50, 205, 50)', 'rgb(0, 112, 192)',
                    'rgb(255, 0, 0)', 'rgb(0, 0, 0)'
                ],
                item: {
                    name: null,
                    number: null,
                    sections: [
                        {
                            content: '',//image
                            number: 0,//image
                            has_questions: true,
                            questions: [
                                {
                                    question: '',
                                    type: 0,
                                    answers: [
                                        {
                                            key: null,
                                            color: '',
                                            text: ''
                                        }
                                    ]
                                }
                            ],
                        },
                    ]
                }
            };
        },
        methods: {
            createItem() {
                this.disableButton=true;
                let data = this.getFormData();
                axios.post('/lessons', data).then(response => {
                    this.disableButton=false;
                    this.$router.push('/admin/lesson');
                    swal("Good job!", "A new lesson has been added!", "success");
                }).catch(err => {
                    this.disableButton=false;
                    console.log(err);
                    this.errorMessages(err.response.data);
                });
            },
            addSection() {
                this.item.sections.push({
                    content: '',
                    number: 0,
                    has_questions: true,
                    questions: [{question: '', type: 0, answers: [{key: null, color: '', text: ''}]}]
                })
            },
            uploadSectionImage(index) {
                this.item.sections[index].content = this.$refs['section' + index][0].files[0];
            },
            putColorValue(answerIndex, qindex, index, color) {
                this.item.sections[index].questions[qindex].answers[answerIndex].color = color;
            },
            changeQuestionType(q_type, question, s_index, q_index) {
                if (q_type == 0) {
                    this.item.sections[s_index].questions[q_index].answers = [{key: null, color: '', text: ''}]
                } else {
                    let keywords = question.replace(/<[^>]*>?/gm, '').split(" ");
                    let answers = [];
                    keywords.forEach(function (word) {
                        if (word != "") {
                            answers.push({key: word, color: '', text: ''})
                        }
                    })
                    this.item.sections[s_index].questions[q_index].answers = answers;
                }
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
                    if (typeof(data) === 'boolean' && data === false) {
                        value = '0'
                    }
                    if (typeof(data) === 'boolean' && data === true) {
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
