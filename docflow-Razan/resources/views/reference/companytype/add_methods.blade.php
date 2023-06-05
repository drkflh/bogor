minToday(date){
    const today = new Date();
    date.setDate(date.getDate() + 1);
    return date <= today;
},
notBeforeStart(date){
    const start = new Date(this.activeFrom);
    return start > date;
}
