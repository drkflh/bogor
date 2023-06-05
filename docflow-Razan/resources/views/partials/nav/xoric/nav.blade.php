<!-- side nav bar -->
<style>
    .nav-main a.nav-submenu.sub-children {
        padding-right: 70px;
    }

    ul.nav-submenu{
        padding-left: 50px;
    }
</style>

<ul class="metismenu list-unstyled" id="side-menu">
    <?php
    $section = '<li class="menu-title">%s</li>';

    $menuitem = '<li>
                        <a %s class="waves-effect">
                        <div class="d-inline-block icons-sm mr-1">%s</div>
                        <span> %s </span>
                        </a>
                    </li>';
    $subitem = '<li><a %s > %s </a></li>';
    $subparent = '<li>
                        <a href="#"  data-toggle="nav-submenu" class="has-arrow waves-effect">
                            %s<span> %s <span class="float-right menu-arrow">
                            </span>
                        </a>%s
                    </li>';
    $subtag = '<ul>';
    $grandtag = '<ul class="sub-menu" aria-expanded="false">';
    $menustring =  \App\Helpers\Util::clearYaml()
        ->loadResYaml( $nav_file,$nav_path )
        ->loadResYaml( 'nav','views/partials/app/obj', true )
        ->toMenu($section, $menuitem, $subparent ,$subitem,$grandtag, $grandtag);
    print $menustring ;
    ?>
</ul>
<div id="nav-sidebar" >

</div>


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
