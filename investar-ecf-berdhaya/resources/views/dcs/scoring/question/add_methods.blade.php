calcTotalScore(){
    if(this.questionType == 'radioselect' || this.questionType == 'checkboxselect' ){
        this.totalScore = parseInt(this.score1) + parseInt(this.score2) + parseInt(this.score3) + parseInt(this.score4) + parseInt(this.score5);
        this.defaultScore = 0;
    }else if(this.questionType == 'tristate' ){
        this.answer1 = 'Yes';
        this.answer2 = 'No';
        this.answer3 = 'NA';
        this.answer4 = '';
        this.answer5 = '';
        this.score4 = 0;
        this.score5 = 0;
        this.totalScore = parseInt(this.score1) + parseInt(this.score2) + parseInt(this.score3) + parseInt(this.score4) + parseInt(this.score5);
        this.defaultScore = 0;
    }else{
        this.score1 = 0;
        this.score2 = 0;
        this.score3 = 0;
        this.score4 = 0;
        this.score5 = 0;
        this.totalScore = parseInt(this.defaultScore);
    }
},
