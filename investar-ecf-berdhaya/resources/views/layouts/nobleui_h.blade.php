<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
	<meta name="author" content="NobleUI">
	<meta name="keywords" content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <title>{{ env('SITE_NAME','') }} - {{ env('SITE_TITLE') }}</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
  <!-- End fonts -->

	<!-- core:css -->
    <link rel="stylesheet" href="{{ url('themes/nobleui/horizontal/assets/vendors/core/core.css') }}">
    <link rel="stylesheet" href="{{ url('themes/loaders/dots.css') }}">
	<!-- endinject -->

	<!-- Plugin css for this page -->
	<!-- End plugin css for this page -->

	<!-- inject:css -->
	<link rel="stylesheet" href="{{ url('themes/nobleui/horizontal') }}/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    {{-- icon line --}}
    <link rel="stylesheet" href="{{ url('line-awesome-master/dist/font-awesome-line-awesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ url('line-awesome-master/dist/line-awesome/css/line-awesome.min.css') }}">

	<!-- endinject -->

  <!-- Layout styles -->
	<link rel="stylesheet" href="{{ url('themes/nobleui/horizontal/assets/css/demo3/style.min.css') }}">
  <!-- End layout styles -->

    <link rel="stylesheet" href="{{ url(  env('APP_CSS', 'css/parama.css')  ) }}">
    <!-- Theme CSS overrides -->
    <link rel="stylesheet" href="{{ url('css/theme/nobleui.css') }}">

    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ url(env('APP_FAVICON', 'favicon.ico')) }}" />

    <script>window.Laravel = {csrfToken: '{{ csrf_token() }}'}</script>

    <script src="{{ url(mix('js/manifest.js')) }}"></script>
    <script src="{{ url(mix('js/vendor.js')) }}"></script>
    <script src="{{ url(mix('js/app.js')) }}"></script>

    @yield('extjs')

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

        #nav-app ul li button i, #nav-app ul li.nav-item.dropdown a span {
            color: black !important;
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
    </style>

{{--    @if( $with_timetracking|| $with_attendance)--}}
    <script>
        $(document).ready(function(){
            bus.$emit('loadPageData');
            var navvm = new Vue({
                mounted(){
                    this.getState();
                @if( $with_notification )
                    this.getNotifications();
                    this.doStartNotifTimer();
                @endif

                    @if( env('WITH_APPWRITE', false) )
                    this.appWrite = window.appwrite
                        .setEndpoint('{{ env('APPWRITE_ENDPOINT') }}') // Your Appwrite Endpoint
                        .setProject('{{ env('APPWRITE_PROJECT_ID') }}');

                    this.appWrite.subscribe('collections.62b7e224621f6ad79fa9.documents', response => {
                        console.log( 'appwrite', response.payload );
                    });
                    @endif
                    bus.$on('refreshShoppingCart', (data) => {
                        console.log('refresh cart event');
                        this.loadShoppingCart();
                    });

                    this.loadShoppingCart();

                },
                name: 'Top Nav',
                data: function(){
                    return {
                        tz : window.tz,
                        appWrite: {},
                        attStatus: '{{ \App\Helpers\WorkflowUtil::getCurrentAttStatus() }}',
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

                        cart: [],
                        totalBill: 0,
                        totalQty: 0

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
                            @if( \Illuminate\Support\Facades\Auth::check() )
                                if(error.response.status == 401){
                                    var d = new Date();
                                    alert('Your session is expired. Please re-login');
                                    window.location.href = '{{ url('login') }}?' + d.getTime() ;
                                }
                            @endif
                        })
                    },
                    loadShoppingCart(){
                        axios.post( '{{ url('my-cart') }}' , {} )
                            .then(response => {
                                console.log(response.data);
                                if(response.data.result == 'OK'){
                                    this.cart = response.data.data.cart;
                                    this.totalBill = response.data.data.totalBill;
                                    this.totalQty = response.data.data.totalQty;
                                }
                            })
                            .catch(function(error) {
                                console.log(error);
                                @if( \Illuminate\Support\Facades\Auth::check() )
                                if(error.response.status == 401){
                                    var d = new Date();
                                    alert('Your session is expired. Please re-login');
                                    window.location.href = '{{ url('login') }}?' + d.getTime() ;
                                }
                            @endif
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
                                @if( \Illuminate\Support\Facades\Auth::check() )
                                if(error.response.status == 401){
                                    var d = new Date();
                                    alert('Your session is expired. Please re-login');
                                    window.location.href = '{{ url('login') }}?' + d.getTime() ;
                                }
                                @endif
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
                                @if( \Illuminate\Support\Facades\Auth::check() )
                                if(error.response.status == 401){
                                    var d = new Date();
                                    alert('Your session is expired. Please re-login');
                                    window.location.href = '{{ url('login') }}?' + d.getTime() ;
                                }
                                @endif
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
                                            @if( \Illuminate\Support\Facades\Auth::check() )
                                            if(error.response.status == 401){
                                                var d = new Date();
                                                alert('Your session is expired. Please re-login');
                                                window.location.href = '{{ url('login') }}?' + d.getTime() ;
                                            }
                                            @endif
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
                                            @if( \Illuminate\Support\Facades\Auth::check() )
                                            if(error.response.status == 401){
                                                var d = new Date();
                                                alert('Your session is expired. Please re-login');
                                                window.location.href = '{{ url('login') }}?' + d.getTime() ;
                                            }
                                            @endif
                                        });
                                }
                            })
                            .catch((error) => {})

                    },
                    formatCurrency(val, neg = false){
                        val = parseFloat(val);
                        if(neg){
                            val = -val ;
                        }
                        return accounting.formatMoney( val , '' ,2, '.', ',', this.accFormat);
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
                                @if( \Illuminate\Support\Facades\Auth::check() )
                                if(error.response.status == 401){
                                    var d = new Date();
                                    alert('Your session is expired. Please re-login');
                                    window.location.href = '{{ url('login') }}?' + d.getTime() ;
                                }
                                @endif
                        })
                    }
                }
            }).$mount('#nav-app');

        });
    </script>


