<!-- side nav bar -->
<style>
    i.las {
        font-size: 12pt;
    }
</style>
<ul class="side-nav-menu scrollable"  id="nav-sidebar">
{{--    <li class="nav-item dropdown">--}}
{{--        <a href="{{ url('themes/enlink') }}/">--}}
{{--                                <span class="icon-holder">--}}
{{--                                    <i class="anticon anticon-dashboard"></i>--}}
{{--                                </span>--}}
{{--            <span class="title">Single Link</span>--}}
{{--        </a>--}}
{{--    </li>--}}
{{--    <li class="nav-item dropdown">--}}
{{--        <a class="dropdown-toggle" href="#">--}}
{{--            <span class="icon-holder">--}}
{{--                <i class="anticon anticon-pie-chart"></i>--}}
{{--            </span>--}}
{{--            <span class="title">Dropdown</span>--}}
{{--            <span class="arrow">--}}
{{--                <i class="arrow-icon"></i>--}}
{{--            </span>--}}
{{--        </a>--}}
{{--        <ul class="dropdown-menu">--}}
{{--            <li>--}}
{{--                <a href="{{ url('themes/enlink') }}/">Dropdown 1</a>--}}
{{--            </li>--}}
{{--            <li>--}}
{{--                <a href="{{ url('themes/enlink') }}/">Dropdown 2</a>--}}
{{--            </li>--}}
{{--        </ul>--}}
{{--    </li>--}}
{{--    <li class="nav-item dropdown">--}}
{{--        <a class="dropdown-toggle" href="#">--}}
{{--            <span class="icon-holder">--}}
{{--                <i class="anticon anticon-file"></i>--}}
{{--            </span>--}}
{{--            <span class="title">Multi Level</span>--}}
{{--            <span class="arrow">--}}
{{--                <i class="arrow-icon"></i>--}}
{{--            </span>--}}
{{--        </a>--}}
{{--        <ul class="dropdown-menu">--}}
{{--            <li class="nav-item dropdown">--}}
{{--                <a href="#">--}}
{{--                    <span>Level 1</span>--}}
{{--                    <span class="arrow">--}}
{{--                                            <i class="arrow-icon"></i>--}}
{{--                                        </span>--}}
{{--                </a>--}}
{{--                <ul class="dropdown-menu">--}}
{{--                    <li>--}}
{{--                        <a href="{{ url('themes/enlink') }}/">Level 2.1</a>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <a href="{{ url('themes/enlink') }}/">Level 2.2</a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--        </ul>--}}
{{--    </li>--}}
    <?php
    $section = '<li class="nav-item dropdown">
                        <a class="nav-link">
                            <span class="icon-holder">

                            </span>
                            <span class="title section"> %s </span>
                        </a>
                </li>';


    $menuitem = '<li class="nav-item dropdown">
                        <a %s class="nav-link">
                            <span class="icon-holder">
                                %s
                            </span>
                            <span class="title"> %s </span>
                            <span v-if="getBadge(\'%s\')" class="badge badge-pill badge-secondary">{{  getBadge("%s") }}</span>
                        </a>
                    </li>';

    $subparent = '<li class="nav-item dropdown">
                        <a href="#" class="dropdown-toggle">
                            <span class="icon-holder">
                                %s
                            </span>
                            <span class="title">%s</span>
                            <span class="arrow">
                                <i class="arrow-icon"></i>
                            </span>
                        </a>
                        %s
                    </li>';

    $subitem = '<li class="">
                    <a %s class="dropdown-item" >
                        %s
                        <span v-if="getBadge(\'%s\')" class="badge badge-pill badge-secondary">{{  getBadge("%s") }}</span>
                    </a>
                </li>';


    $subtag = '<ul class="dropdown-menu">';

    $grandtag = '<ul class="dropdown-menu">';

    $menustring = null;

    if( isset($nav_file) && isset($nav_path) ){

        $menustring =  \App\Helpers\MenuUtil::clearYaml()
            ->loadResYaml( $nav_file,$nav_path );

        $menustring = $menustring->toMenu($section, $menuitem, $subparent ,$subitem,$grandtag, $grandtag);

        //dynamic menu
        print $menustring ;

        $menustring = null;

        if(env('WITH_DCS', true)){
            if(is_null($menustring)){
                $menustring =  \App\Helpers\MenuUtil::clearYaml()
                    ->loadResYaml( 'nav','views/partials/app/dcs', true );
            }else{
                $menustring = $menustring->loadResYaml( 'nav','views/partials/app/dcs', true );
            }
        }

        if(env('WITH_WORKFLOW', false)){
            if(is_null($menustring)){
                $menustring =  \App\Helpers\MenuUtil::clearYaml()
                    ->loadResYaml( 'usernav','views/partials/app/workflow', true );
            }else{
                $menustring = $menustring->loadResYaml( 'usernav','views/partials/app/workflow', true );
            }
        }

        if(env('WITH_CMS', true)){
            if(is_null($menustring)){
                $menustring =  \App\Helpers\MenuUtil::clearYaml()
                    ->loadResYaml( 'nav','views/partials/app/cms', true );
            }else{
                $menustring = $menustring->loadResYaml( 'nav','views/partials/app/cms', true );
            }
        }


        if(env('WITH_MEMBERSHIP', false) || env('WITH_SYSTEM_TOOL', false)){
            if(is_null($menustring)){
                $menustring =  \App\Helpers\MenuUtil::clearYaml()
                    ->loadResYaml( 'nav','views/partials/app/sys', true );
            }else{
                $menustring = $menustring->loadResYaml( 'nav','views/partials/app/sys', true );
            }
        }
        if(env('WITH_PMC', false)){
            if(is_null($menustring)){
                $menustring =  \App\Helpers\MenuUtil::clearYaml()
                    ->loadResYaml( 'nav','views/partials/app/pmc', true );
            }else{
                $menustring = $menustring->loadResYaml( 'nav','views/partials/app/pmc', true );
            }
        }
        if(env('WITH_MASTER_REF', false)){
            if(is_null($menustring)){
                $menustring =  \App\Helpers\MenuUtil::clearYaml()
                    ->loadResYaml( 'nav','views/partials/app/ref', true );
            }else{
                $menustring = $menustring->loadResYaml( 'nav','views/partials/app/ref', true );
            }
        }
        if(env('WITH_DMS', false)){
            if(is_null($menustring)){
                $menustring =  \App\Helpers\MenuUtil::clearYaml()
                    ->loadResYaml( 'nav','views/partials/app/dms', true );
            }else{
                $menustring = $menustring->loadResYaml( 'nav','views/partials/app/dms', true );
            }
        }
        if(env('WITH_BIZ_ADMIN', false)){
            if(is_null($menustring)){
                $menustring =  \App\Helpers\MenuUtil::clearYaml()
                    ->loadResYaml( 'nav','views/partials/app/sms', true );
            }else{
                $menustring = $menustring->loadResYaml( 'nav','views/partials/app/sms', true );
            }
        }

        if(\App\Helpers\AuthUtil::isAdmin()){
            if( env('WITH_DEVTOOL', true) ){
                if(is_null($menustring)){
                    $menustring =  \App\Helpers\MenuUtil::clearYaml()
                        ->loadResYaml( 'nav','views/partials/app/devtool', true );
                }else{
                    $menustring = $menustring->loadResYaml( 'nav','views/partials/app/devtool', true );
                }
            }
        }
        if(!is_null($menustring)){
            $menustring = $menustring->toMenu($section, $menuitem, $subparent ,$subitem,$grandtag, $grandtag);
            //print $menustring ;
        }
    }
    ?>

</ul>




<script>
    $(document).ready(function(){

        var menuvm = new Vue({
            mounted(){
                bus.$on('setbadge', (data) => {
                    this.setBadge(data);
                });
            },
            name: 'Side Nav',
            data: function(){
                return {
                    badge : {}
                };
            },
            computed:{
            },
            methods:{
                popView(menu){
                    bus.$emit('popopen',menu);
                },
                setBadge(data){
                    console.log( 'badgedata', data );
                    this.badge = data;
                },
                getBadge: function(menu){
                    var val = _.get(this.badge, menu);
                    if(val){
                        if(_.isArray(val)){
                            return val.length;
                        }else{
                            return false
                        }
                    }else{
                        return false
                    }

                }
            }
        }).$mount('#nav-sidebar');

    });


</script>
