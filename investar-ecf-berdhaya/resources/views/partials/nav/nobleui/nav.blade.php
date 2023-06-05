<!-- side nav bar -->
<style>
    i.fa {
        font-size: 12pt;
    }
</style>
<ul class="nav" id="nav-sidebar" >
    <?php
        $section = '<li class="nav-item nav-category">%s</li>';


        $menuitem = '<li class="nav-item">
                        <a %s class="nav-link">%s  <span class="link-title"> %s </span>
                            <span v-if="getBadge(\'%s\')" class="badge badge-pill badge-secondary">{{  getBadge("%s") }}</span>
                        </a>
                    </li>';

        $subitem = '<li class="nav-item"><a %s class="nav-link" >%s <span v-if="getBadge(\'%s\')" class="badge badge-pill badge-secondary">{{  getBadge("%s") }}</span></a></li>';

        $subparent = '<li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#{{id}}" role="button" aria-expanded="false" aria-controls="{{id}}">
                            %s
                            <span class="link-title">%s</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse" id="{{id}}">
                            %s
                        </div>
                    </li>';

        $subtag = '<ul class="nav sub-menu">';

        $grandtag = '<ul class="nav sub-menu">';

        $menustring = null;

        if( isset($nav_file) && isset($nav_path) ){

            $menustring =  \App\Helpers\Util::clearYaml()
                ->loadResYaml( $nav_file,$nav_path );

            $menustring = $menustring->toMenu($section, $menuitem, $subparent ,$subitem,$grandtag, $grandtag);

            //dynamic menu
            print $menustring ;

            $menustring = null;

            if(env('WITH_DCS', true)){
                if(is_null($menustring)){
                    $menustring =  \App\Helpers\Util::clearYaml()
                        ->loadResYaml( 'nav','views/partials/app/dcs', true );
                }else{
                    $menustring = $menustring->loadResYaml( 'nav','views/partials/app/dcs', true );
                }
            }

            if(env('WITH_WORKFLOW', false)){
                if(is_null($menustring)){
                    $menustring =  \App\Helpers\Util::clearYaml()
                        ->loadResYaml( 'usernav','views/partials/app/workflow', true );
                }else{
                    $menustring = $menustring->loadResYaml( 'usernav','views/partials/app/workflow', true );
                }
            }

            if(env('WITH_CMS', true)){
                if(is_null($menustring)){
                    $menustring =  \App\Helpers\Util::clearYaml()
                        ->loadResYaml( 'nav','views/partials/app/cms', true );
                }else{
                    $menustring = $menustring->loadResYaml( 'nav','views/partials/app/cms', true );
                }
            }


            if(env('WITH_MEMBERSHIP', false) || env('WITH_SYSTEM_TOOL', false)){
                if(is_null($menustring)){
                    $menustring =  \App\Helpers\Util::clearYaml()
                        ->loadResYaml( 'nav','views/partials/app/sys', true );
                }else{
                    $menustring = $menustring->loadResYaml( 'nav','views/partials/app/sys', true );
                }
            }
            if(env('WITH_PMC', false)){
                if(is_null($menustring)){
                    $menustring =  \App\Helpers\Util::clearYaml()
                        ->loadResYaml( 'nav','views/partials/app/pmc', true );
                }else{
                    $menustring = $menustring->loadResYaml( 'nav','views/partials/app/pmc', true );
                }
            }
            if(env('WITH_MASTER_REF', false)){
                if(is_null($menustring)){
                    $menustring =  \App\Helpers\Util::clearYaml()
                        ->loadResYaml( 'nav','views/partials/app/ref', true );
                }else{
                    $menustring = $menustring->loadResYaml( 'nav','views/partials/app/ref', true );
                }
            }
            if(env('WITH_DMS', false)){
                if(is_null($menustring)){
                    $menustring =  \App\Helpers\Util::clearYaml()
                        ->loadResYaml( 'nav','views/partials/app/dms', true );
                }else{
                    $menustring = $menustring->loadResYaml( 'nav','views/partials/app/dms', true );
                }
            }
            if(env('WITH_BIZ_ADMIN', false)){
                if(is_null($menustring)){
                    $menustring =  \App\Helpers\Util::clearYaml()
                        ->loadResYaml( 'nav','views/partials/app/sms', true );
                }else{
                    $menustring = $menustring->loadResYaml( 'nav','views/partials/app/sms', true );
                }
            }

            if(\App\Helpers\AuthUtil::isAdmin()){
                if( env('WITH_DEVTOOL', true) ){
                    if(is_null($menustring)){
                        $menustring =  \App\Helpers\Util::clearYaml()
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
