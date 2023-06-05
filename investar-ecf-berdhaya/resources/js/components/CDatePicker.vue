<template>
    <div class="form-group">
        <label for="date-time-input">Select date time (wrap)</label>
        <div class="input-group">
            <date-picker v-model="form.dateWrap" id="date-time-input"
                         :wrap="true" :config="configs.wrap">
            </date-picker>
            <div class="input-group-append">
                <button class="btn btn-secondary datepickerbutton" type="button" title="Toggle">
                    <i class="far fa-calendar"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "CDatePicker",
        model: {
            prop: 'value',
            event: 'input'
        },
        watch: {
            value: _.debounce(function(val){
                this.selectedDate = val;
            }, 500)
        },
        data: function(){
            return {
                selectedDate: moment(),
                options: {
                    format: this.format,
                },
                form: {
                    date: new Date(),
                    dateWrap: null,
                    dateModal: moment(),
                    dateValidate: null,
                    time: null,
                    dateLocale: moment(),
                    dateInline: moment().toString(),
                    startDate: null,
                    endDate: null
                },
                configs: {
                    basic: {
                        // https://momentjs.com/docs/#/displaying/format/
                        format: 'DD/MM/YYYY'
                    },
                    wrap: {
                        allowInputToggle: true
                    },
                    timePicker: {
                        format: 'LT',
                        useCurrent: false
                    },
                    locale: {
                        // https://github.com/moment/moment/tree/develop/locale
                        locale: 'hi',
                    },
                    inline: {
                        format: 'LLL',
                        inline: true,
                        sideBySide: true
                    },
                    start: {
                        format: 'DD/MM/YYYY',
                        useCurrent: false,
                        showClear: true,
                        showClose: true,
                        minDate: moment(),
                        maxDate: false
                    },
                    end: {
                        format: 'DD/MM/YYYY',
                        useCurrent: false,
                        showClear: true,
                        showClose: true,
                        minDate: moment()
                    }
                },
            };
        },
        props: {
            value: {
                type: [String, Object, Array, Number, Date]
            },
            type: {
                type: [String]
            },
            valueType: {
                type: String
            },
            placeholder: {
                type: String
            },
            format: {
                type: String
            },
            wrap: {
                type: Boolean,
                default: false
            }
        },
        methods: {
            onChange: function(date, type){
                this.$emit('input', date);
            }
        }

    }
</script>

<style scoped>

</style>
