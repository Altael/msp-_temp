<template>
    <div class="appQuestions">
        <div class="appQuestionsList">
            <question-list :show-modal="showModal"/>
        </div>
        <template  v-if="question">
            <question :key="question.id" :question="question" v-if="!showModal" :show-modal="showModal"/>

            <div class="dhrtModalWindow mspQuestionsModal"  v-if="showModal">
                <div class="dhrtModalWindow-back" @click="question = null"></div>
                <div class="dhrtModalWindow-content">
                    <div class="dhrtModalWindow-contentTools" @click="question = null"><div class="dhrtModalWindow-contentClose">&times;</div></div>
                    <question :key="question.id" :question="question" :show-modal="showModal"/>
                </div>
            </div>
        </template>


    </div>
</template>

<script>
    export default {
        props: ['dialogueId'],

        data() {
            return {
                question: null,

                showModal: window.matchMedia("(max-width: 1199px)").matches,

            }
        },

        mounted() {
            if(this.dialogueId) this.getDialogue();
        },

        methods: {
            getDialogue(){
                axios.get('/conversations-dialogue?dialogue=' + this.dialogueId).then(response => {
                    this.question = response.data.question;
                });
            }
        }
    }

</script>
