<!DOCTYPE html>
<html class="no-js" lang="en">
<!-- NEST_FRONTEND_APP -->
<head>
    <meta charset="utf-8" />
    <title>{{ env('SITE_NAME','') }} - {{ env('SITE_TITLE') }}</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:title" content="" />
    <meta property="og:type" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ url(env('APP_FAVICON', 'favicon.ico')) }}" />
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ url('themes/nest_frontend') }}/assets/css/plugins/animate.min.css" />
    <link rel="stylesheet" href="{{ url('themes/nest_frontend') }}/assets/css/main.css?v=5.3" />

    {{-- icon line --}}
    <link rel="stylesheet" href="{{ url('line-awesome-master/dist/font-awesome-line-awesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ url('line-awesome-master/dist/line-awesome/css/line-awesome.min.css') }}">

    <link rel="stylesheet" href="{{ url('css/theme/nest.css') }}">


    <script>window.Laravel = {csrfToken: '{{ csrf_token() }}'}</script>



    <script src="{{ url(mix('js/manifest.js')) }}"></script>
    <script src="{{ url(mix('js/vendor.js')) }}"></script>
    <script src="{{ url(mix('js/vendor~jquery.js')) }}"></script>
    <script src="{{ url(mix('js/app.js')) }}"></script>

    <script src="{{ url('themes/nest_frontend') }}/assets/js/vendor/modernizr-3.6.0.min.js"></script>
    <script src="{{ url('themes/nest_frontend') }}/assets/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="{{ url('themes/nest_frontend') }}/assets/js/vendor/jquery-migrate-3.3.0.min.js"></script>
    <script src="{{ url('themes/nest_frontend') }}/assets/js/vendor/bootstrap.bundle.min.js"></script>

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

<body
    style="background-image: url( '{{ url( env('BG_PATTERNS', 'images/patterns/50872.jpg') ) }}' );background-repeat: repeat;background-size: initial; background-position: bottom;background-attachment: fixed;"
>
<!-- Preloader Start -->
<div id="preloader-active">
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="preloader-inner position-relative">
            <div class="text-center">
                <img src="{{ url('themes/nest_frontend') }}/assets/imgs/theme/loading.gif" alt="" />
            </div>
        </div>
    </div>
</div>
 
<!-- Modal -->

<!-- Quick view -->

<header class="header-area header-style-1 header-height-2" id="nav-app" >
    <!-- <div class="mobile-promotion">
        <span>Grand opening, <strong>up to 15%</strong> off all items. Only <strong>3 days</strong> left</span>
    </div> -->
    <!-- Top view -->

    <!-- End Top view -->

    <!-- Main Head view -->
    <?php
    $content = \App\Helpers\CmsUtil::getArticleByCategorySlug('campaign-list');
    $cat = \App\Helpers\CmsUtil::getCategoryBySlug('campaign-list');
    $aux = [
        'head'=>'',
        'title'=>($cat['categoryName'] ?? ''),
        'description'=>($cat['categoryDescription'] ?? '')
    ];
    ?>
    {!! \App\Helpers\CmsUtil::singleBlock( $content, 'main_head', 'nest_frontend', $aux ) !!}

    <!-- End Main Head view -->

    <!-- Main Head Nav view -->
    {!! \App\Helpers\CmsUtil::singleBlock( $content, 'main_head_nav', 'nest_frontend', $aux ) !!}
    <!-- End Main Head Nav view -->