</head>
<body onload="spinner()" style="background-image: url( '{{ url(env('BG_PATTERNS', 'images/patterns/5086.jpg')) }}' );background-repeat: repeat;background-size: initial;" >
	<div class="main-wrapper" id="content-block" style="visibility: none;display:none;">

		<!-- partial:../../partials/_navbar.html -->
		<div class="horizontal-menu">
			<nav class="navbar top-navbar" {!!  ( env('NOBLE_OPT_THEME','dark') == 'hybrid' )?'style="background-color: '.env('NOBLE_OPT_COLOR','black').' ;color: white;"':'' !!} >
				<div class="container">
					<div class="navbar-content" id="nav-app">
						<a href="{{ url('/') }}" class="navbar-brand">
                            <img src="{{ url( env('APP_LOGO_SMALL') ) }}" alt="" height="35">
                            @if(env('LOGO_TEXT', false ))
                                <span class="navbar-brand" style="font-size: 15pt;font-weight: bold;">{{ env('SITE_TITLE') }}</span>
                            @endif
						</a>

                        <ul class="navbar-nav">
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
                                <?php
                                $lang = App::currentLocale();
                                ?>
                                <li class="nav-item dropdown" id="langContainer">
                                    <form method="get" action="{!! url()->full() !!}" >
                                        <select name="lang" class="form-control custom-select" onchange="this.form.submit()" style="min-width: 100px;">
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

                            @if($with_notification)
                                <li class="nav-item dropdown nav-notifications">
                                    <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i style="font-size: 20pt;" class="las la-inbox mt-1"></i>
                                        <div v-if="_.isArray(notifications) && notifications.length > 0" class="indicator">
                                            <div class="circle mt-1"></div>
                                        </div>
                                    </a>
                                    <div v-show="_.isArray(notifications) && notifications.length > 0"  class="dropdown-menu p-0" aria-labelledby="notificationDropdown">

                                        {{--                            <div class="dropdown-header d-flex align-items-center justify-content-between">--}}
                                        {{--                                <p class="mb-0 font-weight-medium">6 New Notifications</p>--}}
                                        {{--                                <a href="javascript:;" class="text-muted">Clear all</a>--}}
                                        {{--                            </div>--}}
                                        <div class="dropdown-body" style="max-height:300px;overflow-y: auto;" >
                                            <a v-for="msg in notifications" :href="msg.data.url" class="dropdown-item mt-2 mb-2 p-2 d-flex" style="height: fit-content !important;" >
                                                <div class="icon text-center align-self-start">
                                                    <i class="las la-envelope" style="margin: 0px;"></i>
                                                </div>
                                                <div class="content">
                                                    <p class="ellipsis" style="width:200px;font-size:9pt;" v-if="!_.isNull(msg.data)">@{{ msg.data.req ?? '' }} {{__('from')}} @{{ msg.data.from ?? '' }}</p>
                                                    <p class="" style="width:200px;font-size:8pt;" class="sub-text text-muted" v-if="!_.isNull(msg.data)" v-html="msg.data.msg" ></p>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="dropdown-footer d-flex align-items-center justify-content-center">
                                            <span @click="clearNotification" style="cursor: pointer;" >Clear</span>
                                        </div>
                                    </div>
                                </li>
                            @endif

                            @if( env('WITH_SFM') )

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle mr-1" href="#" id="cartDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i style="font-size: 20pt;" class="las la-shopping-cart mt-1"></i>
                                        <div v-if="totalQty > 0" class="indicator">
                                            <div class="circle mt-1"></div>
                                        </div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="cartDropdown">
                                        {{--                            <div class="dropdown-header d-flex align-items-center justify-content-between">--}}
                                        {{--                                <p class="mb-0 font-weight-medium">6 New Notifications</p>--}}
                                        {{--                                <a href="javascript:;" class="text-muted">Clear all</a>--}}
                                        {{--                            </div>--}}
                                        <div class="dropdown-body" style="max-height:300px;overflow-y: auto;" >
                                            <a v-for="c in cart" href="{{ url('ecf/shoppingcart') }}" class="dropdown-item mt-2 mb-2 p-2 d-flex" style="height: fit-content !important;" >
                                                <div class="icon text-center align-self-start">
                                                    <i class="las la-envelope" style="margin: 0px;"></i>
                                                </div>
                                                <div class="content">
                                                    <p class="ellipsis" style="width:200px;font-size:9pt;" >@{{ c.campaignTitle ?? '' }}</p>
                                                    <p class="" style="width:200px;font-size:8pt;" class="sub-text text-muted">
                                                        @{{ c.orderQty }} × </span> Rp.@{{ formatCurrency(c.pricePerLot) }}
                                                    </p>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="dropdown-footer d-flex align-items-end justify-content-center">
                                            <div class="shopping-cart-total">
                                                <h4 style="text-align:right;">Total :<span> Rp.@{{ formatCurrency(totalBill) }}</span></h4>
                                                <div>
                                                    <a href="{{ url('ecf/shoppingcart') }}" class="btn btn-outline-warning">View cart</a>
                                                    <a href="{{ url('check-out') }}" class="btn btn-outline-info">Checkout</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif

                            @if( \Illuminate\Support\Facades\Auth::check())
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button"
                                   data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img class="wd-30 ht-30 rounded-circle"
                                         src="{{ Auth::user()->avatar }}"
                                         onerror="this.onerror=null;this.src='{{ url( env('DEFAULT_AVATAR', 'images/coffee.png' ) ) }}';"
                                         alt="profile">
                                </a>
                                <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                                    <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                                        <div class="mb-3">
                                            @if(Auth::check())
                                                <img style="width: 80px;height: 80px;" src="{{ Auth::user()->avatar }}"
                                                     onerror="this.onerror=null;this.src='{{ url( env('DEFAULT_AVATAR', 'images/coffee.png' ) ) }}';"
                                                     class="rounded-circle" alt="{{Auth::user()->name}}'s Profile Pic">
                                            @endif
                                        </div>
                                        <?php
                                            //$lang = Auth::user()->lang ?? env('DEFAULT_LANG');
                                            $langList = config('util.languages');
                                            $lang = App::currentLocale();
                                            $lang = trim($lang) == '' || is_null($lang) ? env('DEFAULT_LANG', 'en'): strtolower($lang);
                                            $lang = $langList[ $lang];
                                        ?>
                                        <div class="text-center">
                                            <p class="tx-16 fw-bolder">{{ Auth::user()->name }}</p>
                                            <p class="tx-16 fw-bolder">{{ Auth::user()->approvalStatus ?? 'UNVERIFIED'}}</p>
                                            <p class="tx-12 fw-bolder">{{ Auth::user()->roleName ?? '' }}</p>
                                            <p class="tx-12 text-muted">{{ env('REG_EMAIL', false) ? Auth::user()->email : Auth::user()->mobileString }}</p>
                                        </div>
                                    </div>
                                    <ul class="list-unstyled p-1">
                                        <li class="dropdown-item py-2">
                                            <a href="{{ url('profile') }}"  class="text-body ms-0">
                                                <i class="me-2 icon-md" data-feather="user"></i>
                                                <span>Profile</span>
                                            </a>
                                        </li>
                                        <li class="dropdown-item py-2">
                                            <a href="{{ url('profile-edit') }}" class="text-body ms-0">
                                                <i class="me-2 icon-md" data-feather="edit"></i>
                                                <span>Edit Profile</span>
                                            </a>
                                        </li>
                                        @if(env('WITH_FRONTEND', false) )
                                        <li class="dropdown-item py-2">
                                            <a href="{{ url('/') }}" class="text-body ms-0">
                                                <i class="me-2 icon-md" data-feather="repeat"></i>
                                                <span>Go To Frontpage</span>
                                            </a>
                                        </li>
                                        @endif
                                        <li class="dropdown-item py-2">
                                            <a href=""
                                               onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                               class="text-body ms-0">
                                                <i class="me-2 icon-md" data-feather="log-out"></i>
                                                <span>Log Out</span>
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            @else
                                <li class="nav-item">
                                    <a href="{{ url('login') }}" >Login</a>
                                </li>
                            @endif
                        </ul>
                        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
							<i data-feather="menu"></i>
						</button>
					</div>
				</div>
			</nav>
			<nav class="bottom-navbar">
				<div class="container">
                    @if( View::exists('partials.nav.nobleui_h.nav') )
                        @include('partials.nav.nobleui_h.nav')
                    @endif
				</div>
			</nav>
		</div>
		<!-- partial -->

		<div class="page-wrapper" style="background-color: transparent !important;" >

			<div class="page-content">

				<nav class="page-breadcrumb {{ $page_class }} " style="margin: auto;">
                    <h2>{!! $title !!}</h2>
				</nav>

				<div class="row" id="app">
					<div class="col-md-12 grid-margin">
                        @yield('content')
                        @yield('modal')
					</div>
				</div>

			</div>

		</div>
	</div>

    <div id="spinner_" style="background: ();opacity:1;">
        <div class="vertical-centered-box">
            <div class="content">
                <div class="loader-circle"></div>
                <div class="loader-line-mask one">
                    <div class="loader-line"></div>
                </div>
                <div class="loader-line-mask two">
                    <div class="loader-line"></div>
                </div>
                <div class="loader-line-mask three">
                    <div class="loader-line"></div>
                </div>
                <div class="loader-line-mask four">
                    <div class="loader-line"></div>
                </div>
            </div>
        </div>
    </div>
	<!-- core:js -->
    <script type="application/javascript">
        function spinner() {
            setTimeout(() => {
                document.getElementById("spinner_").style.display = "none";
                document.getElementById("app").style.display = "block";
                document.getElementById("content-block").style.display = "block";
                document.getElementById("content-block").style.visibility = "visible";
            }, 900);
        }
    </script>

	<script src="{{ url('themes/nobleui/horizontal') }}/assets/vendors/core/core.js"></script>
	<!-- endinject -->

	<!-- inject:js -->
	<script src="{{ url('themes/nobleui/horizontal') }}/assets/vendors/feather-icons/feather.min.js"></script>
	<script src="{{ url('themes/nobleui/horizontal') }}/assets/js/template.js"></script>
	<!-- endinject -->

</body>
</html>
