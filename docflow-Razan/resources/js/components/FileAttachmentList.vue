<template>
    <div>
        <a-list item-layout="horizontal" row-key="key" :data-source="items">
            <a-list-item slot="renderItem" slot-scope="it, idx">
                <a-list-item-meta
                >
                    <a slot="title" :href="it.url">{{ it.filename }}</a>
                    <a-avatar
                        slot="avatar"
                        shape="square"
                        icon="file"
                        @click="itemClick(it)"
                        :src="getThumbnail(it)"
                    />
                    <input
                        slot="description"
                        type="text"
                        v-model="it.caption"
                        placeholder="add description"
                        class="form-control"
                    />
                </a-list-item-meta>
                <a slot="actions">
                    <button class="btn btn-icon" @click="deleteItem(it._id, idx)">
                        <i class="las la-times-circle"></i>
                    </button>
                </a>
            </a-list-item>
        </a-list>
    </div>
</template>

<script>
export default {
    name: 'FileAttachmentList',
    // model: {
    //     prop: 'value',
    //     event: 'input'
    // },
    props: {
        searchUrl: {
            type: String,
            default: '/user/auto-user'
        },
        items: {
            type: [Array, Object, String],
            default: function(){ return []}
        },
        mode: {
            type: String,
            default: 'multi'
        },
        directViewAction : {
            type: Boolean,
            default: function(){
                return true;
            }
        },
    },
    data(){
        return {
            selected: {},
            selections: [],
            data: [],
            value: [],
            fetching: false,
        };
    },
    watch: {
        // selections: function(val){
        //     this.$emit('update:items', this.selections);
        // }
    },
    methods: {
        itemClick(obj){
            var payload = { selected : obj, items : this.fileObjects, images : this.images, docs : this.docs };
            if(this.directViewAction){
                bus.$emit('openlightbox', payload);
            }else{
                this.$emit('onAttachmentItemClick', payload );
            }
        },
        getThumbnail(obj){
            if( !this.isDoc(obj.url) && obj.filetype == 'image'){
                return obj.url;
            }else{
                return this.defaulturl;
            }
        },
        isDoc(file) {
            var extension = file.substr((file.lastIndexOf('.') +1));
            if (/(pdf|zip|doc)$/ig.test(extension)) {
                return true;
            }else{
                return false;
            }
        },
        deleteItem(item){
            console.log('del', item);
            this.selections = _.cloneDeep( this.items );
            var sels = _.remove( this.selections , { _id : item } );
            this.$emit('update:items', this.selections);
        },
        handleSelect(value, option) {
            console.log('select', value);
            console.log('select option', this.data);

            var sel = _.find(this.data , { _id : value.key });

            var selobj = {
                key: value.key,
                label: value.label.trim(),
                obj: sel.value
            };
            this.selections = _.cloneDeep( this.items );
            if( this.mode == 'multi'){
                this.selections.push(selobj);
            }else{
                this.selections = [selobj];
            }

            var sorted = _.sortBy(this.selections, [ 'obj.seq' ] );

            this.selected = {};
            this.$emit('update:items', sorted);
        },
    }

}
</script>

<style scoped>
.ant-list-item-meta-description {
    color: #0a4b3e;
    font-size: 9pt;
}
.ant-list-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 4px !important;
}
.ant-list-item-action {
    flex: 0 0 auto;
    margin-left: 16px !important;
    padding: 0;
    font-size: 0;
    list-style: none;
}
h4.ant-list-item-meta-title{
    margin-bottom: 4px;
    color: rgba(0, 0, 0, 0.65);
    font-size: 10pt !important;
    line-height: 22px;
    margin-top: 0px !important;
}
</style>
