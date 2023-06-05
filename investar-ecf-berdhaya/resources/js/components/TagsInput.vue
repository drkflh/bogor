<template>
    <div style="padding: 0px;margin: 0px;">
        <vue-tags-input
            v-model="tag"
            :tags="tags"
            :autocomplete-items="autocompleteItems"
            :add-only-from-autocomplete="false"
            @tags-changed="update"
        />
    </div>
</template>

<script>
    export default {
        name: "TagsInput",
        model: {
            prop: 'value',
            event: 'input'
        },
        props: {
            value: {
                type: String,
                default: function(){
                    return '';
                }
            },
            tagKey: {
                type: String,
                default: function(){
                    return 'tag'
                }
            },
            searchUrl: {
                type: String
            },
            searchVar: {
                type: String,
                default: 'q'
            }
        },
        data: function(){
            return {
                tag: '',
                tags: [],
                autocompleteItems: [],
                debounce: null,
            };
        },
        watch: {
            'tag': 'initItems',
            'value': function (val) {
                console.log('tagVal', val);
                this.tag = '';
                if( !_.isEmpty(val) && _.isString(val) ){
                  this.tags = val.split(',');
                }
            }
        },
        methods: {
            update(newTags) {

                this.autocompleteItems = [];

                this.tags = newTags;

                var inTags = newTags.map(a => {
                  if(_.has(a, 'text') ){
                    return _.get(a, 'text');
                  }else{
                    return String(a);
                  }
                });
                console.log('inTags', inTags);
                this.$emit('input', inTags.join(",") );

                const url = this.searchUrl;

                axios.post(url, {
                    tags: this.tags
                }).then(response => {
                    console.log(response);
                }).catch(error => {
                    console.log(error);
                });
            },
            initItems() {
                if (this.tag.length < 2) return;
                const url = this.searchUrl + '?' + this.searchVar + '=' + this.tag;

                clearTimeout(this.debounce);
                this.debounce = setTimeout(() => {
                    axios.get(url).then(response => {
                        this.autocompleteItems = response.data.data.map(a => {
                            return { text: a[this.tagKey] };
                        });
                    }).catch(() => console.warn('Oh. Something went wrong'));
                }, 600);
            },
        },

    }
</script>

<style scoped>
    .ti-autocomplete{
        z-index: 500 !important;
    }
</style>
