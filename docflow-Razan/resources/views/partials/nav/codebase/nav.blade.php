<!-- side nav bar -->
<style>
    .nav-main a.nav-submenu.sub-children {
        padding-right: 70px;
    }

    ul.nav-submenu{
        padding-left: 50px;
    }
</style>

<ul class="nav-main" id="nav-sidebar">
    <?php
        $section = '<li class="nav-main-heading">{{section}}</li>';

        $menuitem = '<li>
                        <a {{url}} class="waves-effect">{{icon}} <span> {{title}} </span>
                            <span v-if="getBadge(\'|badge|\')" class="badge badge-pill badge-secondary">{{  getBadge("|badge|") }}</span>
                        </a>
                    </li>';
        $subitem = '<li  v-if="|show|" ><a {{url}} >{{title}} <span  v-if="getBadge(\'|badge|\')" class="badge badge-pill badge-secondary">{{  getBadge("|badge|") }}</span></a></li>';
        $subparent = '<li id="{{id}}" >
                        <a class="nav-submenu" data-toggle="nav-submenu" href="#" >{{icon}}
                            <span> {{title}}
                                <span class="float-right menu-arrow"><i class="mdi mdi-chevron-left"></i></span>
                            </span>
                        </a>{{submenu}}
                    </li>';
        $subtag = '<ul>';
        $grandtag = '<ul class="nav-submenu">';
        $menustring =  \App\Helpers\Util::clearYaml()
            ->loadResYaml( $nav_file,$nav_path )
            ->loadResYaml( 'nav','views/partials/app/obj', true )
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
                    badge : {},
                    docs : []
                };
            },
            computed:{
            },
            methods:{
                showMenu(menuKey){
                    var menuItem = _.get(docViewerItems, menuKey, false);

                    if(menuItem){
                        var cnt = _.uniqBy(menuItem, 'url' );
                        console.log('nav',cnt);
                        return cnt;
                    }else{
                        return false;
                    }
                },
                popView(menu){
                    bus.$emit('popopen',menu);
                },
                popPdfView(menu){
                    bus.$emit('openpdfbox',menu);
                },
                popIframeView(menu, title) {
                    console.log('menu', menu)
                    bus.$emit('openiframe', {
                        menu: menu,
                        title: title
                    });
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

                },
                getEntCnt(ent){
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
