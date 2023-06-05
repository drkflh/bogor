<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('SITE_NAME','') }} - {{ env('SITE_TITLE') }}</title>
    <!-- core:css -->
    <link rel="stylesheet" href="{{ url('themes/nobleui') }}/assets/vendors/core/core.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- end plugin css for this page -->
    <!-- inject:css -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@100;200&family=Merriweather+Sans:wght@300&family=Nunito+Sans:wght@200&family=Overpass:wght@100&display=swap');
        /*@import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@100;200&family=Merriweather+Sans:wght@300&family=Overpass:wght@100&display=swap');*/
        /*@import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@100;200&family=Overpass:wght@100&display=swap');*/
        /*@import url('https://fonts.googleapis.com/css2?family=Overpass:wght@100&family=Cabin:ital,wght@0,400;0,600;0,700;1,400;1,500&family=Lato:wght@100;300;400;700&family=Merriweather+Sans:ital,wght@0,300;0,400;0,600;0,700;1,300&family=Nunito:ital,wght@0,200;0,300;0,400;0,700;1,400&family=Raleway:ital,wght@0,100;0,300;0,400;1,100&display=swap');*/
    </style>
    <link href="{{ url('themes/dashforge') }}/lib/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    {{--<link rel="stylesheet" href="{{ url('themes/nobleui') }}/assets/fonts/feather-font/css/iconfont.css">--}}
    <link rel="stylesheet" href="{{ url('themes/nobleui') }}/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <!-- endinject -->
    {{-- icon line --}}
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ url('themes/nobleui') }}/assets/css/demo_1/style.css">

    <link rel="stylesheet" href="{{ url(  env('APP_CSS', 'css/parama.css')  ) }}">
    <!-- Theme CSS overrides -->
    <link rel="stylesheet" href="{{ url('/') }}/css/noble.css">

    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ url(env('APP_FAVICON', 'favicon.ico')) }}" />

    <script>window.Laravel = {csrfToken: '{{ csrf_token() }}'}</script>

    <script src="{{ url(mix('js/manifest.js')) }}"></script>
    <script src="{{ url(mix('js/vendor.js')) }}"></script>
    <script src="{{ url(mix('js/app.js')) }}"></script>

    @yield('js')

    <style>
        .dropdown .dropdown-menu .dropdown-item, .btn-group .dropdown-menu .dropdown-item, .fc .fc-toolbar.fc-header-toolbar .fc-left .fc-button-group .dropdown-menu .dropdown-item, .fc .fc-toolbar.fc-header-toolbar .fc-right .fc-button-group .dropdown-menu .dropdown-item {
            font-size: 10pt !important;
            padding: .25rem .875rem;
            transition: all .2s ease-in-out;
            border-radius: 2px;
        }
        .dropdown .dropdown-menu .dropdown-item, .btn-group .dropdown-menu .dropdown-item svg {
            height: 18px !important;
            font-size: 10pt !important;
        }

        .dropdown .dropdown-menu .dropdown-item, .btn-group .dropdown-menu .dropdown-item a {
            height: 34px !important;
            font-size: 10pt !important;
        }

        .custom-select {
            /* background: none !important; */
            -moz-appearance:none; /* Firefox */
            -webkit-appearance:none; /* Safari and Chrome */
            appearance:none;
        }

        body{
            font-size: 11pt !important;
        }
        .scroll-dashboard {
            margin-top: 20px;
            height: 500px;
            overflow-y: scroll; /* Add the ability to scroll */
            }

        .scroll-dashboard::-webkit-scrollbar {
            display: none;
        }

        #notificationDropdown a:hover div.icon{
            background-color: red !important;
        }
    </style>

