minToday(date){
    console.log('minToday', date);
    var today = moment().subtract(1, 'days');
    return date <= today;
},
notBeforeStart(date){
    const start = new Date(this.activeFrom);
    return start > date;
}
