<template>
    <div class="switch" :class="position==='right'?'right':'left'">
        <div class="switchToggle" :class="readonly?'readonly':''">
            <toggle-button :value="defaultValue" color="#0153c7" @change="onChangeEventHandler" :sync="true" :labels="checkedlabel"/>
        </div>
        <div v-if="position=='left' || position=='right'" class="switchLabel">{{ label }}</div>
    </div>
</template>

<script>
    export default {
        name: "DiscountSwitch",
         mounted() {
            this.showPanel = this.openShowPanel;
        },
        props: {
            label: {
                type: String,
                default: 'Switch'
            },
            position: {
                type: String,
                default: 'left'
            },
            model: {
                type: [String, Number, Boolean],
                default: false
            },
            openShowPanel: {
                type: Boolean,
                default: false
            },
            readonly: {
                type: Boolean,
                default: false
            },
            checkedlabel: {
                default: true
            }
        },
        computed: {
            defaultValue() {
                if(this.status==='yes' || this.model==='yes' || this.status===1 || this.model===1) return true
                else return false
            },
            checkedLabels() {
                if(this.checkedlabel==='yes' || this.checkedlabel===1) return true
                else return false
            }
        },
        data() {
            return {
                status: 0
            }
        },
        methods: {
            onChangeEventHandler(event) {
                if(event.value)
                    this.status = 'yes'
                else
                    this.status = 'no'
                this.$emit('input', this.status );
            }
        }
    }
</script>

<style scoped>
    .switch {
        display: flex;
        align-items: center;
    }
    .switch.left {
        justify-content: flex-start;
    }
    .switch.left .switchLabel {
        padding-top: 5px;
        padding-left: 10px;
    }
    .switch.right {
        justify-content: space-between;
        flex-direction: row-reverse;
    }
    .switch.disabled {
        position: relative;
        cursor: not-allowed;
        opacity: 0.6;
    }
    .switch.disabled:after {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        right: 0;
        left: 0;
        z-index: 2;
    }
    .seq{
        text-align: center;
        padding-bottom: 16px;
        vertical-align: bottom;
    }
    .switchToggle.readonly {
        position: relative;
    }
    .switchToggle.readonly::after {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 2;
        cursor: not-allowed;
    }
</style>
