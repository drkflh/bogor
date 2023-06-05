<!-- side nav bar -->
<style>
    i.las {
        font-size: 12pt;
    }
</style>
<ul class="navbar-nav justify-content-start flex-grow-1 gap-1"  id="nav-sidebar">

    <?php
    $section = '';


    $menuitem = '<li class="nav-item">
                        <a %s class="nav-link">%s  <span class="link-title"> %s </span>
                            <span v-if="getBadge(\'%s\')" class="badge badge-pill badge-secondary">{{  getBadge("%s") }}</span>
                        </a>
                    </li>';

    $subitem = '<li class=""><a %s class="dropdown-item" >%s <span v-if="getBadge(\'%s\')" class="badge badge-pill badge-secondary">{{  getBadge("%s") }}</span></a></li>';

    $subparent = '<li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
                            %s
                            <span class="menu-title">%s</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        %s
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
        }).$mount('#nav-sidebar');

    });


</script>
