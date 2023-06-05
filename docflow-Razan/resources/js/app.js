/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
//This is very important to used with the window object
window.Vue = require('vue');

var moment = require('moment-timezone');
var momentDurationFormatSetup = require("moment-duration-format");
momentDurationFormatSetup(moment);

//moment.tz.setDefault("UTC");
moment.tz.setDefault("Asia/Jakarta");

window.moment = moment;

window.Vue.prototype.moment = moment;

window.tz = "Asia/Jakarta";

window.Vue.prototype.tz = "Asia/Jakarta";

window.accounting = require('accounting');

window.writtenNumber = require('written-number');

window.Vue.prototype.writtenNumber = require('written-number');

import { format, formatDistance, formatRelative, subDays } from 'date-fns';

window.Vue.prototype.format = format;

window.Vue.prototype.accounting = require('accounting');

window.normalizeUrl = require('normalize-url');

window.Vue.prototype.normalizeUrl = function(url){
                                        try{
                                            var u = window.normalizeUrl(url);
                                            return u;
                                        }catch (e) {
                                            console.log(e.toString());
                                        }
                                        return url;
                                    };

window.jsonFormater = require('json-string-formatter');
Vue.prototype.jsonFormater = require('json-string-formatter');

window.gmapApi = 'AIzaSyCKyqnkk6M8VV27w2DsxieyzEU-J6RFMgY';

Vue.prototype.gmapApi = window.gmapApi;

window._ = require('lodash');
Vue.prototype._ = require('lodash');

import VueClipboard from 'vue-clipboard2';

VueClipboard.config.autoSetContainer = true;// add this line
Vue.use(VueClipboard);

import CodeMirror from 'codemirror';
import 'codemirror/lib/codemirror.css';
import 'codemirror/mode/htmlmixed/htmlmixed';
import 'codemirror/mode/php/php';
import 'codemirror/mode/javascript/javascript';
import 'codemirror/mode/sql/sql';
import 'codemirror/mode/yaml/yaml';
import 'codemirror/theme/monokai.css';
import 'codemirror/theme/material-darker.css';
import 'codemirror/addon/selection/active-line.js';

window.CodeMirror = CodeMirror;
window.Vue.prototype.CodeMirror = CodeMirror;

// Global Event Bus
window.bus = new Vue();

window.formatDate = function(dateString, dateFormat){
    var dtrans = moment(dateString).format(dateFormat);
    return dtrans;
};

window.splitCamel = function (s) {
    var re, match, output = [];
    // re = /[A-Z]?[a-z]+/g
    re = /([A-Za-z]?)([a-z]+)/g;

    match = re.exec(s);
    while (match) {
        // output.push(match.join(""));
        output.push([match[1].toUpperCase(), match[2]].join(""));
        match = re.exec(s);
    }

    return output;
};

// Lightweight Geo Util
window.sortByDistance = require('sort-by-distance');

window.rsbvm = {};
window.infobarvm = {};

import { VueGoodTable } from 'vue-good-table';
import 'vue-good-table/dist/vue-good-table.css';
Vue.component('vue-good-table', VueGoodTable );

import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
Vue.component('v-select', vSelect);

// Vue.use(Utilities);
import Utilities from "@pderas/vue2-utilities";
Vue.use(Utilities, {
    extendDate: true,
    extendNumber: true,
    extendString: true
});

import {AtomSpinner, SemipolarSpinner} from 'epic-spinners'
Vue.component('atom-spinner', AtomSpinner);
Vue.component('semipolar-spinner', SemipolarSpinner);

// Full Featured UI Framework
import 'bootstrap-vue/dist/bootstrap-vue.css';
// import { BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue';
// Vue.use(BootstrapVue);
import {
    ModalPlugin, CardPlugin, OverlayPlugin ,FormPlugin,TabsPlugin, FormCheckboxPlugin, CollapsePlugin,
    FormSelectPlugin, FormRadioPlugin, PopoverPlugin, DropdownPlugin, ButtonPlugin , BSpinner , BFormGroup ,BootstrapVueIcons
} from 'bootstrap-vue';
// Vue.use(BootstrapVue);
Vue.use(ModalPlugin);
Vue.use(TabsPlugin);
Vue.use(CardPlugin);
Vue.use(FormPlugin);
Vue.use(FormSelectPlugin);
Vue.use(FormCheckboxPlugin);
Vue.use(FormRadioPlugin);
Vue.use(PopoverPlugin);
Vue.use(ButtonPlugin);
Vue.use(OverlayPlugin);
Vue.use(DropdownPlugin);
Vue.use(CollapsePlugin);
Vue.use(BootstrapVueIcons);
Vue.component('b-spinner',BSpinner);
Vue.component('b-form-group',BFormGroup);

