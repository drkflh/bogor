<template>
    <b-form-select
        v-model="selectedTopic"
        class="form-control"
    >
        <b-form-select-option
            v-for="opt in topicOptions"
            :value="opt"
            :key="opt.text"
        >
            {{ opt.text }}
        </b-form-select-option>
    </b-form-select>
</template>

<script>
    export default {
        name: "TopicSelector",
        model: {
            prop: 'value',
            event: 'input'
        },
        props: {
            value: {
                type: [String, Object, Array, Number]
            },
            options: {
                type: [String, Object, Array]
            },
            topicOptions: {
                type: Array
            },
            topicDescr: {
                type: String
            },
            // topicFeature: {
            //     type: String
            // },
            topicFunction: {
                type: String
            },
            topicText: {
                type: String
            },
            topicDocClass:{
                type: [String, Number]
            },
            topicActiveYrs: {
                type: [String, Number]
            },
            topicDispPer: {
                type: [String, Number]
            }
        },
        data: function() {
            return {
                model: {},
                selectedTopic : '',
            }
        },
        watch: {
            selectedTopic: function (sel) {

                console.log(sel.value);
                var val = sel.value;
                this.$emit('update:topicText', val.Topic);
                this.$emit('update:topicDescr', val.TopicDescr);
                this.$emit('update:topicFunction', val.Function);
                this.$emit('update:topicDocClass', val.DocClass);
                this.$emit('update:topicActiveYrs', parseInt(val.ActiveYrs) );
                this.$emit('update:topicDispPer', parseInt(val.DispPer) );
                this.$emit('input', val.value);
            }
        },
        methods: {

        }
    }
</script>

<style scoped>

</style>
