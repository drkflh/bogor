<template>
    <div>
        <a-select
            mode="single"
            label-in-value
            :value="selected"
            placeholder="Select users"
            :show-search="true"
            :show-arrow="false"
            style="width: 100%"
            :filter-option="false"
            :not-found-content="fetching ? undefined : null"
            @search="fetchUser"
            @select="handleSelect"
        >
            <a-spin v-if="fetching" slot="notFoundContent" size="small" />
            <a-select-option v-for="d in data" :key="d._id" >
                {{ d.text }}
            </a-select-option>
        </a-select>

        <a-config-provider>
            <template #renderEmpty>
                <div style="text-align: center">
                    <i style="color: orange;" class="las la-exclamation-triangle"></i>
                </div>
            </template>

            <a-list item-layout="horizontal" row-key="key" :data-source="items">
                <a-list-item slot="renderItem" slot-scope="it, idx">
                    <a-list-item-meta
                        :description="it.label"
                    >
                    </a-list-item-meta>
                    <a slot="actions">
                        <button class="btn btn-icon" @click="deleteItem(it.key, idx)">
                            <i class="las la-times-circle"></i>
                        </button>
                    </a>
                </a-list-item>
            </a-list>

        </a-config-provider>

    </div>

</template>

<script>
export default {
    name: 'UserSelectorList',
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
        extraData: {
            type: [Object, Array, String],
            default: function(){
                return {};
            }
        }
    },
    data(){
        this.lastFetchId = 0;
        this.fetchUser = _.debounce(this.fetchUser, 800);
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
        fetchUser(value) {
            console.log('fetching user', value);
            this.lastFetchId += 1;
            const fetchId = this.lastFetchId;
            this.data = [];
            this.fetching = true;

            axios.post( this.searchUrl, { q : value, extraData : this.extraData }  )
                .then( response => {
                    console.log(response.data);
                    if(response.data.result == 'OK'){
                        try {
                            const data = response.data.data.map(user => ({
                                text: ( user.name + ( user.jobTitle != ''?' - ':' ' ) + user.jobTitle ),
                                _id: user._id,
                                value: {
                                    _id : user._id,
                                    email : user.email,
                                    name : user.name,
                                    username : user.username,
                                    jobTitle : user.jobTitle,
                                    jobTitleCode : user.jobTitleCode,
                                    avatar : user.avatar,
                                    seq : user.seq,
                                    datatype: user.datatype
                                },
                            }));
                            this.data = data;
                            this.fetching = false
                        }catch (e) {
                            console.log(e);
                        }
                    }
                })
                .catch( error=> {
                    this.fetching = false
                    console.log(error);
                });

            // fetch(this.searchUrl)
            //     .then(response => response.json())
            //     .then(body => {
            //         if (fetchId !== this.lastFetchId) {
            //             // for fetch callback order
            //             return;
            //         }
            //         const data = body.results.map(user => ({
            //             text: `${user.name} ${user.jobTitle}`,
            //             value: user.username,
            //         }));
            //         this.data = data;
            //         this.fetching = false;
            //     });
        },
        deleteItem(item){
            console.log('del', item);
            this.selections = _.cloneDeep( this.items );
            var sels = _.remove( this.selections , { key : item } );

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
        handleChange(value) {
            console.log('change',value);
            // var selected = value.map( val => ({
            //     _id : val.key._id,
            //     email : val.key.email,
            //     name : val.key.name,
            //     username : val.key.username,
            //     jobTitle : val.key.jobTitle,
            //     jobTitleCode : val.key.jobTitleCode,
            //     avatar : val.key.avatar
            // }) );
            this.$emit('input', value)
            Object.assign(this, {
                value,
                data: [],
                fetching: false,
            });
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
    padding: 0px !important;
}
.ant-list-item-action {
    flex: 0 0 auto;
    margin-left: 16px !important;
    padding: 0;
    font-size: 0;
    list-style: none;
}
</style>