// Multi Select Component
import Multiselect from 'vue-multiselect';
Vue.component('multiselect', Multiselect);

// Lightweight HTML Editor
import Vue2Editor from "vue2-editor";
Vue.use(Vue2Editor);

import VueCodemirrorEditor from 'vue-codemirror-editor';
import 'vue-codemirror-editor/dist/vue-codemirror-editor.css';

Vue.component('vue-codemirror-editor', VueCodemirrorEditor);

import VueNestable from 'vue-nestable';
Vue.use(VueNestable);

import Vue2OrgTree from 'vue2-org-tree';
Vue.use(Vue2OrgTree);
import 'vue2-org-tree/dist/style.css';

import vueJsonEditor from 'vue-json-editor';
Vue.component('vue-json-editor',vueJsonEditor);

// QR Code diplay
import VueQrcode from '@chenfengyuan/vue-qrcode';
Vue.component('qrcode', VueQrcode);

// swiper & light box for image upload
import Lightbox from 'vue-easy-lightbox';
Vue.use(Lightbox);

import VueMarkdown from 'vue-markdown';
Vue.component('vue-markdown', VueMarkdown);


// import VueAwesomeSwiper from 'vue-awesome-swiper';
// import 'swiper/dist/css/swiper.css';
// Vue.use(VueAwesomeSwiper, /* { default global options } */);
//
// import Flickity from 'vue-flickity';
// Vue.component('flickity',Flickity);

// // full range use datepicker, date, datetime, time, daterange
// import 'vue2-datepicker/index.css';
// import DatePicker from 'vue2-datepicker';
// Vue.component('date-picker',DatePicker);
//
// import VueDatePicker from '@mathieustan/vue-datepicker';
// Vue.use(VueDatePicker);

import VueCurrencyInput from 'vue-currency-input';
Vue.use(VueCurrencyInput, {
    globalOptions: {
        precision: 2
    }
});

// Typeahead component used for Geo search
import VueBootstrapTypeahead from 'vue-bootstrap-typeahead';
Vue.component('vue-bootstrap-typeahead', VueBootstrapTypeahead);

// Kanban board
import Board from '@salamander.be/vue-kanban-board';
import '@salamander.be/vue-kanban-board/dist/vue-kanban-board.css';
Vue.component('kanban-board', Board);


// import HotelDatePicker from 'vue-hotel-datepicker';
// Vue.component('hotel-date-picker', HotelDatePicker);

// resource timeline
// import WeeklySchedule from 'vue-weekly-schedule';
// Vue.use(WeeklySchedule); // Adds 'resource-timeline' component
// Vue.component('weekly-schedule', WeeklySchedule);

//import Antd from 'ant-design-vue';
import 'ant-design-vue/dist/antd.css';
import { DatePicker, AutoComplete, Tooltip, Table, Spin, Calendar, Select, List, Timeline, Avatar, ConfigProvider } from 'ant-design-vue';
Vue.use(DatePicker);
Vue.use(AutoComplete);
Vue.use(Tooltip);
Vue.use(Table);
Vue.use(Spin);
Vue.use(Select);
Vue.use(List);
Vue.use(Timeline);
Vue.use(Calendar);
Vue.use(Avatar);
Vue.use(ConfigProvider);
Vue.config.productionTip = false;

// CSS for full screen bootstrap modal
import 'bootstrap4-fullscreen-modal/dist/bootstrap4-modal-fullscreen.css';
import 'vue-multiselect/dist/vue-multiselect.min.css';
import 'prismjs/themes/prism-tomorrow.css';

// Leaflet components
import { LMap, LTileLayer, LMarker, LCircleMarker, LIcon, LPolygon, LPolyline, LPopup, LControl } from 'vue2-leaflet';
import { Icon } from 'leaflet'
import 'leaflet/dist/leaflet.css'

Vue.component('l-map', LMap);
Vue.component('l-tile-layer', LTileLayer);
Vue.component('l-marker', LMarker);
Vue.component('l-circle-marker', LCircleMarker);
Vue.component('l-polygon', LPolygon);
Vue.component('l-polyline', LPolyline);
Vue.component('l-popup', LPopup);
Vue.component('l-control', LControl);
Vue.component('l-icon', LIcon);

delete Icon.Default.prototype._getIconUrl;
Icon.Default.mergeOptions({
    iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
    iconUrl: require('leaflet/dist/images/marker-icon.png'),
    shadowUrl: require('leaflet/dist/images/marker-shadow.png')
});

// Vue Clip vanilla uploader
import VueClip from 'vue-clip';
Vue.use(VueClip);

