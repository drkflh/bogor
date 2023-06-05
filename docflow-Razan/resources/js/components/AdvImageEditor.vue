<template>
    <div class="imageEditorApp">
        <tui-image-editor ref="tuiImageEditor"
                          :include-ui="useDefaultUI"
                          :options="options"
                          @addText="onAddText"
                          @objectMoved="onObjectMoved">
        </tui-image-editor>
    </div>
</template>

<script>
    import 'tui-image-editor/dist/svg/icon-a.svg';
    import 'tui-image-editor/dist/svg/icon-b.svg';
    import 'tui-image-editor/dist/svg/icon-c.svg';
    import 'tui-image-editor/dist/svg/icon-d.svg';
    // Load Style Code
    import 'tui-image-editor/dist/tui-image-editor.css';
    import 'tui-color-picker/dist/tui-color-picker.css';

    export default {
        name: "AdvImageEditor",
        props: {
            customTheme : {
                type: [Object, String]
            }
        },
        data() {
            return {
                useDefaultUI: true,
                options: {
                    includeUI: {
                        menu: ['draw', 'shape', 'icon', 'text' ],
                        initMenu: 'draw',
                        menuBarPosition: 'left',
                        theme: this.customTheme
                    },
                    cssMaxWidth: 800,
                    cssMaxHeight: 600
                }
            };
        },
        methods: {
            onAddText(res) {
                console.group('addText');
                console.log('Client Position : ', res.clientPosition);
                console.log('Origin Position : ', res.originPosition);
                console.groupEnd();
            },
            onObjectMoved(res) {
                console.group('objectMoved');
                console.log('Left : ', res.left);
                console.log('Top : ', res.top);
                console.groupEnd();
            }
        }
    }
</script>

<style scoped>
    .imageEditorApp {
        width: 100%;
        height: 1000px;
    }
</style>
