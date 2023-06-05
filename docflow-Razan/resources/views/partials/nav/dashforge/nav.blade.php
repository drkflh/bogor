<!-- side nav bar -->
<ul class="nav nav-aside" id="nav-sidebar" >
    <?php
        $section = '<li class="nav-label mg-t-25">%s</li>';

        $menuitem = '<li class="nav-item">
                        <a %s class="nav-link">%s  <span> %s </span>
                            <span v-if="getBadge(\'%s\')" class="badge badge-pill badge-secondary">{{  getBadge("%s") }}</span>
                        </a>
                    </li>';
        $subitem = '<li><a %s >%s <span v-if="getBadge(\'%s\')" class="badge badge-pill badge-secondary">{{  getBadge("%s") }}</span></a></li>';
        $subparent = '<li class="nav-item with-sub">
                        <a class="nav-link" href="" >%s
                            <span> %s
                                <span class="float-right menu-arrow"><i class="mdi mdi-chevron-left"></i></span>
                            </span>
                        </a>%s
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
