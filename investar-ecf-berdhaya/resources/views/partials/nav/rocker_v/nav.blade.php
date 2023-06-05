<!-- side nav bar -->
<style>
    i.las {
        font-size: 12pt;
    }
</style>

<ul class="metismenu"  id="menu">
{{--    <li>--}}
{{--        <a  class="has-arrow">--}}
{{--            <div class="parent-icon"><i class='bx bx-home-circle'></i>--}}
{{--            </div>--}}
{{--            <div class="menu-title">Dashboard</div>--}}
{{--        </a>--}}
{{--        <ul>--}}
{{--            <li> <a href="{{ url('themes/rocker_v') }}/index.html"><i class="bx bx-right-arrow-alt"></i>Default</a>--}}
{{--            </li>--}}
{{--            <li> <a href="{{ url('themes/rocker_v') }}/index2.html"><i class="bx bx-right-arrow-alt"></i>Alternate</a>--}}
{{--            </li>--}}
{{--        </ul>--}}
{{--    </li>--}}
{{--    <li class="menu-label">Others</li>--}}
{{--    <li>--}}
{{--        <a class="has-arrow" href="#">--}}
{{--            <div class="parent-icon"><i class="bx bx-menu"></i>--}}
{{--            </div>--}}
{{--            <div class="menu-title">Menu Levels</div>--}}
{{--        </a>--}}
{{--        <ul>--}}
{{--            <li> <a class="has-arrow" href="#"><i class="bx bx-right-arrow-alt"></i>Level One</a>--}}
{{--                <ul>--}}
{{--                    <li> <a class="has-arrow" href="#"><i class="bx bx-right-arrow-alt"></i>Level Two</a>--}}
{{--                        <ul>--}}
{{--                            <li>--}}
{{--                                <a href="#"><i class="bx bx-right-arrow-alt"></i>Level Three</a>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--        </ul>--}}
{{--    </li>--}}
{{--    <li>--}}
{{--        <a href="#" target="_blank">--}}
{{--            <div class="parent-icon">--}}
{{--                <i class="bx bx-folder"></i>--}}
{{--            </div>--}}
{{--            <div class="menu-title">Documentation</div>--}}
{{--        </a>--}}
{{--    </li>--}}
{{--    <li>--}}
{{--        <a href="#" target="_blank">--}}
{{--            <div class="parent-icon"><i class="bx bx-support"></i>--}}
{{--            </div>--}}
{{--            <div class="menu-title">Support</div>--}}
{{--        </a>--}}
{{--    </li>--}}
    <?php
    $section = '<li class="menu-section text-capitalize mt-2">%s</li>';


    $menuitem = '<li>
                        <a %s class="nav-link">
                            <div class="parent-icon">
                                %s
                            </div>
                            <span class="menu-title"> %s </span>
                            <span v-if="getBadge(\'%s\')" class="badge badge-pill badge-secondary">{{  getBadge("%s") }}</span>
                        </a>
                    </li>';

    $subparent = '<li>
                        <a href="#" class="has-arrow">
                            %s
                            <span class="menu-title">%s</span>
                        </a>
                        %s
                    </li>';

    $subitem = '<li class="">
                    <a %s class="ml-2" style="margin-left: 28px;">
                        %s
                    </a>
                </li>';

    $subtag = '<ul>';

    $grandtag = '<ul>';

    $menustring = null;

    if( isset($nav_file) && isset($nav_path) ){

        $menustring =  \App\Helpers\MenuUtil::clearYaml()
            ->loadResYaml( $nav_file,$nav_path );

        $menustring = $menustring->toMenu($section, $menuitem, $subparent ,$subitem,$grandtag, $grandtag);

        //dynamic menu
        print $menustring ;

        $menustring = null;

        if(env('WITH_CMS', true)){
            if(is_null($menustring)){
                $menustring =  \App\Helpers\MenuUtil::clearYaml()
                    ->loadResYaml( 'nav','views/partials/app/cms', true );
            }else{
                $menustring = $menustring->loadResYaml( 'nav','views/partials/app/cms', true );
            }
        }

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


        if(env('WITH_MEMBERSHIP', false) || env('WITH_SYSTEM_TOOL', false)){
            if(is_null($menustring)){
                $menustring =  \App\Helpers\MenuUtil::clearYaml()
                    ->loadResYaml( 'nav','views/partials/app/sys', true );
            }else{
                $menustring = $menustring->loadResYaml( 'nav','views/partials/app/sys', true );
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
            print $menustring ;
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
        }).$mount('#menu');

    });


</script>
