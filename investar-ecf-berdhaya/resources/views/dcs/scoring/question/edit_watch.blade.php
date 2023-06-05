question: function(val){
    this.objectKey = val.replace(/^\s+|\s+$|\s+(?=\s)/g, '').replace(/[^\w\s]/gi, '').split(' ').join('-').toLowerCase().substr(0,50);
},
defaultScore: function(val){
    this.calcTotalScore();
},
questionType: function(val){
    this.calcTotalScore();
},
score1: function(val){
    this.calcTotalScore();
},
score2: function(val){
    this.calcTotalScore();
},
score3: function(val){
    this.calcTotalScore();
},
score4: function(val){
    this.calcTotalScore();
},
score5: function(val){
    this.calcTotalScore();
},
