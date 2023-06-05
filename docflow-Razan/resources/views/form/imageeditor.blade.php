
<link type="text/css" href="https://uicdn.toast.com/tui-color-picker/v2.2.3/tui-color-picker.css" rel="stylesheet">
<link rel="stylesheet" href="https://uicdn.toast.com/tui-image-editor/latest/tui-image-editor.css">
<link type="text/css" href="{{ url('tui') }}/css/service-basic.css" rel="stylesheet">

<style>
    .close{ font-size: 16px;}
</style>

<div class="image-editor-body-container" >
    <div class="row">
        <div class="col-12">
            <div class="tui-image-editor-controls">
                <ul class="menu">
                    <li class="menu-item  btn btn-primary input-wrapper">
                        <i class="fa fa-folder-open"></i> Load
                        <input type="file" accept="image/*" id="input-image-file">
                    </li>
                    <li class="menu-item btn btn-primary" id="btn-download"><i class="fa fa-save"></i> Save</li>
                    <li class="menu-item btn btn-secondary" id="btn-undo"><i class="fa fa-undo"></i> Undo</li>
                    <li class="menu-item btn btn-secondary disabled" id="btn-redo"><i class="fa fa-redo"></i> Redo</li>
                    <li class="menu-item btn btn-secondary" id="btn-clear-objects"><i class="fa fa-trash"></i> Clear All</li>
                    <li class="menu-item btn btn-secondary" id="btn-remove-active-object"><i class="fa fa-remove"></i> Remove Object</li>
                    <li class="menu-item btn btn-secondary" id="btn-crop"><i class="fa fa-crop"></i> Crop</li>
                    <li class="menu-item btn btn-secondary" id="btn-flip"><i class="fa fa-"></i> Flip</li>
                    <li class="menu-item btn btn-secondary" id="btn-rotation"><i class="fa fa-sync"></i> Rotation</li>
                    <li class="menu-item btn btn-secondary" id="btn-draw-line"><i class="fa fa-pencil-alt"></i> Draw</li>
                    <li class="menu-item btn btn-secondary" id="btn-draw-shape"><i class="fa fa-draw-polygon"></i> Shape</li>
                    <li class="menu-item btn btn-secondary" id="btn-add-icon"><i class="fa fa-picture-o"></i> Icon</li>
                    <li class="menu-item btn btn-secondary" id="btn-text"><i class="fa fa-font"></i> Text</li>
                    {{--<li class="menu-item" id="btn-mask-filter">Mask</li>--}}
                    {{--<li class="menu-item" id="btn-image-filter">Filter</li>--}}
                </ul>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12" >
                        <div class="sub-menu-container" id="crop-sub-menu" style="display: none;">
                            <ul class="menu">
                                <li class="menu-item btn btn-secondary" id="btn-apply-crop">Apply</li>
                                <li class="menu-item btn btn-secondary" id="btn-cancel-crop">Cancel</li>
                            </ul>
                        </div>
                        <div class="sub-menu-container" id="flip-sub-menu">
                            <ul class="menu">
                                <li class="menu-item btn btn-secondary" id="btn-flip-x">Flip X</li>
                                <li class="menu-item btn btn-secondary" id="btn-flip-y">Flip Y</li>
                                <li class="menu-item btn btn-secondary" id="btn-reset-flip">Reset</li>
                                <li class="menu-item btn btn-secondary btn-sm close">Close</li>
                            </ul>
                        </div>
                        <div class="sub-menu-container" id="rotation-sub-menu" style="display: none;">
                            <ul class="vertical-menu">
                                <li class="menu-item btn btn-secondary" id="btn-rotate-clockwise"><i class="fa fa-rotate-left"></i> 30 deg</li>
                                <li class="menu-item btn btn-secondary" id="btn-rotate-counter-clockwise"><i class="fa fa-rotate-right"></i> -30 deg</li>
                                <li class="menu-item no-pointer"><label>Set Rotation</label>
                                        <input class="btn btn-secondary" id="input-rotation-range" type="range" min="-360" value="0" max="360"></li>
                                <li class="menu-item btn close btn btn-secondary btn-sm">Close</li>
                            </ul>
                        </div>
                        <div class="sub-menu-container menu" id="draw-line-sub-menu" style="display: none;">
                            <ul class="menu">
                                <li class="menu-item">
                                    <label><input type="radio" name="select-line-type" value="freeDrawing" checked="checked"> Free drawing</label>
                                    <label><input type="radio" name="select-line-type" value="lineDrawing"> Straight line</label>
                                </li>
                                <li class="menu-item">
                                    <div id="tui-brush-color-picker">Brush color<div class="tui-colorpicker-container tui-view-1"><div class="tui-colorpicker-palette-container tui-view-2"><ul class="tui-colorpicker-clearfix"><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#181818;color:#181818" title="#181818" value="#181818"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#282828;color:#282828" title="#282828" value="#282828"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#383838;color:#383838" title="#383838" value="#383838"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#585858;color:#585858" title="#585858" value="#585858"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#b8b8b8;color:#b8b8b8" title="#b8b8b8" value="#b8b8b8"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#d8d8d8;color:#d8d8d8" title="#d8d8d8" value="#d8d8d8"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#e8e8e8;color:#e8e8e8" title="#e8e8e8" value="#e8e8e8"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#f8f8f8;color:#f8f8f8" title="#f8f8f8" value="#f8f8f8"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#ab4642;color:#ab4642" title="#ab4642" value="#ab4642"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#dc9656;color:#dc9656" title="#dc9656" value="#dc9656"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#f7ca88;color:#f7ca88" title="#f7ca88" value="#f7ca88"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#a1b56c;color:#a1b56c" title="#a1b56c" value="#a1b56c"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#86c1b9;color:#86c1b9" title="#86c1b9" value="#86c1b9"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#7cafc2;color:#7cafc2" title="#7cafc2" value="#7cafc2"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#ba8baf;color:#ba8baf" title="#ba8baf" value="#ba8baf"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#a16946;color:#a16946" title="#a16946" value="#a16946"></li></ul>
                                                <div class="tui-colorpicker-clearfix" style="overflow:hidden">
                                                    <input type="button" class="tui-colorpicker-palette-toggle-slider" value="Detail">
                                                    <input type="text" class="tui-colorpicker-palette-hex" value="#000000" maxlength="7">
                                                    <span class="tui-colorpicker-palette-preview" style="background-color:#000000;color:#000000">#000000</span>
                                                </div></div><div class="tui-colorpicker-slider-container tui-view-3" style="display: none;"><div class="tui-colorpicker-slider-left tui-colorpicker-slider-part"><svg class="tui-colorpicker-svg tui-colorpicker-svg-slider">
                                                        <defs>
                                                            <lineargradient id="tui-colorpicker-svg-fill-color" x1="0%" y1="0%" x2="100%" y2="0%">
                                                                <stop offset="0%" stop-color="rgb(255,255,255)"></stop>
                                                                <stop class="tui-colorpicker-slider-basecolor" offset="100%" stop-color="#ff0000"></stop>
                                                            </lineargradient>
                                                            <lineargradient id="tui-colorpicker-svn-fill-black" x1="0%" y1="0%" x2="0%" y2="100%">
                                                                <stop offset="0%" style="stop-color:rgb(0,0,0);stop-opacity:0"></stop>
                                                                <stop offset="100%" style="stop-color:rgb(0,0,0);stop-opacity:1"></stop>
                                                            </lineargradient>
                                                        </defs>
                                                        <rect width="100%" height="100%" fill="url(#tui-colorpicker-svg-fill-color)"></rect>
                                                        <rect width="100%" height="100%" fill="url(#tui-colorpicker-svn-fill-black)"></rect>
                                                        <path transform="translate(-7,105)" class="tui-colorpicker-slider-handle" d="M0 7.5 L15 7.5 M7.5 15 L7.5 0 M2 7 a5.5 5.5 0 1 1 0 1 Z" stroke="white" stroke-width="0.75" fill="none"></path>
                                                    </svg></div>
                                                <div class="tui-colorpicker-slider-right tui-colorpicker-slider-part"><svg class="tui-colorpicker-svg tui-colorpicker-svg-huebar">
                                                        <defs>
                                                            <lineargradient id="g" x1="0%" y1="0%" x2="0%" y2="100%">
                                                                <stop offset="0%" stop-color="rgb(255,0,0)"></stop>
                                                                <stop offset="16.666%" stop-color="rgb(255,255,0)"></stop>
                                                                <stop offset="33.333%" stop-color="rgb(0,255,0)"></stop>
                                                                <stop offset="50%" stop-color="rgb(0,255,255)"></stop>
                                                                <stop offset="66.666%" stop-color="rgb(0,0,255)"></stop>
                                                                <stop offset="83.333%" stop-color="rgb(255,0,255)"></stop>
                                                                <stop offset="100%" stop-color="rgb(255,0,0)"></stop>
                                                            </lineargradient>
                                                        </defs>
                                                        <rect width="18px" height="100%" fill="url(#g)"></rect>
                                                        <path transform="translate(-6,-3)" class="tui-colorpicker-huebar-handle" d="M0 0 L4 4 L0 8 L0 0 Z" fill="black" stroke="none"></path>
                                                    </svg></div></div></div></div>
                                </li>
                                <li class="menu-item"><label class="menu-item no-pointer">Brush width<input id="input-brush-width-range" type="range" min="5" max="30" value="12"></label></li>
                                <li class="menu-item close btn btn-secondary btn-sm">Close</li>
                            </ul>
                        </div>
                        <div class="sub-menu-container" id="draw-shape-sub-menu" style="display: none;">
                            <ul class="menu">
                                <li class="menu-item">
                                    <label><input type="radio" name="select-shape-type" value="rect" checked="checked"> rect</label>
                                    <label><input type="radio" name="select-shape-type" value="circle"> circle</label>
                                    <label><input type="radio" name="select-shape-type" value="triangle"> triangle</label>
                                </li>
                                <li class="menu-item">
                                    <select name="select-color-type">
                                        <option value="fill">Fill</option>
                                        <option value="stroke">Stroke</option>
                                    </select>
                                    <label><input type="checkbox" id="input-check-transparent">transparent</label>
                                    <div id="tui-shape-color-picker"><div class="tui-colorpicker-container tui-view-12"><div class="tui-colorpicker-palette-container tui-view-13"><ul class="tui-colorpicker-clearfix"><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#181818;color:#181818" title="#181818" value="#181818"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#282828;color:#282828" title="#282828" value="#282828"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#383838;color:#383838" title="#383838" value="#383838"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#585858;color:#585858" title="#585858" value="#585858"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#b8b8b8;color:#b8b8b8" title="#b8b8b8" value="#b8b8b8"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#d8d8d8;color:#d8d8d8" title="#d8d8d8" value="#d8d8d8"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#e8e8e8;color:#e8e8e8" title="#e8e8e8" value="#e8e8e8"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#f8f8f8;color:#f8f8f8" title="#f8f8f8" value="#f8f8f8"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#ab4642;color:#ab4642" title="#ab4642" value="#ab4642"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#dc9656;color:#dc9656" title="#dc9656" value="#dc9656"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#f7ca88;color:#f7ca88" title="#f7ca88" value="#f7ca88"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#a1b56c;color:#a1b56c" title="#a1b56c" value="#a1b56c"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#86c1b9;color:#86c1b9" title="#86c1b9" value="#86c1b9"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#7cafc2;color:#7cafc2" title="#7cafc2" value="#7cafc2"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#ba8baf;color:#ba8baf" title="#ba8baf" value="#ba8baf"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#a16946;color:#a16946" title="#a16946" value="#a16946"></li></ul>
                                                <div class="tui-colorpicker-clearfix" style="overflow:hidden">
                                                    <input type="button" class="tui-colorpicker-palette-toggle-slider" value="Detail">
                                                    <input type="text" class="tui-colorpicker-palette-hex" value="#000000" maxlength="7">
                                                    <span class="tui-colorpicker-palette-preview" style="background-color:#000000;color:#000000">#000000</span>
                                                </div></div><div class="tui-colorpicker-slider-container tui-view-14" style="display: none;"><div class="tui-colorpicker-slider-left tui-colorpicker-slider-part"><svg class="tui-colorpicker-svg tui-colorpicker-svg-slider">
                                                        <defs>
                                                            <lineargradient id="tui-colorpicker-svg-fill-color" x1="0%" y1="0%" x2="100%" y2="0%">
                                                                <stop offset="0%" stop-color="rgb(255,255,255)"></stop>
                                                                <stop class="tui-colorpicker-slider-basecolor" offset="100%" stop-color="#ff0000"></stop>
                                                            </lineargradient>
                                                            <lineargradient id="tui-colorpicker-svn-fill-black" x1="0%" y1="0%" x2="0%" y2="100%">
                                                                <stop offset="0%" style="stop-color:rgb(0,0,0);stop-opacity:0"></stop>
                                                                <stop offset="100%" style="stop-color:rgb(0,0,0);stop-opacity:1"></stop>
                                                            </lineargradient>
                                                        </defs>
                                                        <rect width="100%" height="100%" fill="url(#tui-colorpicker-svg-fill-color)"></rect>
                                                        <rect width="100%" height="100%" fill="url(#tui-colorpicker-svn-fill-black)"></rect>
                                                        <path transform="translate(-7,105)" class="tui-colorpicker-slider-handle" d="M0 7.5 L15 7.5 M7.5 15 L7.5 0 M2 7 a5.5 5.5 0 1 1 0 1 Z" stroke="white" stroke-width="0.75" fill="none"></path>
                                                    </svg></div>
                                                <div class="tui-colorpicker-slider-right tui-colorpicker-slider-part"><svg class="tui-colorpicker-svg tui-colorpicker-svg-huebar">
                                                        <defs>
                                                            <lineargradient id="g" x1="0%" y1="0%" x2="0%" y2="100%">
                                                                <stop offset="0%" stop-color="rgb(255,0,0)"></stop>
                                                                <stop offset="16.666%" stop-color="rgb(255,255,0)"></stop>
                                                                <stop offset="33.333%" stop-color="rgb(0,255,0)"></stop>
                                                                <stop offset="50%" stop-color="rgb(0,255,255)"></stop>
                                                                <stop offset="66.666%" stop-color="rgb(0,0,255)"></stop>
                                                                <stop offset="83.333%" stop-color="rgb(255,0,255)"></stop>
                                                                <stop offset="100%" stop-color="rgb(255,0,0)"></stop>
                                                            </lineargradient>
                                                        </defs>
                                                        <rect width="18px" height="100%" fill="url(#g)"></rect>
                                                        <path transform="translate(-6,-3)" class="tui-colorpicker-huebar-handle" d="M0 0 L4 4 L0 8 L0 0 Z" fill="black" stroke="none"></path>
                                                    </svg></div></div></div></div>
                                </li>
                                <li class="menu-item"><label class="menu-item no-pointer">Stroke width<input id="input-stroke-width-range" type="range" min="0" max="300" value="12"></label></li>
                                <li class="menu-item close btn btn-secondary btn-sm">Close</li>
                            </ul>
                        </div>
                        <div class="sub-menu-container" id="icon-sub-menu" style="display: none;">
                            <ul class="menu">
                                <li class="menu-item">
                                    <div id="tui-icon-color-picker">Icon color<div class="tui-colorpicker-container tui-view-16"><div class="tui-colorpicker-palette-container tui-view-17"><ul class="tui-colorpicker-clearfix"><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#181818;color:#181818" title="#181818" value="#181818"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#282828;color:#282828" title="#282828" value="#282828"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#383838;color:#383838" title="#383838" value="#383838"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#585858;color:#585858" title="#585858" value="#585858"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#b8b8b8;color:#b8b8b8" title="#b8b8b8" value="#b8b8b8"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#d8d8d8;color:#d8d8d8" title="#d8d8d8" value="#d8d8d8"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#e8e8e8;color:#e8e8e8" title="#e8e8e8" value="#e8e8e8"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#f8f8f8;color:#f8f8f8" title="#f8f8f8" value="#f8f8f8"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#ab4642;color:#ab4642" title="#ab4642" value="#ab4642"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#dc9656;color:#dc9656" title="#dc9656" value="#dc9656"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#f7ca88;color:#f7ca88" title="#f7ca88" value="#f7ca88"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#a1b56c;color:#a1b56c" title="#a1b56c" value="#a1b56c"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#86c1b9;color:#86c1b9" title="#86c1b9" value="#86c1b9"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#7cafc2;color:#7cafc2" title="#7cafc2" value="#7cafc2"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#ba8baf;color:#ba8baf" title="#ba8baf" value="#ba8baf"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#a16946;color:#a16946" title="#a16946" value="#a16946"></li></ul>
                                                <div class="tui-colorpicker-clearfix" style="overflow:hidden">
                                                    <input type="button" class="tui-colorpicker-palette-toggle-slider" value="Detail">
                                                    <input type="text" class="tui-colorpicker-palette-hex" value="#000000" maxlength="7">
                                                    <span class="tui-colorpicker-palette-preview" style="background-color:#000000;color:#000000">#000000</span>
                                                </div></div><div class="tui-colorpicker-slider-container tui-view-18" style="display: none;"><div class="tui-colorpicker-slider-left tui-colorpicker-slider-part"><svg class="tui-colorpicker-svg tui-colorpicker-svg-slider">
                                                        <defs>
                                                            <lineargradient id="tui-colorpicker-svg-fill-color" x1="0%" y1="0%" x2="100%" y2="0%">
                                                                <stop offset="0%" stop-color="rgb(255,255,255)"></stop>
                                                                <stop class="tui-colorpicker-slider-basecolor" offset="100%" stop-color="#ff0000"></stop>
                                                            </lineargradient>
                                                            <lineargradient id="tui-colorpicker-svn-fill-black" x1="0%" y1="0%" x2="0%" y2="100%">
                                                                <stop offset="0%" style="stop-color:rgb(0,0,0);stop-opacity:0"></stop>
                                                                <stop offset="100%" style="stop-color:rgb(0,0,0);stop-opacity:1"></stop>
                                                            </lineargradient>
                                                        </defs>
                                                        <rect width="100%" height="100%" fill="url(#tui-colorpicker-svg-fill-color)"></rect>
                                                        <rect width="100%" height="100%" fill="url(#tui-colorpicker-svn-fill-black)"></rect>
                                                        <path transform="translate(-7,105)" class="tui-colorpicker-slider-handle" d="M0 7.5 L15 7.5 M7.5 15 L7.5 0 M2 7 a5.5 5.5 0 1 1 0 1 Z" stroke="white" stroke-width="0.75" fill="none"></path>
                                                    </svg></div>
                                                <div class="tui-colorpicker-slider-right tui-colorpicker-slider-part"><svg class="tui-colorpicker-svg tui-colorpicker-svg-huebar">
                                                        <defs>
                                                            <lineargradient id="g" x1="0%" y1="0%" x2="0%" y2="100%">
                                                                <stop offset="0%" stop-color="rgb(255,0,0)"></stop>
                                                                <stop offset="16.666%" stop-color="rgb(255,255,0)"></stop>
                                                                <stop offset="33.333%" stop-color="rgb(0,255,0)"></stop>
                                                                <stop offset="50%" stop-color="rgb(0,255,255)"></stop>
                                                                <stop offset="66.666%" stop-color="rgb(0,0,255)"></stop>
                                                                <stop offset="83.333%" stop-color="rgb(255,0,255)"></stop>
                                                                <stop offset="100%" stop-color="rgb(255,0,0)"></stop>
                                                            </lineargradient>
                                                        </defs>
                                                        <rect width="18px" height="100%" fill="url(#g)"></rect>
                                                        <path transform="translate(-6,-3)" class="tui-colorpicker-huebar-handle" d="M0 0 L4 4 L0 8 L0 0 Z" fill="black" stroke="none"></path>
                                                    </svg></div></div></div></div>
                                </li>
                                <li class="menu-item border" id="btn-register-icon">Register custom icon</li>
                                <li class="menu-item icon-text" data-icon-type="arrow">➡</li>
                                <li class="menu-item icon-text" data-icon-type="cancel">✖</li><li id="customArrow" class="menu-item icon-text" data-icon-type="customArrow">↑</li>
                                <li class="menu-item close btn btn-secondary btn-sm">Close</li>
                            </ul>
                        </div>
                        <div class="sub-menu-container" id="text-sub-menu">
                            <ul class="menu">
                                <li class="menu-item"><button class="btn-text-style btn btn-secondary" data-style-type="b"><i class="fa fa-bold"></i></button></li>
                                <li class="menu-item"><button class="btn-text-style btn btn-secondary" data-style-type="i"><i class="fa fa-italic"></i></button></li>
                                <li class="menu-item"><button class="btn-text-style btn btn-secondary" data-style-type="u"><i class="fa fa-underline"></i></button></li>
                                <li class="menu-item"><button class="btn-text-style btn btn-secondary" data-style-type="l"><i class="fa fa-align-left"></i></button></li>
                                <li class="menu-item"><button class="btn-text-style btn btn-secondary" data-style-type="c"><i class="fa fa-align-center"></i></button></li>
                                <li class="menu-item"><button class="btn-text-style btn btn-secondary" data-style-type="r"><i class="fa fa-align-right"></i></button></li>
                                <li class="menu-item"><label class="no-pointer"><input id="input-font-size-range" type="range" min="10" max="100" value="10"></label></li>
                                <li class="menu-item">
                                    <div id="tui-text-color-picker">Text color<div class="tui-colorpicker-container tui-view-8">
                                            <div class="tui-colorpicker-palette-container tui-view-9"><ul class="tui-colorpicker-clearfix"><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#181818;color:#181818" title="#181818" value="#181818"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#282828;color:#282828" title="#282828" value="#282828"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#383838;color:#383838" title="#383838" value="#383838"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#585858;color:#585858" title="#585858" value="#585858"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#b8b8b8;color:#b8b8b8" title="#b8b8b8" value="#b8b8b8"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#d8d8d8;color:#d8d8d8" title="#d8d8d8" value="#d8d8d8"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#e8e8e8;color:#e8e8e8" title="#e8e8e8" value="#e8e8e8"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#f8f8f8;color:#f8f8f8" title="#f8f8f8" value="#f8f8f8"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#ab4642;color:#ab4642" title="#ab4642" value="#ab4642"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#dc9656;color:#dc9656" title="#dc9656" value="#dc9656"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#f7ca88;color:#f7ca88" title="#f7ca88" value="#f7ca88"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#a1b56c;color:#a1b56c" title="#a1b56c" value="#a1b56c"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#86c1b9;color:#86c1b9" title="#86c1b9" value="#86c1b9"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#7cafc2;color:#7cafc2" title="#7cafc2" value="#7cafc2"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#ba8baf;color:#ba8baf" title="#ba8baf" value="#ba8baf"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#a16946;color:#a16946" title="#a16946" value="#a16946"></li></ul>
                                                <div class="tui-colorpicker-clearfix" style="overflow:hidden">
                                                    <input type="button" class="tui-colorpicker-palette-toggle-slider" value="Detail">
                                                    <input type="text" class="tui-colorpicker-palette-hex" value="#000000" maxlength="7">
                                                    <span class="tui-colorpicker-palette-preview" style="background-color:#000000;color:#000000">#000000</span>
                                                </div>
                                            </div>
                                            <div class="tui-colorpicker-slider-container tui-view-10" style="display: none;">
                                                <div class="tui-colorpicker-slider-left tui-colorpicker-slider-part">
                                                    <svg class="tui-colorpicker-svg tui-colorpicker-svg-slider">
                                                        <defs>
                                                            <lineargradient id="tui-colorpicker-svg-fill-color" x1="0%" y1="0%" x2="100%" y2="0%">
                                                                <stop offset="0%" stop-color="rgb(255,255,255)"></stop>
                                                                <stop class="tui-colorpicker-slider-basecolor" offset="100%" stop-color="#ff0000"></stop>
                                                            </lineargradient>
                                                            <lineargradient id="tui-colorpicker-svn-fill-black" x1="0%" y1="0%" x2="0%" y2="100%">
                                                                <stop offset="0%" style="stop-color:rgb(0,0,0);stop-opacity:0"></stop>
                                                                <stop offset="100%" style="stop-color:rgb(0,0,0);stop-opacity:1"></stop>
                                                            </lineargradient>
                                                        </defs>
                                                        <rect width="100%" height="100%" fill="url(#tui-colorpicker-svg-fill-color)"></rect>
                                                        <rect width="100%" height="100%" fill="url(#tui-colorpicker-svn-fill-black)"></rect>
                                                        <path transform="translate(-7,105)" class="tui-colorpicker-slider-handle" d="M0 7.5 L15 7.5 M7.5 15 L7.5 0 M2 7 a5.5 5.5 0 1 1 0 1 Z" stroke="white" stroke-width="0.75" fill="none"></path>
                                                    </svg>
                                                </div>
                                                <div class="tui-colorpicker-slider-right tui-colorpicker-slider-part">
                                                    <svg class="tui-colorpicker-svg tui-colorpicker-svg-huebar">
                                                        <defs>
                                                            <lineargradient id="g" x1="0%" y1="0%" x2="0%" y2="100%">
                                                                <stop offset="0%" stop-color="rgb(255,0,0)"></stop>
                                                                <stop offset="16.666%" stop-color="rgb(255,255,0)"></stop>
                                                                <stop offset="33.333%" stop-color="rgb(0,255,0)"></stop>
                                                                <stop offset="50%" stop-color="rgb(0,255,255)"></stop>
                                                                <stop offset="66.666%" stop-color="rgb(0,0,255)"></stop>
                                                                <stop offset="83.333%" stop-color="rgb(255,0,255)"></stop>
                                                                <stop offset="100%" stop-color="rgb(255,0,0)"></stop>
                                                            </lineargradient>
                                                        </defs>
                                                        <rect width="18px" height="100%" fill="url(#g)"></rect>
                                                        <path transform="translate(-6,-3)" class="tui-colorpicker-huebar-handle" d="M0 0 L4 4 L0 8 L0 0 Z" fill="black" stroke="none"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="menu-item close btn btn-secondary btn-sm">Close</li>
                            </ul>
                        </div>
                        <div class="sub-menu-container" id="filter-sub-menu">
                            <ul class="menu">
                                <li class="menu-item border input-wrapper">
                                    Load Mask Image
                                    <input type="file" accept="image/*" id="input-mask-image-file">
                                </li>
                                <li class="menu-item" id="btn-apply-mask">Apply mask filter</li>
                                <li class="menu-item close btn btn-secondary btn-sm">Close</li>
                            </ul>
                        </div>
                        <div class="sub-menu-container" id="image-filter-sub-menu">
                            <ul class="menu">
                                <li class="menu-item align-left-top">
                                    <table>
                                        <tbody>
                                        <tr>
                                            <td><label><input type="checkbox" id="input-check-grayscale">Grayscale</label></td>
                                            <td><label><input type="checkbox" id="input-check-invert">Invert</label></td>
                                            <td><label><input type="checkbox" id="input-check-sepia">Sepia</label></td>
                                        </tr>
                                        <tr>
                                            <td><label><input type="checkbox" id="input-check-sepia2">Sepia2</label></td>
                                            <td><label><input type="checkbox" id="input-check-blur">Blur</label></td>
                                            <td><label><input type="checkbox" id="input-check-sharpen">Sharpen</label></td>
                                        </tr>
                                        <tr>
                                            <td><label><input type="checkbox" id="input-check-emboss">Emboss</label></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </li>
                                <li class="menu-item align-left-top">
                                    <p>
                                        <label><input type="checkbox" id="input-check-remove-white">RemoveWhite</label><br>
                                        <label>Threshold<input class="range-narrow" id="input-range-remove-white-threshold" type="range" min="0" value="60" max="255"></label><br>
                                        <label>Distance<input class="range-narrow" id="input-range-remove-white-distance" type="range" min="0" value="10" max="255"></label>
                                    </p>
                                </li>
                                <li class="menu-item align-left-top">
                                    <p>
                                        <label><input type="checkbox" id="input-check-brightness">Brightness</label><br>
                                        <label>Value<input class="range-narrow" id="input-range-brightness-value" type="range" min="-255" value="100" max="255"></label>
                                    </p>
                                </li>
                                <li class="menu-item align-left-top">
                                    <p>
                                        <label><input type="checkbox" id="input-check-noise">Noise</label><br>
                                        <label>Value<input class="range-narrow" id="input-range-noise-value" type="range" min="0" value="100" max="1000"></label>
                                    </p>
                                </li>
                                <li class="menu-item align-left-top">
                                    <p>
                                        <label><input type="checkbox" id="input-check-color-filter">ColorFilter</label><br>
                                        <label>Threshold<input class="range-narrow" id="input-range-color-filter-value" type="range" min="0" value="45" max="255"></label>
                                    </p>
                                </li>
                                <li class="menu-item align-left-top">
                                    <p>
                                        <label><input type="checkbox" id="input-check-pixelate">Pixelate</label><br>
                                        <label>Value<input class="range-narrow" id="input-range-pixelate-value" type="range" min="2" value="4" max="20"></label>
                                    </p>
                                </li>
                                <li class="menu-item align-left-top">
                                    <p>
                                        <label><input type="checkbox" id="input-check-tint">Tint</label><br>
                                    </p><div id="tui-tint-color-picker"><div class="tui-colorpicker-container tui-view-20"><div class="tui-colorpicker-palette-container tui-view-21"><ul class="tui-colorpicker-clearfix"><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#181818;color:#181818" title="#181818" value="#181818"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#282828;color:#282828" title="#282828" value="#282828"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#383838;color:#383838" title="#383838" value="#383838"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#585858;color:#585858" title="#585858" value="#585858"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#b8b8b8;color:#b8b8b8" title="#b8b8b8" value="#b8b8b8"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#d8d8d8;color:#d8d8d8" title="#d8d8d8" value="#d8d8d8"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#e8e8e8;color:#e8e8e8" title="#e8e8e8" value="#e8e8e8"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#f8f8f8;color:#f8f8f8" title="#f8f8f8" value="#f8f8f8"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#ab4642;color:#ab4642" title="#ab4642" value="#ab4642"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#dc9656;color:#dc9656" title="#dc9656" value="#dc9656"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#f7ca88;color:#f7ca88" title="#f7ca88" value="#f7ca88"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#a1b56c;color:#a1b56c" title="#a1b56c" value="#a1b56c"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#86c1b9;color:#86c1b9" title="#86c1b9" value="#86c1b9"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#7cafc2;color:#7cafc2" title="#7cafc2" value="#7cafc2"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#ba8baf;color:#ba8baf" title="#ba8baf" value="#ba8baf"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#a16946;color:#a16946" title="#a16946" value="#a16946"></li></ul>
                                                <div class="tui-colorpicker-clearfix" style="overflow:hidden">
                                                    <input type="button" class="tui-colorpicker-palette-toggle-slider" value="Detail">
                                                    <input type="text" class="tui-colorpicker-palette-hex" value="#000000" maxlength="7">
                                                    <span class="tui-colorpicker-palette-preview" style="background-color:#000000;color:#000000">#000000</span>
                                                </div></div><div class="tui-colorpicker-slider-container tui-view-22" style="display: none;"><div class="tui-colorpicker-slider-left tui-colorpicker-slider-part"><svg class="tui-colorpicker-svg tui-colorpicker-svg-slider">
                                                        <defs>
                                                            <lineargradient id="tui-colorpicker-svg-fill-color" x1="0%" y1="0%" x2="100%" y2="0%">
                                                                <stop offset="0%" stop-color="rgb(255,255,255)"></stop>
                                                                <stop class="tui-colorpicker-slider-basecolor" offset="100%" stop-color="#ff0000"></stop>
                                                            </lineargradient>
                                                            <lineargradient id="tui-colorpicker-svn-fill-black" x1="0%" y1="0%" x2="0%" y2="100%">
                                                                <stop offset="0%" style="stop-color:rgb(0,0,0);stop-opacity:0"></stop>
                                                                <stop offset="100%" style="stop-color:rgb(0,0,0);stop-opacity:1"></stop>
                                                            </lineargradient>
                                                        </defs>
                                                        <rect width="100%" height="100%" fill="url(#tui-colorpicker-svg-fill-color)"></rect>
                                                        <rect width="100%" height="100%" fill="url(#tui-colorpicker-svn-fill-black)"></rect>
                                                        <path transform="translate(-7,105)" class="tui-colorpicker-slider-handle" d="M0 7.5 L15 7.5 M7.5 15 L7.5 0 M2 7 a5.5 5.5 0 1 1 0 1 Z" stroke="white" stroke-width="0.75" fill="none"></path>
                                                    </svg></div>
                                                <div class="tui-colorpicker-slider-right tui-colorpicker-slider-part"><svg class="tui-colorpicker-svg tui-colorpicker-svg-huebar">
                                                        <defs>
                                                            <lineargradient id="g" x1="0%" y1="0%" x2="0%" y2="100%">
                                                                <stop offset="0%" stop-color="rgb(255,0,0)"></stop>
                                                                <stop offset="16.666%" stop-color="rgb(255,255,0)"></stop>
                                                                <stop offset="33.333%" stop-color="rgb(0,255,0)"></stop>
                                                                <stop offset="50%" stop-color="rgb(0,255,255)"></stop>
                                                                <stop offset="66.666%" stop-color="rgb(0,0,255)"></stop>
                                                                <stop offset="83.333%" stop-color="rgb(255,0,255)"></stop>
                                                                <stop offset="100%" stop-color="rgb(255,0,0)"></stop>
                                                            </lineargradient>
                                                        </defs>
                                                        <rect width="18px" height="100%" fill="url(#g)"></rect>
                                                        <path transform="translate(-6,-3)" class="tui-colorpicker-huebar-handle" d="M0 0 L4 4 L0 8 L0 0 Z" fill="black" stroke="none"></path>
                                                    </svg></div></div></div></div>
                                    <label>Opacity<input class="range-narrow" id="input-range-tint-opacity-value" type="range" min="0" value="1" max="1" step="0.1"></label>
                                    <p></p>
                                </li>
                                <li class="menu-item align-left-top">
                                    <p>
                                        <label><input type="checkbox" id="input-check-multiply">Multiply</label>
                                    </p><div id="tui-multiply-color-picker"><div class="tui-colorpicker-container tui-view-24"><div class="tui-colorpicker-palette-container tui-view-25"><ul class="tui-colorpicker-clearfix"><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#181818;color:#181818" title="#181818" value="#181818"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#282828;color:#282828" title="#282828" value="#282828"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#383838;color:#383838" title="#383838" value="#383838"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#585858;color:#585858" title="#585858" value="#585858"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#b8b8b8;color:#b8b8b8" title="#b8b8b8" value="#b8b8b8"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#d8d8d8;color:#d8d8d8" title="#d8d8d8" value="#d8d8d8"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#e8e8e8;color:#e8e8e8" title="#e8e8e8" value="#e8e8e8"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#f8f8f8;color:#f8f8f8" title="#f8f8f8" value="#f8f8f8"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#ab4642;color:#ab4642" title="#ab4642" value="#ab4642"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#dc9656;color:#dc9656" title="#dc9656" value="#dc9656"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#f7ca88;color:#f7ca88" title="#f7ca88" value="#f7ca88"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#a1b56c;color:#a1b56c" title="#a1b56c" value="#a1b56c"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#86c1b9;color:#86c1b9" title="#86c1b9" value="#86c1b9"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#7cafc2;color:#7cafc2" title="#7cafc2" value="#7cafc2"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#ba8baf;color:#ba8baf" title="#ba8baf" value="#ba8baf"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#a16946;color:#a16946" title="#a16946" value="#a16946"></li></ul>
                                                <div class="tui-colorpicker-clearfix" style="overflow:hidden">
                                                    <input type="button" class="tui-colorpicker-palette-toggle-slider" value="Detail">
                                                    <input type="text" class="tui-colorpicker-palette-hex" value="#000000" maxlength="7">
                                                    <span class="tui-colorpicker-palette-preview" style="background-color:#000000;color:#000000">#000000</span>
                                                </div></div><div class="tui-colorpicker-slider-container tui-view-26" style="display: none;"><div class="tui-colorpicker-slider-left tui-colorpicker-slider-part"><svg class="tui-colorpicker-svg tui-colorpicker-svg-slider">
                                                        <defs>
                                                            <lineargradient id="tui-colorpicker-svg-fill-color" x1="0%" y1="0%" x2="100%" y2="0%">
                                                                <stop offset="0%" stop-color="rgb(255,255,255)"></stop>
                                                                <stop class="tui-colorpicker-slider-basecolor" offset="100%" stop-color="#ff0000"></stop>
                                                            </lineargradient>
                                                            <lineargradient id="tui-colorpicker-svn-fill-black" x1="0%" y1="0%" x2="0%" y2="100%">
                                                                <stop offset="0%" style="stop-color:rgb(0,0,0);stop-opacity:0"></stop>
                                                                <stop offset="100%" style="stop-color:rgb(0,0,0);stop-opacity:1"></stop>
                                                            </lineargradient>
                                                        </defs>
                                                        <rect width="100%" height="100%" fill="url(#tui-colorpicker-svg-fill-color)"></rect>
                                                        <rect width="100%" height="100%" fill="url(#tui-colorpicker-svn-fill-black)"></rect>
                                                        <path transform="translate(-7,105)" class="tui-colorpicker-slider-handle" d="M0 7.5 L15 7.5 M7.5 15 L7.5 0 M2 7 a5.5 5.5 0 1 1 0 1 Z" stroke="white" stroke-width="0.75" fill="none"></path>
                                                    </svg></div>
                                                <div class="tui-colorpicker-slider-right tui-colorpicker-slider-part"><svg class="tui-colorpicker-svg tui-colorpicker-svg-huebar">
                                                        <defs>
                                                            <lineargradient id="g" x1="0%" y1="0%" x2="0%" y2="100%">
                                                                <stop offset="0%" stop-color="rgb(255,0,0)"></stop>
                                                                <stop offset="16.666%" stop-color="rgb(255,255,0)"></stop>
                                                                <stop offset="33.333%" stop-color="rgb(0,255,0)"></stop>
                                                                <stop offset="50%" stop-color="rgb(0,255,255)"></stop>
                                                                <stop offset="66.666%" stop-color="rgb(0,0,255)"></stop>
                                                                <stop offset="83.333%" stop-color="rgb(255,0,255)"></stop>
                                                                <stop offset="100%" stop-color="rgb(255,0,0)"></stop>
                                                            </lineargradient>
                                                        </defs>
                                                        <rect width="18px" height="100%" fill="url(#g)"></rect>
                                                        <path transform="translate(-6,-3)" class="tui-colorpicker-huebar-handle" d="M0 0 L4 4 L0 8 L0 0 Z" fill="black" stroke="none"></path>
                                                    </svg></div></div></div></div>
                                    <p></p>
                                </li>
                                <li class="menu-item align-left-top">
                                    <p>
                                        <label><input type="checkbox" id="input-check-blend">Blend</label>
                                    </p><div id="tui-blend-color-picker"><div class="tui-colorpicker-container tui-view-28"><div class="tui-colorpicker-palette-container tui-view-29"><ul class="tui-colorpicker-clearfix"><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#181818;color:#181818" title="#181818" value="#181818"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#282828;color:#282828" title="#282828" value="#282828"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#383838;color:#383838" title="#383838" value="#383838"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#585858;color:#585858" title="#585858" value="#585858"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#b8b8b8;color:#b8b8b8" title="#b8b8b8" value="#b8b8b8"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#d8d8d8;color:#d8d8d8" title="#d8d8d8" value="#d8d8d8"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#e8e8e8;color:#e8e8e8" title="#e8e8e8" value="#e8e8e8"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#f8f8f8;color:#f8f8f8" title="#f8f8f8" value="#f8f8f8"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#ab4642;color:#ab4642" title="#ab4642" value="#ab4642"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#dc9656;color:#dc9656" title="#dc9656" value="#dc9656"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#f7ca88;color:#f7ca88" title="#f7ca88" value="#f7ca88"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#a1b56c;color:#a1b56c" title="#a1b56c" value="#a1b56c"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#86c1b9;color:#86c1b9" title="#86c1b9" value="#86c1b9"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#7cafc2;color:#7cafc2" title="#7cafc2" value="#7cafc2"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#ba8baf;color:#ba8baf" title="#ba8baf" value="#ba8baf"></li><li><input class="tui-colorpicker-palette-button" type="button" style="background-color:#a16946;color:#a16946" title="#a16946" value="#a16946"></li></ul>
                                                <div class="tui-colorpicker-clearfix" style="overflow:hidden">
                                                    <input type="button" class="tui-colorpicker-palette-toggle-slider" value="Detail">
                                                    <input type="text" class="tui-colorpicker-palette-hex" value="#00FF00" maxlength="7">
                                                    <span class="tui-colorpicker-palette-preview" style="background-color:#00FF00;color:#00FF00">#00FF00</span>
                                                </div></div><div class="tui-colorpicker-slider-container tui-view-30" style="display: none;"><div class="tui-colorpicker-slider-left tui-colorpicker-slider-part"><svg class="tui-colorpicker-svg tui-colorpicker-svg-slider">
                                                        <defs>
                                                            <lineargradient id="tui-colorpicker-svg-fill-color" x1="0%" y1="0%" x2="100%" y2="0%">
                                                                <stop offset="0%" stop-color="rgb(255,255,255)"></stop>
                                                                <stop class="tui-colorpicker-slider-basecolor" offset="100%" stop-color="#00ff00"></stop>
                                                            </lineargradient>
                                                            <lineargradient id="tui-colorpicker-svn-fill-black" x1="0%" y1="0%" x2="0%" y2="100%">
                                                                <stop offset="0%" style="stop-color:rgb(0,0,0);stop-opacity:0"></stop>
                                                                <stop offset="100%" style="stop-color:rgb(0,0,0);stop-opacity:1"></stop>
                                                            </lineargradient>
                                                        </defs>
                                                        <rect width="100%" height="100%" fill="url(#tui-colorpicker-svg-fill-color)"></rect>
                                                        <rect width="100%" height="100%" fill="url(#tui-colorpicker-svn-fill-black)"></rect>
                                                        <path transform="translate(105,-7)" class="tui-colorpicker-slider-handle" d="M0 7.5 L15 7.5 M7.5 15 L7.5 0 M2 7 a5.5 5.5 0 1 1 0 1 Z" stroke="black" stroke-width="0.75" fill="none"></path>
                                                    </svg></div>
                                                <div class="tui-colorpicker-slider-right tui-colorpicker-slider-part"><svg class="tui-colorpicker-svg tui-colorpicker-svg-huebar">
                                                        <defs>
                                                            <lineargradient id="g" x1="0%" y1="0%" x2="0%" y2="100%">
                                                                <stop offset="0%" stop-color="rgb(255,0,0)"></stop>
                                                                <stop offset="16.666%" stop-color="rgb(255,255,0)"></stop>
                                                                <stop offset="33.333%" stop-color="rgb(0,255,0)"></stop>
                                                                <stop offset="50%" stop-color="rgb(0,255,255)"></stop>
                                                                <stop offset="66.666%" stop-color="rgb(0,0,255)"></stop>
                                                                <stop offset="83.333%" stop-color="rgb(255,0,255)"></stop>
                                                                <stop offset="100%" stop-color="rgb(255,0,0)"></stop>
                                                            </lineargradient>
                                                        </defs>
                                                        <rect width="18px" height="100%" fill="url(#g)"></rect>
                                                        <path transform="translate(-6,36.33442595627656)" class="tui-colorpicker-huebar-handle" d="M0 0 L4 4 L0 8 L0 0 Z" fill="black" stroke="none"></path>
                                                    </svg></div></div></div></div>
                                    <select name="select-blend-type">
                                        <option value="add" selected="">Add</option>
                                        <option value="diff">Diff</option>
                                        <option value="diff">Subtract</option>
                                        <option value="multiply">Multiply</option>
                                        <option value="screen">Screen</option>
                                        <option value="lighten">Lighten</option>
                                        <option value="darken">Darken</option>
                                    </select>
                                    <p></p>
                                </li>
                                <li class="menu-item close btn btn-secondary btn-sm">Close</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12" >
                        <div class="tui-image-editor" ></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
