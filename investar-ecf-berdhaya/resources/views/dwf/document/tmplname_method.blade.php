if(val == 'status'){
    console.log(val, obj);
    if(_.isArray(obj) ){
        var tmpl = _.first(obj);
        return _.get(tmpl, 'formTemplate');
    }else if(_.isObject(obj) ){
        return _.get(obj, 'formTemplate');
    }
    return val;
}else{
    return val;
}
