<template>
    <div class="">

<!--

        <div class="jumbotron jumbotron-fluid mt-3 p-3 d-flex justify-content-between">
            <b-button class="button" v-b-toggle.addNewExam variant="primary"><i class="fa fa-plus mr-2" aria-hidden="true"></i>New Reservation</b-button>
        </div>
-->

        <b-card class="shadow my-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Search for Candidate</label>
                        <input class="form-control" v-model="search" @change="getCandidates" placeholder="Search with anything">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Candidate</label>
                        <select class="form-control" v-model="candidate" @change="getSubjects">
                            <option v-for="can in candidates" :value="can">
                                <span v-if="can.skills_card">{{ can.skills_card.number }} - </span>{{ can.english_name }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group font-weight-bold">
                        <div class="d-inline">Number of Tests Reserved</div>
                        <div class="d-inline" v-if="candidate.tests || candidate.reservations_count" >
                            <span v-if="candidate.not_paid > 0" class="bg-danger" style="color:white;padding:10px;">{{candidate.tests + candidate.reservations_count}} ({{candidate.not_paid}})</span>
                            <span v-else-if="candidate.not_paid < 0" class="bg-success" style="color:white;padding:10px;">{{candidate.tests + candidate.reservations_count}} ({{Math.abs(candidate.not_paid)}})</span>
                            <span v-else>{{candidate.tests + candidate.reservations_count}} ({{candidate.not_paid}})</span>
                        </div>
                        <div class="d-inline" v-else>0</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Subject</label>
                        <select type="" class="form-control" v-model="subject">
                            <option v-for="sub in subjects" :value="sub">
                                <span v-if="!candidate.skills_card">{{sub.category.name}}</span> {{ sub.name }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Exam</label>
                        <select type="" class="form-control" v-model="exam">
                            <option v-for="ex in exams" :value="ex">
                                {{ ex.date }} - {{ new Date(Date.parse(ex.date+' '+ex.time)).getHours() <= 12? new Date(Date.parse(ex.date+' '+ex.time)).getHours() : new Date(Date.parse(ex.date+' '+ex.time)).getHours() - 12}}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group ">
                        <button class="btn btn-success mt-4 btn-block" @click="create">Create</button>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group ">
                        <a class="btn btn-info mt-4 btn-block" :class="{'disabled': !candidate.id}" target="_blank" :href="`/candidate/${candidate.id}`">Open Record</a>
                    </div>
                </div>
            </div>
        </b-card>
<!--
        <b-collapse id="addNewExam">
        </b-collapse>
-->

    </div>
</template>

<script>
    export default {
        name: "reserve",
        data: function () {
            return {
                exams: [],
                exam: {},
                candidate: {},
                candidates: [],
                subjects: [],
                subject: {},
                search: "",
            }
        },
        mounted(){
            this.getData();
        },
        props:{

        },
        methods:{
            getData(){
                axios.get(`/api/reservation/create`).then((response) => {
                    this.exams = response.data.data.exams;
                }).catch(function(error){
                    console.log(error);
                });
            },
            getCandidates(){
                axios.get(`/api/candidate?search=${this.search}`).then((response) => {
                    this.candidates = [];
                    this.candidates = response.data.data;


                    for (var i =0; i<this.candidates.length; i++){
                        if (this.candidates[i].skills_card){
                            this.candidates[i].not_paid = this.candidates[i].reservations_count
                                + this.candidates[i].tests
                                + this.candidates[i].absence
                                - this.candidates[i].skills_card.category.free_tests
                                - this.candidates[i].payments_count;
                        }
                        else{
                            this.candidates[i].not_paid = 0;
                        }
                    }

                }).catch(function(error){
                    console.log(error);
                });
            },
            getSubjects(){
                var query = this.candidate.skills_card?`?candidate=${this.candidate.id}`:'';
                axios.get(`/api/subject${query}`).then((response) => {
                    this.subjects = response.data.data;
                }).catch(function(error){
                    console.log(error);
                });
            },
            create(){
                let data = new FormData();
                if (this.candidate.id && this.exam.id &&this.subject.id){
                    data.append('candidate_id', this.candidate.id);
                    data.append('exam_id', this.exam.id);
                    data.append('subject_id', this.subject.id);

                    axios.post(`/api/reservation`, data).then((response) => {
                        if (response.status === 200){
                            window.open(`/reservation-pdf/${response.data.data.id}`);
                            this.search = '';
                            this.candidates = [];
                            this.subjects = [];
                            this.subject = {};
                        }
                    }).catch(function(error){
                        window.alert(error.response.data.message);
                        console.log(error.response);
                    });
                }else if (!this.candidate.id){
                    window.alert('Please choose candidate')
                }else if (!this.exam.id){
                    window.alert('Please choose exam')
                }else if (!this.subject.id){
                    window.alert('Please choose subject')
                }
            },
        }
    }
</script>

<style scoped>
    td{
        text-align: center;
    }
    .container-fluid{
        width: 1080px;
        max-width: 100%;
    }
    .button{
        margin: 0 auto;
    }
    .jumbotron{
        background: #fff !important;
    }

    .menu,
    select,
    select option,
    input,
    label{
        font-weight: bold;
        color: #333
    }

    input::placeholder{
        opacity: 0.5;
    }
</style>