import {PrismEditor} from 'vue-prism-editor';
import 'vue-prism-editor/dist/prismeditor.min.css'; // import the styles

// Vue Runtime Template
import VRuntimeTemplate from "v-runtime-template";
Vue.use(VRuntimeTemplate);
Vue.component("v-runtime-template", VRuntimeTemplate);

// Drag & Sort list component
import draggable from 'vuedraggable';
Vue.component("draggable", draggable);

import { WebCam } from "vue-web-cam";
Vue.component("vue-web-cam", WebCam);

// import VueQrcodeReader from "vue-qrcode-reader";
// Vue.use(VueQrcodeReader);


import VueSignaturePad from 'vue-signature-pad';
Vue.use(VueSignaturePad);

import OtpInput from "@bachdgvn/vue-otp-input";
Vue.component("v-otp-input", OtpInput);

import CKEditor from '@ckeditor/ckeditor5-vue2';
Vue.use( CKEditor );
//window.ClassicEditor = require('@ckeditor/ckeditor5-build-classic');
// window.ClassicEditor = require('./components/editor/ckeditor5-31.1.0');

// import VueQuillEditor from 'vue-quill-editor';
//
// import 'quill/dist/quill.core.css'; // import styles
// import 'quill/dist/quill.snow.css'; // for snow theme
// import 'quill/dist/quill.bubble.css'; // for bubble theme
//
// Vue.use(VueQuillEditor, /* { default global options } */);

import Chartkick from 'vue-chartkick';
import Chart from 'chart.js';
Vue.use(Chartkick.use(Chart));

import Sparkline from "vue-sparklines/components/charts/Sparkline";
Vue.use(Sparkline);

import VueApexCharts from 'vue-apexcharts'
Vue.use(VueApexCharts)
Vue.component('apexchart', VueApexCharts)

// TODO : remove this
import vGallery from 'v-gallery';
Vue.use(vGallery);

import VueCoreVideoPlayer from 'vue-core-video-player'
Vue.use(VueCoreVideoPlayer)

import vuePlayer  from  '@algoz098/vue-player';
Vue.component('vue-player', vuePlayer);

import VueTagsInput from '@johmun/vue-tags-input';
Vue.component("vue-tags-input", VueTagsInput);

//Vue.component('map-picker', require('./components/MapPicker.vue').default);
Vue.component('map-picker-single', require('./components/MapPickerSingle.vue').default);
Vue.component('marker-popup-example', require('./components/MarkerPopupExample.vue').default);

Vue.component('image-strip', require('./components/ImageStrip.vue').default);
Vue.component('image-grid', require('./components/ImageGrid.vue').default);

Vue.component('image-grid-upload', require('./components/ImageGridUpload.vue').default);

Vue.component('multi-image-upload', require('./components/MultiImageUpload.vue').default);
Vue.component('multi-pdf-upload', require('./components/MultiPdfUpload.vue').default);

Vue.component('doc-upload', require('./components/doc/DocUpload.vue').default);
Vue.component('multi-upload-pad', require('./components/doc/MultiUploadPad.vue').default);

Vue.component('avatar-upload', require('./components/AvatarUpload.vue').default);
Vue.component('attachment-upload', require('./components/AttachmentUpload.vue').default);


Vue.component('image-card-upload', require('./components/ImageCardUpload.vue').default);
Vue.component('single-image-upload', require('./components/SingleImageUpload.vue').default);
Vue.component('single-upload', require('./components/SingleUpload.vue').default);
Vue.component('simple-table-input', require('./components/SimpleTableInput.vue').default);
Vue.component('active-view', require('./components/ActiveView.vue').default);

Vue.component('loadable-form', require('./components/LoadableForm.vue').default);
Vue.component('loadable-form-modal', require('./components/LoadableFormModal.vue').default);

Vue.component('company-selector', require('./components/CompanySelector.vue').default);
Vue.component('topic-selector', require('./components/TopicSelector.vue').default);
Vue.component('vendor-selector', require('./components/VendorSelector.vue').default);
Vue.component('requestno-selector', require('./components/RequestNoSelector.vue').default);


Vue.component('map-display', require('./components/MapDisplay.vue').default);
Vue.component('simple-table-input-modal', require('./components/SimpleTableInputModal.vue').default);
Vue.component('simple-table-input-panel', require('./components/SimpleTableInputPanel.vue').default);
Vue.component('simple-table-input-template', require('./components/SimpleTableInputTemplate.vue').default);
Vue.component('simple-table-input-modal-template', require('./components/SimpleTableInputModalTemplate.vue').default);
Vue.component('simple-sortable-list', require('./components/SimpleSortableList.vue').default);
Vue.component('active-sortable-list', require('./components/ActiveSortableList.vue').default);
Vue.component('simple-list-input', require('./components/SimpleListInput.vue').default);
Vue.component('simple-list-input-modal', require('./components/SimpleListInputModal.vue').default);
Vue.component('simple-nestable', require('./components/SimpleNestable.vue').default);
Vue.component('pop-view-modal', require('./components/PopViewModal.vue').default);
Vue.component('document-list-modal', require('./components/DocumentListModal.vue').default);