{{--    @if( $with_timetracking|| $with_attendance)--}}
    <script>
        $(document).ready(function(){
            bus.$emit('loadPageData');
            var navvm = new Vue({
                mounted(){
                    this.getState();
                    this.getNotifications();
                    this.doStartNotifTimer();
                },
                name: 'Top Nav',
                data: function(){
                    return {
                        tz : window.tz,
                        attStatus: 'OUT',
                        clockIn: false,
                        clockOut: true,
                        atBreak: false,
                        attendanceSession: '',
                        breakSession: '',
                        timetrackSession: '',
                        clockInTime: moment.tz( window.tz ),
                        clockOutTime: moment.tz( window.tz ),
                        timerVal: moment.tz( window.tz ),
                        timerSec: 0,
                        timer: null,
                        timerRunning: false,
                        savingData: false,
                        notifTimer: null,
                        notifications: [],
                        projectTask: 'General',
                        projectFilter: 'General',
                        title: '',
                        description: '',
                        issueHandle:{!! json_encode(\App\Helpers\Util::randomstring(5, 'alpha') ) !!},
                        projectTaskList: {!! json_encode(\App\Helpers\WorkflowUtil::getProjectTasks() ) !!},
                        projectFilterOptions: {!! json_encode(\App\Helpers\WorkflowUtil::getProjectNameQuickTask() ) !!},
                        issueTaskOptions: {!! json_encode(\App\Helpers\WorkflowUtil::getIssueTaskOptions() ) !!},
                        issueStatusOptions: {!! json_encode(config('util.task_progress_status_list')) !!},
                        issueAttachmentsObjects: [],
                        issueAttachments: [],
                        issueTask: '',
                        issueStatus: '',
                    };
                },
                watch: {
                    attStatus: function (val){
                        @if($with_attendance)
                        if(val == 'OUT'){
                            this.openAttendanceModal();
                        }else{
                            this.closeAttendanceModal();
                        }
                        @endif

                    }
                },
                methods:{
                    formatTime(dt) {
                        return moment(dt).tz(this.tz).locale('en').format('HH:mm:ss');
                    },
                    formatDateTime(dt){
                        return moment(dt).tz(this.tz).locale('en').format('DD MMM YYYY HH:mm:ss');
                    },
                    refreshPage(){
                        bus.$emit('refreshPage', {});
                    },
                    openAddTask(){
                        this.$bvModal.show('addQuickTaskModal');
                    },
                    openIssueReport(){
                        this.$bvModal.show('addIssueModal');
                    },
                    openAttendanceModal(){
                        this.$bvModal.show('attendanceModal');
                    },
                    closeAttendanceModal(){
                        this.$bvModal.hide('attendanceModal');
                    },
                    addAttachmentClick(payload){
                        console.log('add issue payload', payload);
                        bus.$emit('openlightbox', payload);
                    },
                    doStartNotifTimer(){
                        this.notifTimer = setInterval( () => {
                            this.getNotifications();
                        }, (10000) );
                    },
                    doStartTimer(){
                        this.timerRunning = !this.timerRunning;
                        this.timetrackSession = this.generateRandomString(10);
                        this.timerVal = moment().tz(this.tz);
                    },
                    getAttendanceTitle(){
                        if(this.attStatus == 'OUT' ){
                            return "Let's Start !";
                        }
                        if(this.attStatus == 'IN' ){
                            return 'Call it a day or just take a break';
                        }
                        if(this.attStatus == 'BREAK' ){
                            return "Get Back to Work" ;
                        }
                    },
                    doClockIn(){
                        if(this.clockOut){
                            this.attStatus = 'IN';
                            this.clockIn = true;
                            this.clockOut = false;
                            this.clockInTime = moment().tz(this.tz);
                            this.attendanceSession = this.generateRandomString(10);
                            this.logTime('CLOCK_IN');
                            this.closeAttendanceModal();
                        }
                    },
                    doClockOut(){
                        if(this.clockIn){
                            this.atBreak = false;
                            this.attStatus = 'OUT';
                            this.clockIn = false;
                            this.clockOut = true;
                            this.clockOutTime = moment().tz(this.tz);
                            this.logTime('CLOCK_OUT');

                            //stop any running timer
                            if( !_.isNull(this.timer) && this.timerRunning ){
                                clearInterval(this.timer);
                                this.timerRunning = false;
                                this.logTime('TIMER_STOP');
                                this.timerSec = 0;
                            }

                            this.openAttendanceModal();

                        }
                    },
                    doBreakStart(){
                        if(this.clockIn){
                            this.atBreak = !this.atBreak;
                            if(this.atBreak){
                                this.attStatus = 'BREAK';
                                this.clockOutTime = moment().tz(this.tz);
                                this.breakStart = moment().tz(this.tz);
                                this.breakSession = this.generateRandomString(10);
                                this.logTime('START_BREAK');

                                if( !_.isNull(this.timer) && this.timerRunning ){
                                    clearInterval(this.timer);
                                    this.timerRunning = false;
                                    this.logTime('TIMER_STOP');
                                    this.timerSec = 0;
                                }

                                this.openAttendanceModal();

                            }else{
                                this.attStatus = this.clockIn ? 'IN': 'OUT';
                                this.clockInTime = moment().tz(this.tz);
                                this.breakStop = moment().tz(this.tz);
                                this.logTime('STOP_BREAK');

                                this.closeAttendanceModal();

                            }
                        }
                    },
                    doBreakEnd(){
                        if(this.clockIn){
                            this.atBreak = false;
                            this.attStatus = 'IN';
                            this.closeAttendanceModal();
                        }
                    },
                    toggleTimer() {
                        if(this.clockIn){
                            if(this.timerRunning == true){
                                let r = confirm('Stop Work Timer ?');
                                if (r == true) {
                                    clearInterval(this.timer);
                                    this.timerRunning = false;
                                    this.timerStop = moment().tz(this.tz);
                                    this.logTime('TIMER_STOP');
                                    this.timerSec = 0;
                                }
                            }else{
                                this.timerRunning = true;
                                this.timer = setInterval( () => {
                                    this.timerSec++;
                                    this.timerVal = moment().tz(this.tz);
                                    console.log(this.timerSec);
                                }, 1000 );
                                this.timetrackSession = this.generateRandomString(10);
                                this.timerStart = moment().tz(this.tz);
                                this.logTime('TIMER_START');
                            }
                        }
                    },
                    startTimerNoSave(){
                        this.timer = setInterval( () => {
                            this.timerSec++;
                            this.timerVal = moment().tz(this.tz);
                            console.log(this.timerSec);
                        }, 1000 );
                    },
                    getState(){
                        var opt = {};

                        this.savingData = true;

                        axios.post('{{ url('time/log-state') }}', opt).then(
                            (response)=>{
                                if(response.data.result == 'OK'){
                                    this.attStatus = response.data.data.attStatus;
                                    this.clockIn = response.data.data.clockIn;
                                    this.clockOut = response.data.data.clockOut;
                                    this.atBreak = response.data.data.atBreak;
                                    this.clockInTime = response.data.data.clockInTime ;
                                    this.clockOutTime = response.data.data.clockOutTime;
                                    this.timerVal = response.data.data.timerVal;
                                    this.timerStart = response.data.data.timerStart;
                                    this.timerStop = response.data.data.timerStop;
                                    this.timerSec = response.data.data.timerSec;
                                    this.timerRunning = response.data.data.timerRunning;
                                    this.attendanceSession = response.data.data.attendanceSession;
                                    this.timetrackSession = response.data.data.timetrackSession;
                                    this.breakSession = response.data.data.breakSession;

                                    if(this.timerRunning){
                                        this.startTimerNoSave();
                                        this.closeAttendanceModal();
                                    }

                                }
                                this.savingData = false;
                            }
                        ).catch((error)=>{
                            this.savingData = false;
                            if(error.response.status == 401){
                                var d = new Date();
                                alert('Your session is expired. Please re-login');
                                window.location.href = '{{ url('login') }}?' + d.getTime() ;
                            }
                        })
                    },
                    getNotifications(){
                        axios.post( '{{ url('mms/notif/list') }}' , {} )
                            .then(response => {
                                console.log(response.data);
                                if(response.data.result == 'OK'){
                                    this.notifications = response.data.data;
                                }
                            })
                            .catch(function(error) {
                                console.log(error);
                                if(error.response.status == 401){
                                    var d = new Date();
                                    alert('Your session is expired. Please re-login');
                                    window.location.href = '{{ url('login') }}?' + d.getTime() ;
                                }
                            });
                    },
                    clearNotification(){
                        axios.post( '{{ url('mms/notif/clear') }}' ,
                            {
                                notifications : this.notifications
                            }
                        )
                            .then(response => {
                                console.log(response.data);
                                if(response.data.result == 'OK'){
                                    this.notifications = response.data.data;
                                }
                            })
                            .catch(function(error) {
                                console.log(error);
                                if(error.response.status == 401){
                                    var d = new Date();
                                    alert('Your session is expired. Please re-login');
                                    window.location.href = '{{ url('login') }}?' + d.getTime() ;
                                }
                            });
                    },
                    shownQuickTaskModal(event){

                    },
                    commitRevision(event){

                    },
                    doQuickTaskList(event){
                        event.preventDefault();
                        navvm.$refs.quickTaskForm.validate()
                        .then((valid) => {
                            console.log('valid', valid)
                            if(valid) {
                                var task = {
                                    taskName: this.title,
                                    taskDescription: this.description,
                                    projectName:this.projectFilter,
                                    progressStatus:'OPEN',
                                    approvalStatus: 'PENDING',
                                };

                                axios.post( '{{ url('workflow/time/task-list/quickadd') }}' , task )
                                .then(response => {
                                    console.log(response.data);
                                    if(response.data.result == 'OK'){
                                        this.$bvModal.hide('addQuickTaskModal');
                                        this.title = null;
                                        this.description = null;
                                        this.projectFilter = 'General';
                                        bus.$emit('refreshTable');
                                    }
                                })
                                .catch(function(error) {
                                    console.log(error);
                                    if(error.response.status == 401){
                                        var d = new Date();
                                        alert('Your session is expired. Please re-login');
                                        window.location.href = '{{ url('login') }}?' + d.getTime() ;
                                    }
                                });
                            }
                        })
                        .catch((error) => {})
                    },
                    doAddIssue(event){
                        event.preventDefault();
                        navvm.$refs.addIssueForm.validate()
                        .then((valid) => {
                            console.log('valid', valid)
                            if(valid) {
                                var issue = {
                                    title: this.title,
                                    issueStatus: this.issueStatus,
                                    issueAttachments: this.issueAttachments,
                                    issueAttachmentsObjects: this.issueAttachmentsObjects,
                                    issueHandle: this.issueHandle,
                                    taskName: this.issueTask,
                                    projectName: 'General',
                                    taskId: 'General',
                                    projectId: 'General',
                                    description: this.description
                                };
                                axios.post( '{{ url('central/project/add-issue') }}' , issue )
                                .then(response => {
                                    console.log(response.data);
                                    if(response.data.result == 'OK'){
                                        this.$bvModal.hide('addIssueModal');
                                        this.title = null;
                                        this.issueStatus = null;
                                        this.issueAttachments = null;
                                        this.issueAttachmentsObjects = null;
                                        this.description = null;
                                        this.issueTask = null;
                                        this.projectName = null;
                                        this.taskId = null;
                                        this.projectId = null;
                                        this.issueHandle = {!! json_encode(\App\Helpers\Util::randomstring(5, 'alpha') ) !!};
                                        bus.$emit('refreshTable');
                                    }
                                    if(response.data.result == 'ERR'){
                                        alert(response.data.message);
                                    }
                                    navvm.$refs.add_veeObserver.reset();
                                })
                                .catch(function(error) {
                                    console.log(error);
                                    if(error.response.status == 401){
                                        var d = new Date();
                                        alert('Your session is expired. Please re-login');
                                        window.location.href = '{{ url('login') }}?' + d.getTime() ;
                                    }
                                });
                            }
                        })
                        .catch((error) => {})

                    },
                    generateRandomString(length=6){
                        return Math.random().toString(20).substr(2, length);
                    },
                    doLogout(event){
                        axios.post('{{ url('logout') }}', {})
                            .then(
                                (response)=>{
                                    window.location.href = '{{ url('login') }}' ;
                                }
                            ).catch((error)=>{
                                this.savingData = false;
                                console.log('logged out');
                                location.href = '{{ url('login') }}' ;
                                window.location.href = '{{ url('login') }}' ;
                            });
                    },
                    logTime(evt){
                        var tl = {
                            tz: this.tz,
                            event: evt,
                            attStatus : this.attStatus,
                            clockIn : this.clockIn,
                            clockOut : this.clockOut,
                            clockInTime : this.formatDateTime(this.clockInTime) ,
                            clockOutTime : this.formatDateTime(this.clockOutTime),
                            attendanceSession : this.attendanceSession,
                            breakStart : this.breakStart,
                            breakStop : this.breakStop,
                            atBreak : this.atBreak,
                            breakSession : this.breakSession,
                            timetrackSession : this.timetrackSession,
                            timerVal : this.formatDateTime(this.timerVal),
                            timerStart : this.formatDateTime(this.timerStart),
                            timerStop : this.formatDateTime(this.timerStop),
                            timerSec : this.timerSec,
                            timerRunning : this.timerRunning,
                            projectTask : this.projectTask
                        };
                        this.savingData = true;

                        axios.post('{{ url('time/log') }}', tl)
                            .then(
                                (response)=>{
                                    if(response.data.result == 'OK'){
                                        bus.$emit('refreshTable');
                                    }
                                    this.savingData = false;
                                }
                            ).catch((error)=>{
                                this.savingData = false;
                                if(error.response.status == 401){
                                    var d = new Date();
                                    alert('Your session is expired. Please re-login');
                                    window.location.href = '{{ url('login') }}?' + d.getTime() ;
                                }
                            })
                    }
                }
            }).$mount('#nav-app');

        });
    </script>
{{--    @endif--}}
</head>
<body onload="spinner()" class="{{ env('SIDEBAR_DEFAULT_OPEN')?'':'sidebar-folded' }} {{ ( env('NOBLE_OPT_THEME','dark') == 'dark' )?'sidebar-dark':'' }}" >
<div class="main-wrapper">

    <!-- partial:partials/_sidebar.html -->
    <nav class="sidebar">
        <div class="sidebar-header" {!!  ( env('NOBLE_OPT_THEME','dark') == 'hybrid' )?'style="background-color: '.env('NOBLE_OPT_COLOR','black').' ;color: white;"':'' !!} >
            <a href="{{ url('/') }}" class="sidebar-brand">
                <img src="{{ url( env('APP_LOGO_SMALL') ) }}" alt="" height="35">
                @if(env('LOGO_TEXT', false ))
                    <span class="sidebar-brand" style="font-size: 15pt;font-weight: bold;">{{ env('SITE_TITLE') }}</span>
                @endif
            </a>
            <div class="sidebar-toggler not-active">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <div class="sidebar-body">
            @if( View::exists('partials.nav.nobleui.nav') )
                @include('partials.nav.nobleui.nav')
            @endif
        </div>
    </nav>
    <!-- partial -->

    <div class="page-wrapper">

        <!-- partial:partials/_navbar.html -->
        <nav class="navbar">
            <a href="#" class="sidebar-toggler">
                <i data-feather="menu"></i>
            </a>
            <div class="navbar-content" id="nav-app">
                <div class="row d-flex justify-content-between align-items-center flex-wrap grid-margin mr-2">
                    <h4 class="d-none d-sm-block mb-3 mb-md-0 mt-10" style="margin-top:16px;">{!! $title ?? env('SITE_TITLE') !!}</h4>
                    <h5 class="d-block d-sm-none my-4">{!! $title ?? env('SITE_TITLE') !!}</h5>
                </div>
                @if($with_timetracking)
                <b-modal id="addQuickTaskModal"
                         no-close-on-backdrop
                         no-close-on-esc
                         @ok="doQuickTaskList"
                         size="md"
                         centered
                         scrollable
                         @shown="shownQuickTaskModal"
                         title="Add Task"
                         modal-class="modal-bv">
                    <div class="row">
                        <div class="col-12" id="quickTaskForm">
                            <validation-observer v-slot="{ invalid }" ref="quickTaskForm">
                                <validation-provider rules="required" v-slot="{ errors }" name="title">
                                    {!! Former::text('title', 'Title')->v_model('title') !!}
                                    <div style="color: rgba(189, 61, 61, 0.839)">@{{ errors[0] }}</div>
                                </validation-provider>
                                <validation-provider rules="required" v-slot="{ errors }" name="description">
                                    {!! Former::text('description', 'Description')->v_model('description') !!}
                                    <div style="color: rgba(189, 61, 61, 0.839)">@{{ errors[0] }}</div>
                                </validation-provider>
                                <label for="projectFilter" class="mr-3">Project</label>
                                <b-form-select
                                    name="projectFilter"
                                    v-model="projectFilter"
                                    :options="projectFilterOptions"
                                ></b-form-select>
                            </validation-observer>
                        </div>
                    </div>
                </b-modal>
                @endif

                @if($with_attendance)
                <b-modal id="attendanceModal"
                         no-close-on-backdrop
                         no-close-on-esc
                         @ok.prevent="doLogout"
                         ok-title="Logout"
                         hide-header-close
                         :cancel-disabled="(attStatus == 'OUT' || attStatus == 'BREAK')"
                         :ok-only="(attStatus == 'OUT' || attStatus == 'BREAK')"
                         cancel-variant="light"
                         size="sm"
                         centered
                         scrollable
                         :visible="(attStatus == 'OUT' || attStatus == 'BREAK')"
                         @shown="shownQuickTaskModal"
                         :title="getAttendanceTitle()"
                         modal-class="modal-bv">
                    <div class="row">
                        <div class="col-12 d-flex align-items-center justify-content-around " id="attendanceForm">
                            <button @click="doClockIn()"
                                    :disabled="attStatus != 'OUT'"
                                    class="btn h-100 p-1 flex-wrap wd-30" :class="attStatus == 'OUT' ? 'btn-primary':'btn-outline-secondary' " :class="attStatus != 'OUT' ? 'disabled':''"
                                    style="width:70px;font-size: 14pt;text-align: center;">
                                <i class="las la-business-time mb-1" style="font-size: 18pt;"></i> IN
                            </button>
                            <button @click="doBreakStart()"
                                    :disabled="attStatus == 'OUT'"
                                    class="btn btn-outline-secondary h-100 p-1 flex-wrap d-flex justify-content-center" :class="attStatus == 'OUT' ? 'disabled':''"
                                    style="width:70px;font-size: 12pt;text-align: center;">
                                <i class="las la-coffee mb-1" style="font-size: 15pt;"></i><br>
                                @{{ atBreak ? 'RESUME': 'BREAK' }}
                            </button>
                            <button @click="doClockOut()"
                                    :disabled="attStatus == 'OUT'"
                                    class="btn btn-outline-secondary h-100 p-1 flex-wrap" :class="attStatus == 'OUT' ? 'disabled':''"
                                    style="width:70px;font-size: 12pt;text-align: center;">
                                <i class="las la-sign-out-alt mb-1" style="font-size: 18pt;"></i> OUT
                            </button>
                        </div>
                    </div>
                </b-modal>
                @endif

                @if(env('WITH_ISSUE_TRACKING', true) == true)
                    <b-modal
                        id="addIssueModal"
                        @ok="doAddIssue"
                        ok-title="Save"
                        title="Add Issue"
                        scrollable
                        centered
                        :hide-backdrop="false"
                        size="lg"
                    >
                        <div >
                            <validation-observer v-slot="{ invalid }" ref="addIssueForm">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="issueTask" class="mr-3">Task Name</label>
                                        <validation-provider rules="required" v-slot="{ errors }" name="issueTask">
                                        <b-form-select
                                            name="issueTask"
                                            v-model="issueTask"
                                            :options="issueTaskOptions"
                                        ></b-form-select>
                                    </div>
                                    </validation-provider>
                                    <div class="col-6">
                                        <p>Status</p>
                                            <b-form-select
                                            name="issuestatus"
                                            v-model="issueStatus"
                                            :options="issueStatusOptions"
                                        ></b-form-select>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-6">
                                            <validation-provider rules="required" v-slot="{ errors }" name="title">
                                                {!! Former::text('title', 'Title')->v_model('title') !!}
                                                <div style="color: rgba(189, 61, 61, 0.839)">@{{ errors[0] }}</div>
                                            </validation-provider>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <label for="description" >Issue Description</label>
                                        <validation-provider rules="required" v-slot="{ errors }" name="description">
                                            <b-tabs content-class="mt-3">
                                                <b-tab title="Source" active>
                                                    <textarea
                                                        style="min-height:400px;height:400px;"
                                                        name="description"
                                                        v-model="description"
                                                        placeholder="Issue description"
                                                        class="form-control"
                                                    >
                                                    </textarea>
                                                </b-tab>
                                                <b-tab title="Preview">
                                                    <vue-markdown
                                                        style="min-height: 400px;"
                                                        :source="description"
                                                    ></vue-markdown>
                                                </b-tab>
                                            </b-tabs>
                                            <div style="color: rgba(189, 61, 61, 0.839)">@{{ errors[0] }}</div>
                                        </validation-provider>
                                    </div>
                                    <div class="col-6">
                                        <p>Attachments</p>

                                    <attachment-upload
                                        v-model="issueAttachments"
                                        :file-objects.sync="issueAttachmentsObjects"
                                        label="Attachments"
                                        label-for="issueAttachments"
                                        :handle="issueHandle"
                                        :direct-view-action="true"
                                        @onAttachmentItemClick="addAttachmentClick"
                                        ns="issueAttachments"
                                        uploadurl="{{ url( 'api/v1/core/upload' )  }}"
                                        mode="multi"
                                        defaulturl="{{ url( 'images/types/document.png' )  }}"
                                        buttonlabel="Click or drop to upload"
                                        >
                                    </attachment-upload>
                                    </div>
                                </div>
                            </validation-observer>
                        </div>
                    </b-modal>
                @endif

                <ul class="navbar-nav" >
                @if($with_timetracking)
                    <li class="nav-item nav-apps" style="text-align:right;">
                        <b-spinner v-if="savingData" small class="mr-2" ></b-spinner>
                        <span v-show="timerRunning" style="margin-right: 10px;"><i v-if="timerRunning" class="far fa-hourglass mr-1"></i> @{{ timerRunning ? formatDateTime( timerVal ): '' }}</span>
                        <b-form-select
                            v-show="clockIn && !timerRunning"
                            :disabled="timerRunning"
                            v-model="projectTask" :options="projectTaskList"></b-form-select>
                    </li>
                    <li class="nav-item nav-apps" style="text-align:right;">
                        <button v-show="clockIn" @click="openAddTask()"
                                class="btn btn-outline-info mr-2"
                        >
                            <i class="far fa-1_5x fa-plus-square mr-1"></i> Task
                        </button>
                    </li>
                    <li class="nav-item nav-apps" style="text-align:right;">
                        <button v-show="clockIn" @click="toggleTimer()"
                                :class="timerRunning ? 'btn btn-danger' : 'btn btn-outline-info'"
                                class="mr-2"
                        >
                            <i :class="timerRunning ? 'far fa-1_5x fa-stop-circle':'far fa-1_5x fa-play-circle'" class="mr-1" ></i> @{{ timerRunning ? 'Stop':'Start' }}
                        </button>
                    </li>

                @endif

                @if($with_attendance)
                    <li class="nav-item nav-apps" style="text-align:right;">
                        <span style="text-align:right;" ><b>@{{ attStatus }}</b> @{{ attStatus == 'IN' ? formatDateTime(clockInTime) : '' }}</span>
                    </li>
                    <li class="nav-item nav-apps">
                        <button
                                @click="openAttendanceModal()"
                                class="btn btn-icon mr-2"
                        >
                            <i style="font-size: 14pt;" class="las la-clock"></i>
                        </button>
{{--                        <a class="nav-link dropdown-toggle" href="#" id="appsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                            <i data-feather="clock"></i>--}}
{{--                        </a>--}}
{{--                        <div class="dropdown-menu" aria-labelledby="appsDropdown" style="min-width: 280px;" >--}}
{{--                            <div class="dropdown-header d-flex align-items-center justify-content-between">--}}
{{--                                <p style="text-align:right;width:100%;margin-bottom:0px;">--}}
{{--                                    {{ date('D, d M Y', time()) }}--}}
{{--                                </p>--}}
{{--                            </div>--}}
{{--                            <div class="dropdown-body p-1">--}}
{{--                                <div style="display: table; width: 100%;">--}}
{{--                                    <div style="display: table-cell; text-align: center;">--}}
{{--                                        <button @click="doClockIn()" class="btn btn-outline-secondary" :class="clockIn ? 'disabled':''" style="width:70px;">--}}
{{--                                            <i class="far fa-3x fa-clock"></i><br>IN--}}
{{--                                        </button>--}}
{{--                                    </div>--}}
{{--                                    <div style="display: table-cell; text-align: center;">--}}
{{--                                        <button @click="doBreakStart()" class="btn btn-outline-secondary" :class="clockOut ? 'disabled':''" >--}}
{{--                                            <i class="far fa-3x fa-clock"></i><br> @{{ atBreak ? 'RESUME': 'BREAK' }}--}}
{{--                                        </button>--}}
{{--                                    </div>--}}
{{--                                    <div style="display: table-cell; text-align: center;"  style="width:70px;">--}}
{{--                                        <button @click="doClockOut()" class="btn btn-outline-secondary" :class="clockOut ? 'disabled':''" >--}}
{{--                                            <i class="far fa-3x fa-clock"></i><br>OUT--}}
{{--                                        </button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </li>
                @endif

                @if(env('WITH_ISSUE_TRACKING', true))
                    <li class="nav-item nav-apps" style="text-align:right;">
                        <button @click="openIssueReport()"
                                class="btn btn-outline-danger mr-2"
                                style="font-weight: normal;"
                        >
                            <i class="far fa-flag"></i> Report Issue
                        </button>
                    </li>
                @endif

{{--                @if(env('WITH_APP_SUITE', false))--}}
{{--                    <li class="nav-item dropdown nav-apps">--}}
{{--                        <a class="nav-link dropdown-toggle" href="#" id="appsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                            <i data-feather="grid"></i>--}}
{{--                        </a>--}}
{{--                        <div class="dropdown-menu" aria-labelledby="appsDropdown" style="min-width: 280px;" >--}}
{{--                            <div class="dropdown-header d-flex align-items-center justify-content-between">--}}
{{--                                <p class="mb-0 font-weight-medium">{{ env('SITE_NAME') }}</p>--}}
{{--                                <a href="javascript:;" class="text-muted">Edit</a>--}}
{{--                            </div>--}}
{{--                            <div class="dropdown-body">--}}
{{--                                <div class="align-items-center apps">--}}
{{--                                    @foreach( config('app.suite.appList') as $apps )--}}
{{--                                        <a href="{{ url($apps['url']) }}">{!! $apps['icon'] !!}</i><p>{{ $apps['name'] }}</p></a>--}}
{{--                                    @endforeach--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="dropdown-footer d-flex align-items-center justify-content-center">--}}
{{--                                <a href="javascript:;">View all</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </li>--}}
{{--                @endif--}}

                @if(env('WITH_TIMEZONE', false))
                    <li class="nav-item dropdown" id="tzContainer">
                        <form method="get" action="{!! url()->full() !!}" >
                            <select name="tz" class="form-data custom-select" onchange="this.form.submit()">
                                @foreach( config('util.timezones') as $k=>$v )
                                    <option value="{{ $k }}" {{ $k == $tz ?'selected':'' }} >{{ $v }}</option>
                                @endforeach
                            </select>
                        </form>
                    </li>
                @endif
                @if(env('WITH_MULTI_LANG', false))
                    <li class="nav-item dropdown" id="langContainer">
                        <form method="get" action="{!! url()->full() !!}" >
                            <select name="lang" class="form-data custom-select" onchange="this.form.submit()">
                                @foreach( config('util.languages') as $k=>$v )
                                    <option value="{{ $k }}" {{ $k == $lang ?'selected':'' }} >{{ $v }}</option>
                                @endforeach
                            </select>
                        </form>
                    </li>
                @endif
                    @if($page_refresh_button)
                        <li class="nav-item">
                            <button class="btn btn-lg btn-icon" @click="refreshPage()">
                                <i class="las la-sync"></i>
                            </button>
                        </li>
                    @endif

                    <li class="nav-item dropdown nav-notifications">
                        <a class="nav-link dropdown-toggle mr-1" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i style="font-size: 20pt;" class="las la-inbox mt-1"></i>
                            <div v-if="_.isArray(notifications) && notifications.length > 0" class="indicator">
                                <div class="circle mt-1"></div>
                            </div>
                        </a>
                        <div v-show="_.isArray(notifications) && notifications.length > 0" class="dropdown-menu" aria-labelledby="notificationDropdown">
{{--                            <div class="dropdown-header d-flex align-items-center justify-content-between">--}}
{{--                                <p class="mb-0 font-weight-medium">6 New Notifications</p>--}}
{{--                                <a href="javascript:;" class="text-muted">Clear all</a>--}}
{{--                            </div>--}}
                            <div class="dropdown-body" style="max-height:300px;overflow-y: auto;" >
                                <a v-for="msg in notifications" :href="msg.data.url" class="dropdown-item mt-2 mb-2 p-2">
                                    <div class="icon text-center" style="background-color: transparent !important;">
                                        <i class="las la-envelope" style="margin: 0px;"></i>
                                    </div>
                                    <div class="content">
                                        <p class="ellipsis" style="width:200px;font-size:9pt;" v-if="!_.isNull(msg.data)">@{{ msg.data.req ?? '' }} {{__('dari')}} @{{ msg.data.ownerName ?? '' }}</p>
                                        <p class="ellipsis" style="width:200px;font-size:8pt;" class="sub-text text-muted" v-if="!_.isNull(msg.data)" v-html="msg.data.subject" ></p>
                                    </div>
                                </a>
                            </div>
                            <div class="dropdown-footer d-flex align-items-center justify-content-center">
                                <span @click="clearNotification" style="cursor: pointer;" >Clear</span>
                            </div>
                        </div>
                    </li>


                    <li class="nav-item dropdown nav-profile">
                        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if(Auth::check() && isset(Auth::user()->name))
                                <span class="mr-1 d-none d-md-inline-block">{{ Auth::user()->name }}</span>
                            @endif
                            <i data-feather="user" ></i>
                            {{--@if(Auth::check())--}}
                                {{--<img style="width: 30px;height: 30px;" src="{{ (isset(Auth::user()->avatar))?\App\Helpers\AuthUtil::getAvatar( Auth::user()->avatar, url('images/coffee.png') )  : url('images/coffee.png') }}" class="rounded-circle" alt="">--}}
                            {{--@endif--}}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="profileDropdown">
                            <div class="dropdown-header d-flex flex-column align-items-center">
                                <div class="figure mb-3">
                                    @if(Auth::check())
                                        <img style="width: 80px;height: 80px;" src="{{ Auth::user()->avatar }}"
                                             onerror="this.onerror=null;this.src='{{ url( env('DEFAULT_AVATAR', 'images/coffee.png' ) ) }}';"
                                             class="rounded-circle" alt="{{Auth::user()->name}}'s Profile Pic">
                                    @endif
                                </div>
                                <div class="info text-center">
                                    <p class="name font-weight-bold mb-0">{{ Auth::user()->name }}</p>
                                    <p class="name mb-3">{{ \App\Helpers\AuthUtil::getRoleName(Auth::user()->roleId ) }}</p>
                                    <p class="email text-muted mb-3">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                            <div class="dropdown-body">
                                <ul class="profile-nav p-0 pt-3">
                                    <li class="nav-item">
                                        <a href="{{ url('profile') }}" class="nav-link">
                                            <i data-feather="user"></i>
                                            <span>Profile</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('profile-edit') }}" class="nav-link">
                                            <i data-feather="edit"></i>
                                            <span>Edit Profile</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href=""  class="nav-link" onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                           data-toggle="tooltip" title="Sign out">
                                            <i data-feather="log-out"></i>
                                            <span>Log Out</span>
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- partial -->

        <div id="spinner_" style="background: ();opacity:1;">
            <div class="spinner"></div>
        </div>
        <div class="page-content" id="app" style="padding: 16px !important;">
            @yield('content')
        </div>

        <!-- partial:partials/_footer.html -->
{{--        <footer class="footer d-flex flex-column flex-md-row align-items-center justify-content-between">--}}
{{--            <p class="text-muted text-center text-md-left">--}}
{{--                Copyright © 2020 <a href="https://www.nobleui.com" target="_blank">NobleUI</a>. All rights reserved--}}
{{--            </p>--}}
{{--            <p class="text-muted text-center text-md-left mb-0 d-none d-md-block">Handcrafted With <i class="mb-1 text-primary ml-1 icon-small" data-feather="heart"></i></p>--}}
{{--        </footer>--}}
        <!-- partial -->

    </div>
</div>

@yield('modal')

<!-- core:js -->
<script src="{{ url('themes/nobleui') }}/assets/vendors/core/core.js"></script>
<script src="{{ url('themes/nobleui') }}/assets/vendors/feather-icons/feather.min.js"></script>
<script src="{{ url('themes/nobleui') }}/assets/js/template.js"></script>

<!-- endinject -->
<!-- plugin js for this page -->
<!-- end plugin js for this page -->
<!-- inject:js -->
<!-- endinject -->
<!-- custom js for this page -->
<script src="{{ url('themes/nobleui') }}/assets/js/dashboard.js"></script>

<!-- end custom js for this page -->
<script type="application/javascript">
    function spinner() {
        setTimeout(() => {
            document.getElementById("spinner_").style.display = "none";
            document.getElementById("app").style.display = "block";
        }, 900);
    }
</script>

</body>
</html>
