<ul class="metismenu" id="side-menu">
    <?php
        $section = '<li class="menu-title">%s</li>';
        $menuitem = '<li><a href="%s" class="waves-effect">%s <span> %s </span></a></li>';
        $subitem = '<li><a href="%s">%s</a></li>';
        $subparent = '<li><a href="javascript:void(0);" class="waves-effect">%s<span> %s <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>%s</li>';

        $menustring =  \App\Helpers\Util::loadResYaml( $nav_file,$nav_path )
            ->loadResYaml( 'nav','views/partials/app/obj', true )
            ->toMenu($section, $menuitem, $subparent ,$subitem);

        print $menustring ;
    ?>
</ul>
