<!-- side nav bar -->
<style>
    .nav-main a.nav-submenu.sub-children {
        padding-right: 70px;
    }

    ul.nav-submenu{
        padding-left: 50px;
    }

    #sidebar-menu>ul>li>a{
        font-size: 13px ;
    }

    #sidebar-menu ul.nav-second-level>li>a{
        font-size: 12px ;
    }

</style>

<ul class="metismenu list-unstyled" id="menu-bar">
    <?php
    $section = '<li class="menu-title">%s</li>';

    $menuitem = '<li>
                    <a %s>
                        %s
                        <span> %s </span>
                    </a>
                </li>';
    $subitem = '<li><a %s > %s </a></li>';
    $subparent = '<li>
                    <a href="javascript: void(0);">
                        %s
                        <span>  %s </span>
                        <span class="menu-arrow"></span>
                    </a>%s
                </li>';
    $subtag = '<ul>';

    $grandtag = '<ul class="nav-second-level" aria-expanded="false">';

    $menustring =  \App\Helpers\Util::clearYaml()
        ->loadResYaml( $nav_file,$nav_path )
        ->loadResYaml( 'nav','views/partials/app/obj', true )
        ->toMenu($section, $menuitem, $subparent ,$subitem,$grandtag, $grandtag);
    print $menustring ;
    ?>
</ul>

<script>
    $(document).ready(function(){


    });
</script>
