<template>
    <div class="container-fluid w-auto">

        <div class="jumbotron jumbotron-fluid mt-3 p-3 d-flex justify-content-between">
            <a :href="'/exam'" class="btn btn-outline-dark"><i class="fa fa-arrow-left mr-2" aria-hidden="true"></i>back</a>
            <div class="h3">
                {{exam.date}} at {{ new Date(Date.parse(exam.date+' '+exam.time)).getHours() <= 12? new Date(Date.parse(exam.date+' '+exam.time)).getHours() : new Date(Date.parse(exam.date+' '+exam.time)).getHours() - 12}}
            </div>
            <b-button v-b-toggle.addNewExam variant="primary"><i class="fa fa-plus mr-2" aria-hidden="true"></i>New Reservation</b-button>
        </div>

        <b-collapse id="addNewExam">
            <b-card class="shadow mb-4">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Search for Candidate</label>
                            <input class="form-control" v-model="search" @change="getCandidates" placeholder="name">
                        </div>
                    </div>

                    <div class="col-md-3">
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
                            <select type="" class="form-control" v-model="subject" @change="getSubjects">
                                <option v-for="sub in subjects" :value="sub">
                                    {{ sub.name }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group ">
                            <button class="btn btn-primary mt-4 btn-block" @click="create">Create</button>
                        </div>
                    </div>
                </div>
            </b-card>
        </b-collapse>

        <table class="table table-bordered table-hover table-responsive exam">
            <thead class="thead-dark bg-dark text-white">
            <tr>
                <td class="align-middle" width="2%">Revised</td>
                <td class="align-middle" width="2%">index</td>
                <td class="align-middle" width="10%">subject</td>
                <td class="align-middle" width="10%">Skill Card</td>
                <td class="align-middle">English Name</td>
                <td class="align-middle" width="8%">First Mobile</td>
                <td class="align-middle" width="5%"># Tests</td>
                <td class="align-middle" width="5%">Abs</td>
                <td class="align-middle" width="5%">Total Paid</td>
                <td class="align-middle" width="5%"># Pay</td>
                <td class="align-middle" width="5%">Not Paid</td>
<!--                <td class="align-middle" width="5%">Notes</td>-->
                <td class="align-middle" width="5%">Paper</td>
                <td class="align-middle" width="5%">candi.</td>
                <td class="align-middle" width="1%">Delete</td>
            </tr>
            </thead>
            <tbody class="table-hover">
            <tr v-for="(res, index) in reservations">
                <td class="position-relative"><input type="checkbox" class="form-control review"><div class="d-none overlay"></div></td>
                <td>{{parseInt(index) + 1}}</td>
                <td>{{res.subject.name}}</td>
                <td v-if="res.candidate.skills_card">{{res.candidate.skills_card.number}}</td>
                <td v-else></td>
                <td>{{res.candidate.english_name}}</td>
                <td>{{res.candidate.mobile1}}</td>
                <td>{{res.candidate.tests+res.candidate.reservations_count}}</td>
                <td>{{res.candidate.absence}}</td>
                <td>{{res.candidate.paid_sum}}</td>
                <td>{{res.candidate.payments_count}}</td>
                <td :class="{'bg-danger': res.not_paid > 0, 'bg-success': res.not_paid < 0}">{{Math.abs(res.not_paid)}}</td>
<!--                <td v-if="res.not_paid > 0" class="bg-danger">{{res.not_paid}}</td>-->
<!--                <td v-else-if="res.not_paid < 0" class="bg-success">{{Math.abs(res.not_paid)}}</td>-->
<!--                <td v-else>{{res.not_paid}}</td>-->
<!--                <td>{{res.notes}}</td>-->
                <td><a :href="`/reservation-pdf/${res.id}`" target="_blank"><button class="btn btn-dark"><i class="fa fa-print" aria-hidden="true"></i></button></a></td>
                <td><a :href="`/candidate/${res.candidate.id}`" target="_blank"><button class="btn btn-success"><i class="fa fa-eye" aria-hidden="true"></i></button></a></td>
                <td><button class="btn btn-danger" @click="remove(index)"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>
            </tr>
            </tbody>
        </table>

    </div>
</template>

<script>
    export default {
        name: "viewExam",
        data: function () {
            return {
                reservation: [],
                reservations: [],
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
            exam: {
                required: true
            }
        },
        methods:{
            getData(){
                axios.get(`/api/reservation?exam=${this.exam.id}`).then((response) => {
                    this.reservations = response.data.data;
                    console.log(typeof this.reservations);
                    console.log(this.reservations.length);
                    console.log(response.data.data);
                    for (var i =0; i<this.reservations.length; i++){
                        this.reservations[i].not_paid = this.reservations[i].candidate.reservations_count
                            + this.reservations[i].candidate.tests
                            + this.reservations[i].candidate.absence
                            - this.reservations[i].subject.category.free_tests
                            - this.reservations[i].candidate.payments_count;
                        this.reservations[i].clicked = false;
                        console.log(this.reservations[i].not_paid);
                    }
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
                    if (response.status === 200){
                        this.reservations.push(response.data.data);
                        window.open(`/reservation-pdf/${response.data.data.id}`);
                    }

                    this.search = '';
                    this.candidates = [];
                    this.subjects = [];
                    this.subject = {};

                }).catch(function(error){
                    window.alert(error.response.data.message);
                    console.log(error);
                });

            },
            update(index){
                let data = new FormData();

                axios.post(`/api/candidate/${this.candidates[index].id}`, data).then((response) => {
                    window.alert(response.data.message);
                    this.candidates[index].skills_card = this.skillsCards[this.candidates[index].skills_card];
                    console.log(response);
                }).catch(function(error){
                    console.log(error.response);
                });
            },
            remove(index){
                if(confirm('Are you sure you want to delete it?!')){
                    axios.delete(`/api/reservation/${this.reservations[index].id}`).then((response) => {
                        window.alert(response.data.message);
                        if (response.status === 200){
                            this.reservations.splice(index, 1);
                        }
                    }).catch(function(error){
                        window.alert(error.response.data.message);
                        console.log(error);
                    });
                }
            },
        }
    }
</script>

<style scoped>
    td{
        text-align: center;
    }
    .false{
        background: white;
    }
    .true{
        background: darkseagreen;
    }
</style>
