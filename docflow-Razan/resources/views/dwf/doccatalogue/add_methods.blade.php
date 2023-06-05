maxToday(date){
    const today = new Date();
    return date > today;
},
maxTodayNotBefore(date){
    const today = new Date();
    const before = new Date(this.DocDate);
    console.log( date, today, before);
    return before > date || date > today;
},
addAttachmentClick(payload){
    console.log('add issue payload', payload);
    bus.$emit('openlightbox', payload);
},
