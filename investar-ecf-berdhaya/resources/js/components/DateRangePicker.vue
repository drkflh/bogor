<template>
    <div>
        <vue-hotel-datepicker 
            :format="format" :minNights="minNights" 
            :maxNights="maxNights" :startDate="startDate" 
            @day-clicked="getDate">
        </vue-hotel-datepicker>
    </div>
</template>

<script>
    export default {
        name: "DateRangePicker",
        data() {
            return {
                date_in: '',
                date_out: ''
            }
        },
        props: {
            format: {
                type: String,
                default: 'DD/MMM/YYYY'
            },
            minNights: {
                type: Number,
            },
            maxNights: {
                type: Number,
            },
            startDate: {
                type: String,
            }
        },
        methods: {
            getDate(e) {
                console.log(e)
                // this.date_in = e.checkInDate
                // this.date_out = e.checkOutDate
                // console.log(`date in ${this.date_in}`)
                // console.log(`date out ${this.date_}`)
            },
        },
    }
</script>