<!DOCTYPE html>
<html lang="en" class="no-js">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="Premium Bootstrap 5 Landing Page Template" />
        <meta name="keywords" content="bootstrap 5, premium, marketing, multipurpose" />
        <meta name="author" content="Coderthemes" />

        <!-- Site Title -->
        <title>{{ env('SITE_NAME','') }} - {{ env('SITE_TITLE') }}</title>
        <!-- Site favicon -->
        <!-- Light-box -->
        <link rel="stylesheet" href="{{ url('themes/dojek') }}/css/mklb.css" type="text/css" />

        <!-- Swiper js -->
        <link rel="stylesheet" href="{{ url('themes/dojek') }}/css/swiper-bundle.min.css" type="text/css" />

        <!--Material Icon -->
        <link rel="stylesheet" type="text/css" href="{{ url('themes/dojek') }}/css/materialdesignicons.min.css" />

        <link rel="stylesheet" href="{{ url('themes/dojek') }}/css/bootstrap.min.css" type="text/css" />
        <link rel="stylesheet" type="text/css" href="{{ url('themes/dojek') }}/css/style.css" />
        <link rel="stylesheet" type="text/css" href="{{ url('css/theme/dojek.css') }}" />
        <!-- icon line -->
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
        <link rel="shortcut icon" href="{{ url(env('APP_FAVICON', 'favicon.ico')) }}"/>
{{--        <script src="{{ url( 'js/jquery-3.6.0.min.js' ) }}"></script>--}}

        <script>window.Laravel = {csrfToken: '{{ csrf_token() }}'}</script>

        <script src="{{ url(mix('js/manifest.js')) }}"></script>
        <script src="{{ url(mix('js/vendor.js')) }}"></script>
        <script src="{{ url(mix('js/app.js')) }}"></script>

        @yield('extjs')

        @yield('js')

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
                                });
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

    <body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="60" onload="spinner()"
{{--          style="background-image: url( '{{ url(env('BG_PATTERNS', 'images/patterns/5086.jpg')) }}' );background-repeat: repeat;background-size: initial;"--}}
    >
        <!--Navbar Start-->
        <nav class="navbar navbar-expand-lg fixed-top navbar-custom sticky-dark" id="navbar-sticky">
            <div class="container" id="nav-app">
                <!-- LOGO -->
                <a class="logo text-uppercase" href="{{ url('/') }}">
                    <img src="{{ url( env('APP_LOGO') ) }}" alt="" height="50">
                    @if(env('LOGO_TEXT', false ))
                        <span class="sidebar-brand" style="font-size: 15pt;font-weight: bold;">{{ env('SITE_TITLE') }}</span>
                    @endif
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="mdi mdi-menu"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav ms-auto navbar-center" id="mySidenav">
                        @include(env('APP_OPEN_NAV_VIEW'))
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Navbar End -->
        <section class="hero-agency" id="home">
            <div class="container">
                <h1 class="title">{!! $title !!}</h1>
                <nav class="page-breadcrumb {{ $page_class }} " style="margin: auto;">
                </nav>

                <div class="row" id="app">
                    <div class="col-md-12 grid-margin">
                        @yield('content')
                        @yield('modal')
                    </div>
                </div>
            </div>
        </section>


        {{-- Footer --}}
        {!! \App\Helpers\CmsUtil::singleBlock( \App\Helpers\CmsUtil::getArticleBySlug('home-footer'), 'home1footer', 'dojek' ) !!}

        <!-- Back to top -->
        <a href="#" onclick="topFunction()" class="back-to-top-btn btn btn-dark" id="back-to-top"><i class="mdi mdi-chevron-up"></i></a>

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

        <!-- javascript -->
        <script src="{{ url('themes/dojek') }}/js/bootstrap.bundle.min.js"></script>
        <!-- Portfolio filter -->
        <script src="{{ url('themes/dojek') }}/js/filter.init.js"></script>
        <!-- Light-box -->
        <script src="{{ url('themes/dojek') }}/js/mklb.js"></script>
        <!-- swiper -->
        <script src="{{ url('themes/dojek') }}/js/swiper-bundle.min.js"></script>
        <script src="{{ url('themes/dojek') }}/js/swiper.js"></script>

{{--        <!-- counter -->--}}
{{--        <script src="{{ url('themes/dojek') }}/js/counter.init.js"></script>--}}
        <script src="{{ url('themes/dojek') }}/js/app.js"></script>
    </body>
</html>
