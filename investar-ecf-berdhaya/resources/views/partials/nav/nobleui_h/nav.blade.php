<!-- side nav bar -->
<style>
    i.las {
        font-size: 12pt;
    }
    i.las.la-angle-down {
        font-size: 9pt;
        margin-left: 6px;
    }
    #nav-app ul li button i ,
    #nav-app ul li.nav-item.dropdown a
    {
        color: {!!  ( env('NOBLE_OPT_THEME','dark') == 'hybrid' || env('NOBLE_OPT_THEME','dark') == 'dark' )?'white':'black' !!} !important;
    }
    .horizontal-menu .bottom-navbar .page-navigation {
        position: relative;
        width: 100%;
        z-index: 99;
        justify-content: flex-start ;
        transition-duration: .2s;
        transition-property: background,box-shadow;
    }
</style>

<ul class="nav page-navigation" id="nav-topbar">
    <?php
        $section = '';
        $menuitem = '<li class="nav-item">
                        <a %s class="nav-link">
                            %s
                            <span class="menu-title"> %s </span>
                            <span v-if="getBadge(\'%s\')" class="badge badge-pill badge-secondary">{{  getBadge("%s") }}</span>
                        </a>
                    </li>';

        $subitem = '<li class="nav-item"><a %s class="nav-link" >%s <span v-if="getBadge(\'%s\')" class="badge badge-pill badge-secondary">{{  getBadge("%s") }}</span></a></li>';

        $subparent = '<li class="nav-item">
                        <a class="nav-link" href="#" id="{{id}}" >
                            %s
                            <span class="link-title">%s</span>
                            <i class="las la-angle-down"></i>
                        </a>
                        <div  class="submenu" aria-labelledby="{{id}}">
                            %s
                        </div>
                    </li>';

        $subtag = '<ul class="submenu-item">';

        $grandtag = '<ul class="submenu-item">';

        $menustring =  \App\Helpers\Util::clearYaml()
            ->loadResYaml( $nav_file,$nav_path )
//            ->loadResYaml( 'nav','views/partials/app/obj', true )
            ->toMenu($section, $menuitem, $subparent ,$subitem,$grandtag, $grandtag);
        print $menustring ;
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
        }).$mount('#nav-topbar');



    });


</script>
