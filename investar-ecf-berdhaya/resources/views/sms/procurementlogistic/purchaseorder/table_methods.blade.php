totalDetail(row){
    if(_.has(row, 'details') && _.isArrayLike(row.details) ){
        var sum = this.sumColumn(row.details, 'AmountOrdered');
        return this.formatCurrency(sum);
    }else{
        return '';
    }
},
