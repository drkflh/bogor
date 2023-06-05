<template>
    <div>
        <div 
            :id="tooltipId" 
            class="card" 
            v-show="active"
        >
            <div class="card-body">
                Ini Tampilan Sementara
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: "Tooltip",
        props: {
            dev: {
                type: String
            },
            tooltipId: {
                type: [String,Array]
            },
        },
        data: function() {
            return {
                active : false,
            }
        },
        watch: {

        },
        computed:{

        },
        mounted() {

        },
        methods: {
            
        },
    }
</script>