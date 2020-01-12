<template>
    <div class="container-fluid">

        <div class="jumbotron jumbotron-fluid mt-3 p-3 d-flex justify-content-between">
            <b-button class="button" v-b-toggle.addNewExam variant="primary"><i class="fa fa-plus mr-2" aria-hidden="true"></i>New Reservation</b-button>
        </div>

        <b-collapse id="addNewExam">
            <b-card class="shadow mb-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Search for Candidate</label>
                            <input class="form-control" v-model="search" @change="getCandidates" placeholder="Search with anything">
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Candidate</label>
                            <select type="" class="form-control" v-model="candidate" @change="getSubjects">
                                <option v-for="can in candidates" :value="can">
                                    {{ can.skills_card.number }}- {{ can.english_name }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Subject</label>
                            <select type="" class="form-control" v-model="subject">
                                <option v-for="sub in subjects" :value="sub">
                                    {{ sub.name }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Exam</label>
                            <select type="" class="form-control" v-model="exam">
                                <option v-for="ex in exams" :value="ex">
                                    {{ ex.date }} - {{ ex.time }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group ">
                            <button class="btn btn-success mt-4 btn-block" @click="create">Create</button>
                        </div>
                    </div>
                </div>
            </b-card>
        </b-collapse>

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
                }).catch(function(error){
                    console.log(error);
                });
            },
            getSubjects(){
                axios.get(`/api/subject?candidate=${this.candidate.id}`).then((response) => {
                    this.subjects = response.data.data;
                }).catch(function(error){
                    console.log(error);
                });
            },
            create(){
                let data = new FormData();
                data.append('candidate_id', this.candidate.id);
                data.append('exam_id', this.exam.id);
                data.append('subject_id', this.subject.id);

                axios.post(`/api/reservation`, data).then((response) => {
                    window.alert(response.data.message);
                    if (response.status === 200){
                        this.search = '';
                        this.candidates = [];
                        this.subjects = [];
                        this.exam = {};
                    }
                }).catch(function(error){
                    window.alert(error.response.data.message);
                    console.log(error.response);
                });

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
    }
    .button{
        margin: 0 auto;
    }
    .jumbotron{
        background: #fff !important;
    }
</style>
