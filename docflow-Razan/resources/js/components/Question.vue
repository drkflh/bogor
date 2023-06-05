<template>
    <div>
        <!-- {{ this.getQuestion() }} -->
        <!-- {{ this.getOption() }} -->
        {{ this.getStatement() }}
        <template v-for="(item, index) in this.valueQuestion">
            <div>
                <p style="margin-top:10px;margin-bottom:-5px;margin-top:10px;">{{item.question}}</p>
            </div>
            <!-- <div v-for="item in this.valueOption">
                <input type="radio" :name="item.id_question" :value="parseInt(item.option)">
                <label >{{item.label}}</label>
                <br>
            </div> -->
            <!-- <input style="margin-left:5px;" :name="item.code" type="radio"  :value="parseInt(item.score2)" v-model="scoreAdl[index]">
                <label >{{item.answer2}}</label>
                <br>
                <input v-if="item.answer3" style="margin-left:5px;" :name="item.code" type="radio" :value="parseInt(item.score3)" v-model="scoreAdl[index]">
                <label >{{item.answer3}}</label>
                <br>
                <input v-if="item.answer4" style="margin-left:5px;" type="radio" :name="item.code" :value="parseInt(item.score4)" v-model="scoreAdl[index]">
                <label >{{item.answer4}}</label>
            </div> -->
        </template>
        
        <h5 class="mt-2">Pernyataan</h5>
        <div v-for="(item, index) in this.valueStatement">
            <div>
                <input type="checkbox" :name="item.title" :value="item.content" required>
                <label >{{item.content}}</label>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Question",
        props: {
            label: {
                type: [String]
            },
            url : {
                type: String,
                default: 'question-list'
            },
            valueQuestion: {
                type: [String,Array]
            },
            valueOption: {
                type: [String,Array]
            },
            valueStatement: {
                type: [String,Array]
            },
        },
        beforeMount() {
            this.getQuestion();
            this.getOption();
            this.getStatement();
            console.log(this.getStatement());
        },
        methods: {
            getStatement(){
                this.url = 'statement';
                axios.get(this.url)
                    .then( response => {
                        if(response.data.result == 'OK'){
                            this.valueStatement = response.data.data;
                        }
                    })
                    .catch( error=> {
                        console.log(error);
                    });
            },
            getQuestion(){
                this.url = 'question-list';
                axios.get(this.url)
                    .then( response => {
                        if(response.data.result == 'OK'){
                            this.valueQuestion = response.data.data;
                        }
                    })
                    .catch( error=> {
                        console.log(error);
                    });
            },
            getOption(){
                this.url = 'option-list';
                axios.get(this.url)
                    .then( response => {
                        if(response.data.result == 'OK'){
                            this.valueOption = response.data.data;
                        }
                    })
                    .catch( error=> {
                        console.log(error);
                    });
            },
            // save(){
            //     this.url = 'scoring-lansia-member';
            //     var data = {};

            //     data.answerAdl = this.scoreAdl;
            //     data.scoreAdl = this.totalADL;
            //     axios.post(this.url,data)
            //         .then( response => {
            //             console.log(response.data);
            //             if(response.data.result == 'OK'){
            //                this.closeModal();
            //             }else{
            //                 alert( response.data.message );
            //             }
            //         })
            //         .catch( error=> {
            //             console.log(error);
            //         });
            // },
        }
    }
</script>

<style scoped>

</style>
