<?php

    $customThemeTemplate = "{
        'common.bi.image': 'https://uicdn.toast.com/toastui/img/tui-image-editor-bi.png',
        'common.bisize.width': '150px',
        'common.bisize.height': '15px',
        'common.backgroundImage': 'none',
        'common.backgroundColor': '#ffffff',
        'common.border': '0px',

        // header
        'header.backgroundImage': 'none',
        'header.backgroundColor': 'transparent',
        'header.border': '0px',

        // load button
        'loadButton.backgroundColor': '#fff',
        'loadButton.border': '1px solid #ddd',
        'loadButton.color': '#222',
        'loadButton.fontFamily': 'NotoSans, sans-serif',
        'loadButton.fontSize': '12px',

        // download button
        'downloadButton.backgroundColor': '#fdba3b',
        'downloadButton.border': '1px solid #fdba3b',
        'downloadButton.color': '#fff',
        'downloadButton.fontFamily': 'NotoSans, sans-serif',
        'downloadButton.fontSize': '12px',

        // main icons
        'menu.normalIcon.path': '%s',
        'menu.normalIcon.name': 'icon-b',
        'menu.activeIcon.path': '%s',
        'menu.activeIcon.name': 'icon-a',
        'menu.iconSize.width': '24px',
        'menu.iconSize.height': '24px',

        // submenu primary color
        'submenu.backgroundColor': '#1e1e1e',
        'submenu.partition.color': '#858585',

        // submenu icons
        'submenu.normalIcon.path': '%s',
        'submenu.normalIcon.name': 'icon-a',
        'submenu.activeIcon.path': '%s',
        'submenu.activeIcon.name': 'icon-c',
        'submenu.iconSize.width': '32px',
        'submenu.iconSize.height': '32px',

        // submenu labels
        'submenu.normalLabel.color': '#858585',
        'submenu.normalLabel.fontWeight': 'lighter',
        'submenu.activeLabel.color': '#fff',
        'submenu.activeLabel.fontWeight': 'lighter',

        // checkbox style
        'checkbox.border': '1px solid #ccc',
        'checkbox.backgroundColor': '#fff',

        // rango style
        'range.pointer.color': '#fff',
        'range.bar.color': '#666',
        'range.subbar.color': '#d1d1d1',
        'range.value.color': '#fff',
        'range.value.fontWeight': 'lighter',
        'range.value.fontSize': '11px',
        'range.value.border': '1px solid #353535',
        'range.value.backgroundColor': '#151515',
        'range.title.color': '#fff',
        'range.title.fontWeight': 'lighter',

        // colorpicker style
        'colorpicker.button.border': '1px solid #1e1e1e',
        'colorpicker.title.color': '#fff'
    }";

$icona = url('images/vendor/tui-image-editor/dist/svg/icon-a.svg');
$iconb = url('images/vendor/tui-image-editor/dist/svg/icon-b.svg');
$iconc = url('images/vendor/tui-image-editor/dist/svg/icon-c.svg');

$customTheme = sprintf( $customThemeTemplate, $iconb, $icona, $icona, $iconc );

?>

<label for="{{ $form['model'] }}" >{{ $label }}</label><br>
<adv-image-editor
    :custom-theme="{!! $customTheme !!}"
    style="height: 800px;"
    v-model="{{ $form['model'] }}"
    @if(isset( $form['attr'] ))
        @foreach($form['attr'] as $at=>$val)
            {{ $at }}="{{ $val }}"
        @endforeach
    @endif
></adv-image-editor>

