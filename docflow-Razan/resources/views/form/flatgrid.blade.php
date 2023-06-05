<?php
$row = 1;
?>
@foreach( $grid as $r )
    <div class="row">
        <?php
        $col = 1;
        ?>

        @foreach( $r['col'] as $w )
            <div class="col-lg-{{ $w  }} col-sm-12">
                @foreach( \App\Helpers\Util::loadResYaml($yml_file,$res_path)->toForm($col, $row, $is_create) as $field )
                    {!! $field !!}
                @endforeach
            </div>
            <?php
            $col++;
            ?>
        @endforeach
    </div>

    <?php
    $row++;
    ?>
@endforeach