</header>
<div class="mobile-header-active mobile-header-wrapper-style">
    <div class="mobile-header-wrapper-inner" >
        <div class="mobile-header-top">
            <div class="mobile-header-logo d-flex align-items-center justify-content-center">
                <a href="{{ url('/') }}"><img src="{{ url( env('APP_LOGO')) }}" alt="logo" style="width: 75px;" /></a>
            </div>
            <div class="mobile-menu-close close-style-wrap close-style-position-inherit">
                <button class="close-style search-close">
                    <i class="icon-top"></i>
                    <i class="icon-bottom"></i>
                </button>
            </div>
        </div>
        <div class="mobile-header-content-area">
            <div class="mobile-search search-style-3 mobile-header-border">
                <form action="{{ url('catalog') }}" method="get">
                    <input name="keyword" type="text" placeholder="Search for items…" />
                    <button type="submit"><i class="fi-rs-search"></i></button>
                </form>
            </div>
            <div class="mobile-menu-wrap mobile-header-border" style="margin-bottom: 35px;">
                <!-- mobile menu start -->
                <nav>
                    <ul class="mobile-menu font-heading">
                        <li class="menu-item">
                            <a href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ url('catalog') }}">Catalog</a>
                        </li>
                    </ul>
                </nav>
                <!-- mobile menu end -->
            </div>
            <div class="mobile-social-icon mb-50 mt-5" style="margin-top: 35px;">
                <h6 class="mb-15">Follow Us</h6>
                <a href="{{ url('themes/nest_frontend') }}/#"><img src="{{ url('themes/nest_frontend') }}/assets/imgs/theme/icons/icon-facebook-white.svg" alt="" /></a>
                <a href="{{ url('themes/nest_frontend') }}/#"><img src="{{ url('themes/nest_frontend') }}/assets/imgs/theme/icons/icon-twitter-white.svg" alt="" /></a>
                <a href="{{ url('themes/nest_frontend') }}/#"><img src="{{ url('themes/nest_frontend') }}/assets/imgs/theme/icons/icon-instagram-white.svg" alt="" /></a>
                <a href="{{ url('themes/nest_frontend') }}/#"><img src="{{ url('themes/nest_frontend') }}/assets/imgs/theme/icons/icon-pinterest-white.svg" alt="" /></a>
                <a href="{{ url('themes/nest_frontend') }}/#"><img src="{{ url('themes/nest_frontend') }}/assets/imgs/theme/icons/icon-youtube-white.svg" alt="" /></a>
            </div>
        </div>
    </div>
</div>
<!--End header-->
<main class="main">
    <!--Hero slider-->

    <!--End hero slider-->

    <!--Category slider-->

    <!--End category slider-->

    <!--Banners-->

    <!--End banners-->
    <!--Products Tabs-->

    <main class="main">
        <div class="container mb-30 p-lg-5 {{ $page_class }}" id="app" >
            <div class="tab-content">
                @if( View::exists($top_additional_view) )
                    @include($top_additional_view)
                @endif
                <div class="section-title style-2 wow animate__ animate__fadeIn animated" style="visibility: visible; animation-name: fadeIn; margin-bottom: 26px;">
                    <h4 style="font-weight: 700;">{!! $title !!}</h4>
                </div>
                @yield('content')
            </div>
            @yield('modal')
        </div>
    </main>

    <!--End Best Sales-->

    <!--End Deals-->

    <!--End 4 columns-->
</main>
<footer class="main">

    <!--End newsletter-->

    <!--End Features-->

    {!! \App\Helpers\CmsUtil::singleBlock( $content, 'footer_company', 'nest_frontend', $aux ) !!}
</footer>


<!-- Vendor JS-->
<script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/slick.js"></script>
<script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/jquery.syotimer.min.js"></script>
<script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/waypoints.js"></script>
<script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/wow.js"></script>
<script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/perfect-scrollbar.js"></script>
<script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/magnific-popup.js"></script>
<script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/select2.min.js"></script>
<script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/counterup.js"></script>
<script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/jquery.countdown.min.js"></script>
<script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/images-loaded.js"></script>
<script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/isotope.js"></script>
<script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/scrollup.js"></script>
<script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/jquery.vticker-min.js"></script>
<script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/jquery.theia.sticky.js"></script>
<script src="{{ url('themes/nest_frontend') }}/assets/js/plugins/jquery.elevatezoom.js"></script>
<!-- Template  JS -->
<script src="{{ url('themes/nest_frontend') }}/assets/js/main.js?v=5.3"></script>
<script src="{{ url('themes/nest_frontend') }}/assets/js/shop.js?v=5.3"></script>
</body>

</html>
