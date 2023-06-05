<template>
    <div class="st-modal">
        <div style="display: block;width: 100%;">
            <div style="display: table;width: 100%;border-bottom: thin solid #cbcbcb">
                <div v-on:click="openAddItem()" class="pull-right"
                     style="height:fit-content; margin: 0px ;margin-top: 6px ; vertical-align: middle; cursor: pointer; float: right; padding: 8px;">
                    <i class="las la-plus-circle"></i> Add Question
                </div>
                <div v-on:click="openAddCategory()" class="pull-right"
                     style="height:fit-content; margin: 0px ;margin-top: 6px ; vertical-align: middle; cursor: pointer; float: right; padding: 8px;">
                    <i class="las la-plus-circle"></i> Add Category
                </div>
                <div v-on:click="openAddSection()" class="pull-right"
                     style="height:fit-content; margin: 0px ;margin-top: 6px ; vertical-align: middle; cursor: pointer; float: right; padding: 8px;">
                    <i class="las la-plus-circle"></i> Add Section
                </div>
            </div>
            <div style="display: block;">
                <div style="display: table;width: 100%;border:none;border-bottom: thin solid lightgrey;"
                     v-if="!hideUtilButton">
                    <div
                        v-on:click="openImportDialog()"
                        class="pull-right"
                        style="height:fit-content; margin: 0px ;margin-top: 6px ; vertical-align: middle; cursor: pointer; float: right; padding: 8px;">
                        <i class="las la-upload"></i> XLS
                    </div>
                    <div
                        v-on:click="downloadTemplate()"
                        class="pull-right"
                        style="height:fit-content; margin: 0px ;margin-top: 6px ; vertical-align: middle; cursor: pointer; float: right; padding: 8px;">
                        <i class="las la-download"></i> XLS Template
                    </div>
                    <div
                        class="pull-right import-tool"
                        style="height:fit-content; margin: 0px ;margin-top: 6px ; vertical-align: middle; cursor: pointer; float: right; padding: 8px;padding-top: 0px;">
                        <b-form-checkbox
                            switch
                            v-model="includeData"
                        >
                            Include Data in Template
                        </b-form-checkbox>
                    </div>
                </div>
                <div class="w-100">
                    <template v-for="(sitem, sindex) in formSectionList">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6>{{ sitem.formSectionName }}</h6>
                                <p>{{ sitem.formSectionDescription }}</p>
                            </div>
                            <div class="d-flex justify-content-end" style="width: 200px;max-width: 250px;padding-right: 0px;">
                                <span v-on:click="openAddCategory(sitem)" style="cursor: pointer;margin-right:15px;"
                                      class="pull-right"><i class="las la-plus-circle"></i> Category</span>
                                <span v-on:click="editSectionItem(sitem)" style="cursor: pointer;margin-right:15px;"
                                      class="pull-right"><i class="las la-pencil-alt"></i></span>
                                <span v-on:click="removeSectionItem(sitem)" style="cursor: pointer;" class="pull-right"><i
                                    class="las la-times-circle"></i></span>
                            </div>
                        </div>
                        <template  v-for="(citem, cindex) in formCategoryList">
                            <div class="d-flex justify-content-between align-items-center ml-3 pl-1">
                                <div>
                                    <h6>{{ citem.formCategoryName }}</h6>
                                    <p>{{ citem.formCategoryDescription }}</p>
                                </div>
                                <div class="d-flex justify-content-end" style="width: 250px;max-width: 250px;padding-right: 0px;">
                                        <span v-on:click="openAddItem(citem)" style="cursor: pointer;margin-right:15px;">
                                            <i class="las la-plus-circle"></i> Question</span>
                                    <span v-on:click="editCategoryItem(citem)" style="cursor: pointer;margin-right:15px;">
                                            <i class="las la-pencil-alt"></i></span>
                                    <span v-on:click="removeCategoryItem(citem)" style="cursor: pointer;">
                                            <i class="las la-times-circle"></i></span>
                                </div>
                            </div>
                            <div class="w-100 pl-5">
                                <table class="table">
                                    <tr v-if="showTableHeader">
                                        <th v-if="ordered" class="seq">
                                            No.
                                        </th>
                                        <th v-for="col in cols"
                                            :class="isExist(col.class)? col.class:''">
                                            {{ col.label }}
                                        </th>
                                        <th style="width: 75px;max-width: 75px;padding-right: 10px;text-align: right;">
                                            <span v-on:click="refreshTable()" style="cursor: pointer;"><i class="las la-redo"></i></span>
                                        </th>
                                    </tr>

                                    <tr v-for="(item, index) in questionList">
                                        <td v-if="ordered" style="max-width: 35px;" class="text-25">
                                            {{ index + 1 }}
                                        </td>
                                        <td v-for="col in cols" :class="isExist(col.class)? col.class:'text-right'">
                                            <div v-if="typeof item[col.key]=='object'">
                                                <a-tooltip placement="top" :title="_.get(item[col.key] , 'text' )">
                                                    <template v-if="splitComma">
                                                        <div
                                                            v-html="isPathExist(item[col.key],'text')? commaToSpace(item[col.key].text): ''"></div>
                                                    </template>
                                                    <template v-else>
                                                        <div
                                                            v-html="isPathExist(item[col.key],'text')? setFormat(col, item[col.key].text ) : ''"></div>
                                                    </template>
                                                </a-tooltip>
                                            </div>
                                            <div v-else>
                                                <a-tooltip placement="top" :title="item[col.key]">
                                                    <template v-if="splitComma">
                                                        <div v-html="isExist(item[col.key])? commaToSpace(item[col.key]): ''"></div>
                                                    </template>
                                                    <template v-else>
                                                        <div v-html="isExist(item[col.key])? setFormat(col, item[col.key] ): ''"></div>
                                                    </template>
                                                </a-tooltip>
                                            </div>
                                        </td>
                                        <td style="width: 75px;max-width: 75px;padding-right: 0px;">
                                            <span v-on:click="editItem(item)" style="cursor: pointer;margin-right:15px;"
                                                  class="pull-right"><i class="las la-pencil-alt"></i>
                                            </span>
                                            <span v-on:click="removeItem(item)" style="cursor: pointer;" class="pull-right"><i
                                                class="las la-times-circle"></i>
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </template>
                    </template>
                </div>
            </div>

        </div>
        <b-modal :id="sectionModalId"
                 title="Section Name"
                 @ok="addSection"
        >
            <div class="row">
                <div class="col-2">
                    <label for="formSectionSeq">Seq</label>
                    <input type="number" v-model="formSectionSeq" class="form-control"></input>
                </div>
                <div class="col-10">
                    <label for="formSectionSeq">Section Name</label>
                    <input type="text" v-model="formSectionName" class="form-control"></input>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label for="formSectionSeq">Section Description</label>
                    <input type="text" v-model="formSectionDescription" class="form-control"></input>
                </div>
            </div>
        </b-modal>

        <b-modal :id="categoryModalId"
                 title="Category Name"
                 @ok="addCategory"
        >
            <label for="formSectionSeq">Section</label>
            <b-form-select
                name="formSection"
                v-model="formCategorySection"
                class="form-control  "
            >
                <b-form-select-option v-for="(val, key, idx) in formSectionList" :key="val.seq" :value="val">
                    {{ val.formSectionName }}
                </b-form-select-option>
            </b-form-select>
            <div class="row">
                <div class="col-2">
                    <label for="formCategorySeq">Seq</label>
                    <input type="number" v-model="formCategorySeq" class="form-control"></input>
                </div>
                <div class="col-10">
                    <label for="formCategoryName">Category Name</label>
                    <input type="text" v-model="formCategoryName" class="form-control"></input>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label for="formSectionSeq">Category Description</label>
                    <input type="text" v-model="formCategoryDescription" class="form-control"></input>
                </div>
            </div>
        </b-modal>

        <b-modal :id="alertId"
                 title="Required"
                 ok-only
        >
            All fields should not be empty.
        </b-modal>

        <b-modal :id="importDialogId"
                 @ok="commitData"
                 size="xl"
                 centered
                 scrollable
                 title="Upload Items"
                 modal-class="modal-bv">
            <import-data
                :importid="importId"
                :sourceurl="sourceUrl"
                :previewcolumns="previewColumns"
                :previewheadings="previewHeadings"
                :uploadurl="uploadUrl"
                :commiturl="commitUrl"
            ></import-data>

        </b-modal>

        <b-modal :id="modalId"
                 @ok.prevent="addItem"
                 :size="modalSize"
                 :title="getTitle()"
                 :hide-backdrop="hideBackdrop"
                 size="lg"
                 no-close-on-backdrop
                 no-close-on-esc
                 centered
                 scrollable
                 @shown="onModalShown"
                 @hidden="clearForm"
                 modal-class="modal-bv">

            <validation-observer v-slot="{ invalid }" ref="addItem_veeObserver">
                <div class="row">
                    <div class="col-2">
                        <label for="formCode">Step</label>
                        <validation-provider rules="" v-slot="{ errors }" name="form code">
                            <input type="text"
                                   name="step"
                                   v-model="step"
                                   class="form-control  "
                            >
                            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>

                    </div>
                    <div class="col-5">
                        <label for="formCode">Form Section</label>
                        <validation-provider rules="required" v-slot="{ errors }" name="form section">
                            <b-form-select
                                name="formSection"
                                v-model="formSection"
                                class="form-control  "
                            >
                                <b-form-select-option v-for="(val, key, idx) in formSectionList" :key="val.seq" :value="val">
                                    {{ val.formSectionName }}
                                </b-form-select-option>
                            </b-form-select>
                            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>
                    </div>
                    <div class="col-5">
                        <label for="formCode">Form Category</label>
                        <validation-provider rules="required" v-slot="{ errors }" name="form category">
                            <b-form-select
                                name="formCategory"
                                v-model="formCategory"
                                class="form-control  "
                            >
                                <b-form-select-option v-for="(val, key, idx) in formCategoryList" :key="val.seq" :value="val">
                                    {{ val.formCategoryName }}
                                </b-form-select-option>
                            </b-form-select>

                            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <label for="seq">Seq</label>
                        <validation-provider rules="required" v-slot="{ errors }" name="seq">
                            <input type="number"
                                   name="seq"
                                   v-model="seq"
                                   class="form-control text-right  "
                            >
                            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>

                    </div>
                    <div class="col-10">
                        <label for="question">Question</label>
                        <validation-provider rules="required" v-slot="{ errors }" name="question">
                            <textarea
                                name="question"
                                v-model="question"
                                class="form-control  "
                            >
                            </textarea>
                            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>

                    </div>
                </div>
                <div class="row">
                    <div class="col-9">
                        <label for="questionType">Question Type</label>
                        <validation-provider rules="required" v-slot="{ errors }" name="question type">
                            <b-form-select
                                v-model="questionType"
                                :options="questionTypeOptions"
                                class="form-control  "
                            ></b-form-select>

                            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>

                    </div>
                    <div class="col-3">
                        <label for="totalScore">Total Score</label>
                        <validation-provider rules="" v-slot="{ errors }" name="total score">
                            <input type="number"
                                   name="totalScore"
                                   v-model="totalScore"
                                   class="form-control text-right  "
                            >

                            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>

                    </div>
                </div>
                <div class="row">
                    <div class="col-9">
                        <label for="defaultAnswer">Default / Single Answer</label>
                        <validation-provider rules="required" v-slot="{ errors }" name="default / single answer">
                            <input type="text"
                                   name="defaultAnswer"
                                   v-model="defaultAnswer"
                                   class="form-control  "
                            >

                            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>

                    </div>
                    <div class="col-3">
                        <label for="defaultScore">Default / Single Score</label>
                        <validation-provider rules="required" v-slot="{ errors }" name="default / single score">
                            <input type="number"
                                   name="defaultScore"
                                   v-model="defaultScore"
                                   class="form-control text-right  "
                            >

                            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>

                    </div>
                </div>
                <div class="row">
                    <div class="col-9">
                        <label for="answer1">Answer 1</label>
                        <validation-provider rules="" v-slot="{ errors }" name="answer 1">
                            <input type="text"
                                   name="answer1"
                                   v-model="answer1"
                                   class="form-control  "
                            >

                            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>

                        <label for="answer2">Answer 2</label>
                        <validation-provider rules="" v-slot="{ errors }" name="answer 2">
                            <input type="text"
                                   name="answer2"
                                   v-model="answer2"
                                   class="form-control  "
                            >

                            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>

                        <label for="answer3">Answer 3</label>
                        <validation-provider rules="" v-slot="{ errors }" name="answer 3">
                            <input type="text"
                                   name="answer3"
                                   v-model="answer3"
                                   class="form-control  "
                            >

                            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>

                        <label for="answer4">Answer 4</label>
                        <validation-provider rules="" v-slot="{ errors }" name="answer 4">
                            <input type="text"
                                   name="answer4"
                                   v-model="answer4"
                                   class="form-control  "
                            >

                            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>

                        <label for="answer5">Answer 5</label>
                        <validation-provider rules="" v-slot="{ errors }" name="answer 5">
                            <input type="text"
                                   name="answer5"
                                   v-model="answer5"
                                   class="form-control  "
                            >

                            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>

                    </div>
                    <div class="col-3">
                        <label for="score1">Score 1</label>
                        <validation-provider rules="" v-slot="{ errors }" name="score 1">
                            <input type="number"
                                   name="score1"
                                   v-model="score1"
                                   class="form-control text-right  "
                            >

                            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>

                        <label for="score2">Score 2</label>
                        <validation-provider rules="" v-slot="{ errors }" name="score 2">
                            <input type="number"
                                   name="score2"
                                   v-model="score2"
                                   class="form-control text-right  "
                            >

                            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>

                        <label for="score3">Score 3</label>
                        <validation-provider rules="" v-slot="{ errors }" name="score 3">
                            <input type="number"
                                   name="score3"
                                   v-model="score3"
                                   class="form-control text-right  "
                            >

                            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>

                        <label for="score4">Score 4</label>
                        <validation-provider rules="" v-slot="{ errors }" name="score 4">
                            <input type="number"
                                   name="score4"
                                   v-model="score4"
                                   class="form-control text-right  "
                            >

                            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>

                        <label for="score5">Score 5</label>
                        <validation-provider rules="" v-slot="{ errors }" name="score 5">
                            <input type="number"
                                   name="score5"
                                   v-model="score5"
                                   class="form-control text-right  "
                            >

                            <div class="error-message" style="color: rgba(189, 61, 61, 0.839)">{{ errors[0] }}</div>
                        </validation-provider>

                    </div>
                </div>
            </validation-observer>

        </b-modal>

    </div>