Vue.component('approval-time-line', require('./components/ApprovalTimeLine.vue').default);

Vue.component('file-attachment-list', require('./components/FileAttachmentList.vue').default);

Vue.component('button-modal-sign-pad', require('./components/ButtonModalSignPad.vue').default);
Vue.component('button-modal-user-select', require('./components/ButtonModalUserSelect.vue').default);

Vue.component('button-modal-ajax', require('./components/ButtonModalAjax.vue').default);
Vue.component('button-modal-pin-ajax', require('./components/ButtonModalPinAjax.vue').default);
Vue.component('upload-dialog', require('./components/UploadDialog.vue').default);
Vue.component('upload-xls-dialog', require('./components/UploadXlsDialog.vue').default);
Vue.component('form-question-dialog', require('./components/FormQuestionDialog.vue').default);

Vue.component('pdf-view', require('./components/PdfView.vue').default);
Vue.component('pdf-light-box', require('./components/PdfLightBox.vue').default);
Vue.component('pdf-view-dialog', require('./components/PdfViewDialog.vue').default);

Vue.component('remote-select', require('./components/RemoteSelect.vue').default);
Vue.component('local-select', require('./components/LocalSelect.vue').default);
Vue.component('local-search-select', require('./components/LocalSearchSelect.vue').default);

Vue.component('user-selector', require('./components/UserSelector.vue').default);
Vue.component('user-selector-list', require('./components/UserSelectorList.vue').default);

Vue.component('chain-select', require('./components/ChainSelect.vue').default);
Vue.component('live-table', require('./components/LiveTable.vue').default);

Vue.component('place-auto-search', require('./components/PlaceAutoSearch.vue').default);
Vue.component('trip-route-picker', require('./components/TripRoutePicker.vue').default);
Vue.component('scanner-input', require('./components/ScannerInput.vue').default);

Vue.component('active-form', require('./components/ActiveForm.vue').default);

Vue.component('tags-input', require('./components/TagsInput.vue').default);
Vue.component('pin-input', require('./components/PinInput.vue').default);

Vue.component('org-tree', require('./components/OrgTree.vue').default);
Vue.component('json-editor', require('./components/JsonEditor.vue').default);
//Vue.component('drag-tree', require('./components/DragTree.vue').default);

Vue.component('print-element', require('./components/PrintElement.vue').default);
Vue.component('sign-pad', require('./components/SignPad.vue').default);
Vue.component('photo-cam', require('./components/PhotoCam.vue').default);

Vue.component('import-data', require('./components/ImportData.vue').default);

Vue.component('simple-table', require('./components/SimpleTable.vue').default);

Vue.component('simple-switch', require('./components/SimpleSwitch.vue').default);

Vue.component('tab', require('./components/Tab.vue').default);

Vue.component('active-check-list', require('./components/ActiveCheckList.vue').default);

Vue.component('invoice-items', require('./components/fa/InvoiceItems.vue').default);

Vue.component('async-select', require('./components/AsyncSelect.vue').default);

Vue.component('async-simple-select', require('./components/AsyncSimpleSelect.vue').default);
Vue.component('remote-auto-select', require('./components/RemoteAutoSelect.vue').default);

Vue.component('template-selector', require('./components/TemplateSelector.vue').default);

import VueGeolocation from 'vue-browser-geolocation';
Vue.use(VueGeolocation);

import pdf from 'vue-pdf';
Vue.component("pdf", pdf);

import ToggleButton from 'vue-js-toggle-button'
Vue.use(ToggleButton)

// Vue HTML to Paper for printing
import VueHtmlToPaper from 'vue-html-to-paper';

const options = {
    name: '_blank',
    specs: [
        'fullscreen=yes',
        'titlebar=yes',
        'scrollbars=yes'
    ],
    styles: [
        'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
        'https://unpkg.com/kidlat-css/css/kidlat.css'
    ]
};

Vue.use(VueHtmlToPaper, options);

import * as VeeValidate from 'vee-validate';
// import { ValidationProvider } from 'vee-validate';
import {
    ValidationObserver,
    ValidationProvider
} from 'vee-validate/dist/vee-validate.full';
//Vue.use(VeeValidate);
Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);

import VueLocalStorage from 'vue-localstorage';
Vue.use(VueLocalStorage);

