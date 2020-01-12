<template>
    <div class="container-fluid">

        <div class="jumbotron jumbotron-fluid mt-3 p-3 d-flex justify-content-between">
            <a :href="'/exam'" class="btn btn-outline-dark"><i class="fa fa-arrow-left mr-2" aria-hidden="true"></i>back</a>
            <div class="h3">
                {{exam.date}} @ {{exam.time}}
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

        <table class="table table-bordered table-hover table-responsive ">
            <thead class="thead-dark bg-dark text-white">
            <tr>
                <td class="align-middle" width="2%">index</td>
                <td class="align-middle" width="5%">subject</td>
                <td class="align-middle" width="10%">Skill Card</td>
                <td class="align-middle">English Name</td>
                <td class="align-middle" width="10%">National ID</td>
                <td class="align-middle" width="8%">First Mobile</td>
                <td class="align-middle" width="8%">Second Mobile</td>
                <td class="align-middle" width="5%"># Tests</td>
                <td class="align-middle" width="5%">Total Paid</td>
                <td class="align-middle" width="5%"># Payments</td>
                <td class="align-middle" width="5%">Not Paid</td>
                <td class="align-middle" width="10%">Notes</td>
                <td class="align-middle" width="5%">View Payments</td>
                <td class="align-middle" width="1%">Delete</td>
            </tr>
            </thead>
            <tbody class="table-hover">
            <tr v-for="(res, index) in reservations">
                <td>{{index+1}}</td>
                <td>{{res.subject.name}}</td>
                <td>{{res.candidate.skills_card.number}}</td>
                <td>{{res.candidate.english_name}}</td>
                <td>{{res.candidate.national_id}}</td>
                <td>{{res.candidate.mobile1}}</td>
                <td>{{res.candidate.mobile2}}</td>
                <td>{{res.candidate.tests+res.candidate.reservations_count}}</td>
                <td>{{res.candidate.paid_sum}}</td>
                <td>{{res.candidate.payments_count}}</td>
                <td v-if="res.not_paid > 0" class="bg-danger">{{res.not_paid}}</td>
                <td v-else-if="res.not_paid < 0" class="bg-success">{{Math.abs(res.not_paid)}}</td>
                <td v-else>{{res.not_paid}}</td>
                <td>{{res.notes}}</td>
                <td><a :href="'/payment/'+res.candidate.id"><button class="btn btn-success">Payments</button></a></td>
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
                    for (var i =0; i<this.reservations.length; i++){
                        this.reservations[i].not_paid = this.reservations[i].candidate.reservations_count
                            + this.reservations[i].candidate.tests
                            - this.reservations[i].subject.category.free_tests
                            - this.reservations[i].candidate.payments_count;
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
                var exists = false;
                this.reservations.forEach((item,index)=>{
                    if (this.candidate.id == item.candidate_id){
                        exists = true;
                    }
                });
                if (exists){
                    alert('Candidate Already Exists')
                }
                else {
                    let data = new FormData();
                    data.append('candidate_id', this.candidate.id);
                    data.append('exam_id', this.exam.id);
                    data.append('subject_id', this.subject.id);

                    axios.post(`/api/reservation`, data).then((response) => {
                        window.alert(response.data.message);
                        if (response.status === 200){
                            this.reservations.push(response.data.data);
                            window.open(`/reservation-pdf/${response.data.data.id}`);
                        }

                        this.search = '';
                        this.candidates = [];
                        this.subjects = [];

                    }).catch(function(error){
                        console.log(error);
                    });
                }


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
                axios.delete(`/api/reservation/${this.reservations[index].id}`).then((response) => {
                    window.alert(response.data.message);
                    if (response.status === 200){
                        this.reservations.splice(index, 1);
                    }
                }).catch(function(error){
                    window.alert(error.response.data.message);
                    console.log(error);
                });
            },
        }
    }
</script>

<style scoped>
    td{
        text-align: center;
    }
</style>
