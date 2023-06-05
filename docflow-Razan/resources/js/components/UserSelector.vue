<template>
    <a-select
        mode="multiple"
        label-in-value
        :value="value"
        placeholder="Select users"
        style="width: 100%"
        :filter-option="false"
        :not-found-content="fetching ? undefined : null"
        @search="fetchUser"
        @change="handleChange"
        @select="handleSelect"
    >
        <a-spin v-if="fetching" slot="notFoundContent" size="small" />
        <a-select-option v-for="d in data" :key="d.text" >
            {{ d.text }}
        </a-select-option>
    </a-select>
</template>

<script>
export default {
    name: 'UserSelector',
    // model: {
    //     prop: 'value',
    //     event: 'input'
    // },
    props: {
        searchUrl: {
            type: String,
            default: '/user/auto-user'
        }
    },
    data(){
        this.lastFetchId = 0;
        this.fetchUser = _.debounce(this.fetchUser, 800);
        return {
            selected: [],
            data: [],
            value: [],
            fetching: false,
        };
    },
    watch: {
        value: function(val){
            this.selected = val;
        }
    },
    methods: {
        fetchUser(value) {
            console.log('fetching user', value);
            this.lastFetchId += 1;
            const fetchId = this.lastFetchId;
            this.data = [];
            this.fetching = true;

            axios.post( this.searchUrl, { q : value }  )
                .then( response => {
                    console.log(response.data);
                    if(response.data.result == 'OK'){
                        try {
                            const data = response.data.data.map(user => ({
                                text: `${user.name} - ${user.jobTitle}`,
                                value: {
                                    _id : user._id,
                                    email : user.email,
                                    name : user.name,
                                    username : user.username,
                                    jobTitle : user.jobTitle,
                                    jobTitleCode : user.jobTitleCode,
                                    avatar : user.avatar
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
        handleSelect(value) {
            console.log('select', value);
            this.selected.push(value);
            this.$emit('input', this.selected);
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

</style>