</template>

<script>
export default {
    name: "FormQuestionDialog",
    created() {

    },
    mounted() {
        this.mode = 'Create';
        this.itemName = this.modalEntity;
    },
    props: {
        label: {
            type: String,
            default: 'Table Input'
        },
        modalEntity: {
            type: String,
            default: 'Item'
        },
        entityNameKey: {
            type: [String, Array],
            default: function () {
                return 'id';
            }
        },
        cols: {
            type: [Array, Object],
            default: function () {
                return [];
            }
        },
        items: {
            type: Array,
            default: function () {
                return [];
            }
        },
        sections: {
            type: Array,
            default: function () {
                return [];
            }
        },
        categories: {
            type: Array,
            default: function () {
                return [];
            }
        },
        itemTotal: {
            type: [Array, Object],
            default: function () {
                return [];
            }
        },
        ordered: {
            type: Boolean,
            default: false

        },
        content: {
            type: [String, Object, Array]
        },
        params: {
            type: [String, Object, Array]
        },
        template: {
            type: [String, Object, Array]
        },
        objectDefault: {
            type: [String, Object, Array],
            default: function () {
                return {}
            }
        },
        hideAddButton: {
            type: Boolean,
            default: function () {
                return false
            }
        },
        hideUtilButton: {
            type: Boolean,
            default: function () {
                return false;
            }
        },
        importDialogId: {
            type: String,
            default: 'spiImportModal'
        },
        sectionModalId: {
            type: String,
            default: 'spiSectionModal'
        },
        categoryModalId: {
            type: String,
            default: 'spiCategoryModal'
        },
        modalId: {
            type: String,
            default: 'spiModal'
        },
        alertId: {
            type: String,
            default: 'spiModal'
        },
        showTableHeader: {
            type: Boolean,
            default: function () {
                return false
            }
        },
        modalSize: {
            type: String,
            default: ''
        },
        splitComma: {
            type: Boolean,
            default: function () {
                return false;
            }
        },
        extAdd: {
            type: [Boolean, String],
            default: function () {
                return false;
            }
        },
        extEdit: {
            type: [Boolean, String],
            default: function () {
                return false;
            }
        },
        extAddCmd: {
            type: String,
            default: ''
        },
        extEditCmd: {
            type: String,
            default: ''
        },
        ns: {
            type: String,
            default: 'doc'
        },
        /* below are item uploader props */
        previewColumns: {
            type: [Object, Array],
            default: function () {
                return [];
            }
        },
        previewHeadings: {
            type: [Object, Array],
            default: function () {
                return [];
            }
        },
        sourceUrl: {
            type: String,
            default: ''
        },
        uploadUrl: {
            type: String,
            default: ''
        },
        commitUrl: {
            type: String,
            default: ''
        },
        downloadTmplUrl: {
            type: String,
            default: ''
        }
    },
    data: function () {
        return {
            mode: '',
            editIndex: 0,
            editObj: _.clone(this.objectDefault),
            showModal: false,
            hideBackdrop: false,
            itemName: '',
            importId: '',
            includeData: false,
            formSectionName: '',
            formCategoryName: '',
            formSectionDescription: '',
            formCategoryDescription: '',
            //question related
            // main question list array
            questionList: [],

            formCode: '',
            seq: 0,
            question: '',
            questionType: 'radioselect',
            defaultAnswer: '',
            defaultScore: 0,
            answer1: '',
            answer2: '',
            answer3: '',
            answer4: '',
            answer5: '',
            score1: 0,
            score2: 0,
            score3: 0,
            score4: 0,
            score5: 0,
            totalScore: 0,
            formSection: '',
            formSectionSeq: 0,
            formCategory: '',
            formCategorySeq: 0,
            formCategorySection: '',
            formSectionList: [],
            formCategoryList: [],
            objectKey: '',
            questionTypeOptions: [{"text": "Radio", "value": "radioselect"}, {
                "text": "Checkbox",
                "value": "checkboxselect"
            }, {"text": "Text", "value": "text"}, {"text": "Number", "value": "number"}, {
                "text": "Tristate",
                "value": "tristate"
            }, {"text": "Date", "value": "datepicker"}, {
                "text": "Datetime",
                "value": "datetimepicker"
            }, {"text": "Sign Pad", "value": "signpad"}, {"text": "File Upload", "value": "attachmentupload"}],
            runFormData: {},
            runFormContent: '',
            runFormTemplate: '',
            runFormModel: {},
            runFormDefault: {},
            runFormCode: '',
            runFormId: '',

        };
    },
    watch: {
        items: {
            deep: true,
            handler(items) {
                console.log('items emit', items);
            }
        },
        formCategoryList: {
            deep: true,
            handler(cats) {
                this.$emit('update:sections', cats);
                console.log('cat emit', cats);
            }
        },
        formSectionList: {
            deep: true,
            handler(secs) {
                this.$emit('update:sections', secs);
                console.log('secs emit', secs);
            }
        }
    },
    methods: {
        getTitle() {
            return this.mode + ' ' + this.label;
        },
        onModalShown() {

        },
        updateItem() {

        },
        clearForm() {
            this.formCode = '';
            this.seq = 0;
            this.question = '';
            this.questionType = 'radioselect';
            this.defaultAnswer = '';
            this.defaultScore = 0;
            this.answer1 = '';
            this.answer2 = '';
            this.answer3 = '';
            this.answer4 = '';
            this.answer5 = '';
            this.score1 = 0;
            this.score2 = 0;
            this.score3 = 0;
            this.score4 = 0;
            this.score5 = 0;
            this.totalScore = 0;
            this.formSection = '';
            this.formCategory = '';
            this.objectKey = '';
        },
        calcTotalScore() {
            if (this.questionType == 'radioselect' || this.questionType == 'checkboxselect') {
                this.totalScore = parseInt(this.score1) + parseInt(this.score2) + parseInt(this.score3) + parseInt(this.score4) + parseInt(this.score5);
                this.defaultScore = 0;
            } else if (this.questionType == 'tristate') {
                this.answer1 = 'Yes';
                this.answer2 = 'No';
                this.answer3 = 'NA';
                this.answer4 = '';
                this.answer5 = '';
                this.score4 = 0;
                this.score5 = 0;
                this.totalScore = parseInt(this.score1) + parseInt(this.score2) + parseInt(this.score3) + parseInt(this.score4) + parseInt(this.score5);
                this.defaultScore = 0;
            } else {
                this.score1 = 0;
                this.score2 = 0;
                this.score3 = 0;
                this.score4 = 0;
                this.score5 = 0;
                this.totalScore = parseInt(this.defaultScore);
            }
        },
        closeModal() {
            this.editIndex = 0;
            this.editObj = _.cloneDeep(this.objectDefault);
            this.showModal = false;
            this.$bvModal.hide(this.modalId);
        },
        checkProperties(obj) {
            var valid = true;
            console.log('validate', obj);
            for (var key in obj) {

                var col = _.find(this.cols, {key: key});
                console.log('validate rule', col);
                var validator = '';
                if (_.has(col, 'validator')) {
                    validator = _.get(col, 'validator');
                }
                if (validator == 'required') {
                    if (obj[key] === '' || obj[key] === null || typeof obj[key] === undefined)
                        //_.isUndefined(obj[key]) || _.isEmpty(obj[key]) || ( ( parseInt(obj[key]) != 0 ) && _.isNull(obj[key]) ) || obj[key] == ''  )
                    {
                        valid = false;
                    }
                }
            }
            return valid;
        },
        isExist(val) {
            return !(_.isNull(val) || _.isUndefined(val))
        },
        isPathExist(val, path) {
            return !(_.isNull(val) || _.isUndefined(val) || _.has(val, path))
        },
        setFormat(col, val) {
            // console.log('coldef', col);
            var fmt = _.get(col, 'format');
            // console.log('fmt', fmt);
            if (fmt) {
                if (fmt == 'currency') {
                    return this.formatCurrency(val);
                }
                if (fmt == 'numeric') {
                    return this.formatNumeric(val, 2);
                }
                if (fmt == 'integer') {
                    return this.formatNumeric(val, 0);
                }
                return val;
            } else {
                return val;
            }
        },
        fixType(val) {
            var out;
            _.each(val, (val, key, idx) => {
                if (_.has(this.cols[idx], 'type') && _.get(this.cols[idx], 'type') == 'Number') {
                    out[idx][key] = parseFloat(val[idx][key]);
                } else {
                    out[idx][key] = val[idx][key];
                }
            });

            return out;
        },
        formatCurrency(val) {
            return accounting.formatMoney(parseFloat(val), '', 2, '.', ',');
        },
        formatNumeric(val, precision) {
            return accounting.formatNumber(parseFloat(val), precision, '.', ',');
        },
        refreshTable() {
            this.$emit('onitemchange', this.items);
        },
        addItem(event) {

            this.$refs.addItem_veeObserver.validate()
                .then((valid) => {
                    console.log('valid', valid);
                    if(valid) {

                        var newObj = this.collectData();
                        let newData = _.cloneDeep(newObj);

                        if (this.mode == 'Edit') {
                            this.questionList[this.editIndex] = newData;
                        } else {
                            this.questionList.push(newData);
                        }
                        this.editIndex = 0;
                        this.$bvModal.hide(this.modalId);
                        this.$emit('update:items', this.questionList);
                        this.$emit('onitemchange', this.questionList);
                        this.clearForm();

                    }else{
                        this.$bvModal.show(this.alertId);
                    }
                })
                .catch((error) => {
                    alert(error.toString());
                })

        },
        collectData(){
            var fdata = {
                formCode : this.formCode,
                seq : this.seq,
                question : this.question,
                questionType : this.questionType,
                defaultAnswer : this.defaultAnswer,
                defaultScore : this.defaultScore,
                answer1 : this.answer1,
                answer2 : this.answer2,
                answer3 : this.answer3,
                answer4 : this.answer4,
                answer5 : this.answer5,
                score1 : this.score1,
                score2 : this.score2,
                score3 : this.score3,
                score4 : this.score4,
                score5 : this.score5,
                totalScore : this.totalScore,
                formSection : this.formSection,
                formCategory : this.formCategory,
                objectKey : this.objectKey
            };
            return fdata;
        },
        setFormData(obj){
            this.formCode = obj.formCode ;
            this.seq = obj.seq ;
            this.question = obj.question ;
            this.questionType = obj.questionType ;
            this.defaultAnswer = obj.defaultAnswer ;
            this.defaultScore = obj.defaultScore ;
            this.answer1 = obj.answer1 ;
            this.answer2 = obj.answer2 ;
            this.answer3 = obj.answer3 ;
            this.answer4 = obj.answer4 ;
            this.answer5 = obj.answer5 ;
            this.score1 = obj.score1 ;
            this.score2 = obj.score2 ;
            this.score3 = obj.score3 ;
            this.score4 = obj.score4 ;
            this.score5 = obj.score5 ;
            this.totalScore = obj.totalScore ;
            this.formSection = obj.formSection ;
            this.formCategory = obj.formCategory ;
            this.objectKey = obj.objectKey
        },
        resetForm() {
            this.mode = 'Create';
            this.itemName = this.modalEntity;
            this.editObj = _.cloneDeep(this.objectDefault);
        },
        removeItem(obj) {
            var index = this.questionList.indexOf(obj);
            this.questionList.splice(index, 1);
            this.$emit('onitemchange', this.questionList);
        },

        editItem(obj) {
            this.mode = 'Edit';
            this.editIndex = this.questionList.indexOf(obj);
            this.editObj = _.cloneDeep(this.questionList[this.editIndex]);

            if (_.has(this.editObj, this.entityNameKey)) {
                this.itemName = _.get(this.editObj, this.entityNameKey);
            } else {
                this.itemName = '';
            }

            this.setFormData(this.editObj);

            this.showModal = true;
            this.$bvModal.show(this.modalId);

        },
        isEmpty(obj) {
            for (var key in obj) {
                if (obj.hasOwnProperty(key))
                    return false;
            }
            return true;
        },
        openAddItem() {
            this.mode = 'Create';
            this.editObj = {};
            this.editObj = _.cloneDeep(this.objectDefault);
            this.showModal = true;
            this.itemName = this.modalEntity;
            this.$bvModal.show(this.modalId);
        },
        openAddSection() {
            this.mode = 'Create';
            this.formSectionName = '';
            this.formSectionDescription = '';
            this.$bvModal.show(this.sectionModalId);
        },
        openAddCategory(section = null) {
            this.mode = 'Create';
            this.formCategoryName = '';
            this.formCategoryDescription = '';
            this.$bvModal.show(this.categoryModalId);
        },
        openImportDialog() {
            this.importId = this.generateRandomString(10);
            console.log('import dialog id', this.importDialogId);
            this.$bvModal.show(this.importDialogId);
        },
        commitData() {

            axios.post(this.sourceUrl + '?importid=' + this.importId, {
                page: 'all',
                perPage: 100,
                columnFilters: {},
                sort: {field: '', type: ''}
            })
                .then(response => {
                    if (response.data.result == 'OK') {
                        var items = response.data.data;
                        this.questionList = items;
                        this.$emit('update:items', items);
                        this.$bvModal.hide(this.importDialogId);
                        this.$emit('onitemchange', this.questionList);
                    }
                })
                .catch(function (error) {
                    console.log(error);
                }).finally(function () {
                this.$emit('onitemchange', this.items);
            });
        },
        downloadTemplate() {
            console.log(this.downloadTmplUrl, this.previewHeadings);
            axios.post(this.downloadTmplUrl, {
                headings: this.previewHeadings,
                items: this.items,
                includeData: this.includeData
            })
                .then(response => {
                    if (response.data.result == 'OK') {
                        window.location.href = response.data.data.urlxls;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        generateRandomString(length = 6) {
            return Math.random().toString(20).substr(2, length);
        },
        saveSplit(str) {
            if (_.isString(str)) {
                if (_.isString(str) != '') {
                    var arr = str.split(',');
                    if (_.isArray(arr)) {
                        return arr
                    } else {
                        return []
                    }
                }
            } else {
                return []
            }
        },
        commaToSpace(str) {
            var sp = this.saveSplit(str);
            return _.isArray(sp) ? sp.join(" ") : str;
        },
        attachDoc() {
            alert('attach doc');
        },
        addSection(){
            let newSection = {
                formSectionSeq : this.formSectionSeq,
                formSectionName : this.formSectionName,
                formSectionDescription : this.formSectionDescription
            };
            this.formSectionList.push( newSection );
        },
        addCategory(){
            let newCat = {
                formCategorySection : this.formCategorySeq,
                formCategorySeq : this.formCategorySeq,
                formCategoryName : this.formCategoryName,
                formCategoryDescription : this.formCategoryDescription
            };
            this.formCategoryList.push( newCat );
        }
    }
}
</script>

<style scoped>
.modal-bv {
    z-index: 10050 !important;
}

td, td div {
    white-space: normal !important;
    vertical-align: top;
    text-overflow: ellipsis;
    overflow: hidden;
}

.st-modal {
    width: 100%;
    padding-left: 8px;
    padding-right: 8px;
}

.text-right {
    text-align: right;
}

.text-center {
    text-align: center;
}

.import-tool .custom-switch label.custom-control-label {
    padding-top: 0px !important;
}

</style>
