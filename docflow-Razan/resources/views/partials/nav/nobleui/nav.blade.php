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

        $menuChild = \App\Helpers\App\DwfUtil::getArchiveMenu();


        $arsipMenu = [
            [
                'title'=> 'Arsip Naskah Dinas',
                'auth'=> 'dwf-archive-naskah-dinas-menu',
                'icon'=> "<i data-feather=\"message-square\" class=\"fa fa-comment-dots uil-comment-alt-exclamation  link-icon\"></i>",
                'children'=> [
                    [
                        'title'=> 'Arsip Surat Dinas',
                        'auth'=> 'dwf-archive-02',
                        'icon'=> "<i class=\"link-icon\"  data-feather=\"file-text\"></i>",
                        'children'=> \App\Helpers\App\DwfUtil::getArchiveOneLevelMenu('02')?? []
                    ],
                    [
                        'title'=> 'Arsip Nota Dinas',
                        'auth'=> 'dwf-archive-03',
                        'icon'=> "<i class=\"link-icon\"  data-feather=\"file-text\"></i>",
                        'children'=> \App\Helpers\App\DwfUtil::getArchiveOneLevelMenu('03')?? []
                    ],
                    [
                        'title'=> 'Arsip Disposisi',
                        'auth'=> 'dwf-archive-04',
                        'icon'=> "<i class=\"link-icon\"  data-feather=\"file-text\"></i>",
                        'children'=> \App\Helpers\App\DwfUtil::getArchiveOneLevelMenu('04')?? []
                    ],
                    [
                        'title'=> 'Arsip Memo Internal',
                        'auth'=> 'dwf-archive-05',
                        'icon'=> "<i class=\"link-icon\"  data-feather=\"file-text\"></i>",
                        'children'=> \App\Helpers\App\DwfUtil::getArchiveOneLevelMenu('05')?? []
                    ],
                    [
                        'title'=> 'Data Referensi',
                        'auth'=> 'dwf-archive-option-menu',
                        'icon'=> "<i class=\"link-icon\"  data-feather=\"file-text\"></i>",
                        'children'=> [
                            [
                                'title'=> 'Jenis Arsip',
                                'auth'=> 'dwf-archive-type',
                                'url'=> 'dwf/admin/archive-type',
                                'icon'=> "<i class=\"link-icon\"  data-feather=\"grid\"></i>",
                            ],
                            [
                                'title'=> 'Jenis Dokumen Arsip',
                                'auth'=> 'dwf-archive-type',
                                'url'=> 'dwf/admin/archive-doc-type',
                                'icon'=> "<i class=\"link-icon\"  data-feather=\"grid\"></i>",
                            ],
                            [
                                'title'=> 'Group Dokumen Arsip',
                                'auth'=> 'dwf-archive-type',
                                'url'=> 'dwf/admin/archive-group',
                                'icon'=> "<i class=\"link-icon\"  data-feather=\"grid\"></i>",
                            ],
                            [
                                'title'=> 'Lokasi Arsip',
                                'auth'=> 'dwf-archive-type',
                                'url'=> 'dwf/admin/archive-location',
                                'icon'=> "<i class=\"link-icon\"  data-feather=\"grid\"></i>",
                            ],
                        ]
                    ],
                ]
            ],
            [
                'title'=> 'Arsip Dok Perusahaan',
                'auth'=> 'dwf-archive-dokumen-perusahaan',
                'icon'=> "<i data-feather=\"message-square\" class=\"fa fa-comment-dots uil-comment-alt-exclamation  link-icon\"></i>",
                'children'=> $menuChild['01']?? []
            ],
        ];

        //print_r($arsipMenu);

        if( isset($nav_file) && isset($nav_path) ){

            $menustring =  \App\Helpers\Util::clearYaml()
                ->loadResYaml( $nav_file,$nav_path );

            $menustring = \App\Helpers\Util::appendMenuArray( $arsipMenu);

            $menustring = $menustring->toMenu($section, $menuitem, $subparent ,$subitem,$grandtag, $grandtag);

            //dynamic menu
            print $menustring ;

            $menustring = null;
            if(env('WITH_MMS', false)){
                if(is_null($menustring)){
                    $menustring =  \App\Helpers\Util::clearYaml()
                        ->loadResYaml( 'nav','views/partials/app/mms', true );
                }else{
                    $menustring = $menustring->loadResYaml( 'nav','views/partials/app/mms', true );
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
            if(env('WITH_WORKFLOW', false)){
                if(is_null($menustring)){
                    $menustring =  \App\Helpers\Util::clearYaml()
                        ->loadResYaml( 'nav','views/partials/app/workflow', true );
                }else{
                    $menustring = $menustring->loadResYaml( 'nav','views/partials/app/workflow', true );
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
            if(env('WITH_DCS', true)){
                if(is_null($menustring)){
                    $menustring =  \App\Helpers\Util::clearYaml()
                        ->loadResYaml( 'nav','views/partials/app/dcs', true );
                }else{
                    $menustring = $menustring->loadResYaml( 'nav','views/partials/app/dcs', true );
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
