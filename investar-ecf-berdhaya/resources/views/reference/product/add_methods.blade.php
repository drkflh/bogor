minToday(date){
    console.log('minToday', date);
    var today = moment().subtract(1, 'days');
    return date <= today;
},
notBeforeStart(date){
    const start = this.activeFrom;
    return start > date;
},
onLocalSelect(val) {
    console.log(val)
    if(typeof val.value!=='undefined') {
        this.companyCode = val.value
    }
}
