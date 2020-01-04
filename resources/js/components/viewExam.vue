<template>
    <div class="container-fluid">

        <div class="jumbotron jumbotron-fluid mt-3 p-3 d-flex justify-content-between">
            <a :href="'/exam'" class="btn btn-outline-dark"><i class="fa fa-arrow-left mr-2" aria-hidden="true"></i>back</a>
            <div class="h3">
                {{exam.name}}
            </div>
            <b-button v-b-toggle.addNewExam variant="primary"><i class="fa fa-plus mr-2" aria-hidden="true"></i>New Reservation</b-button>
        </div>

        <b-collapse id="addNewExam">
            <b-card class="shadow mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Search for Candidate</label>
                            <input class="form-control" v-model="search" @change="getCandidates" placeholder="name">
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Candidate</label>
                            <select type="" class="form-control" v-model="candidate" @change="getSubjects">
                                <option v-for="can in candidates" :value="can">
                                    {{ can.skills_card.number }}- {{ can.english_name }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Subject</label>
                            <select type="" class="form-control" v-model="subject" @change="getSubjects">
                                <option v-for="sub in subjects" :value="sub">
                                    {{ sub.name }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group ">
                            <button class="btn btn-primary mt-4" @click="create">Create</button>
                        </div>
                    </div>
                </div>
            </b-card>
        </b-collapse>

        <table class="table table-bordered">
            <thead class="thead-dark">
            <tr>
                <td class="align-middle">index</td>
                <td class="align-middle" width="10%">subject</td>
                <td class="align-middle" width="10%">Skill Card</td>
                <td class="align-middle">English Name</td>
                <td class="align-middle">National ID</td>
                <td class="align-middle" width="5%">First Mobile</td>
                <td class="align-middle" width="5%">Second Mobile</td>
                <td class="align-middle" width="5%"># Tests</td>
                <td class="align-middle" width="5%"><i class="fa fa-usd" aria-hidden="true"></i></td>
                <td class="align-middle">Notes</td>
                <td class="align-middle">Update</td>
                <td class="align-middle">Delete</td>
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
                <td>{{res.candidate.tests}}</td>
                <td>{{res.candidate.money}}</td>
                <td>{{res.notes}}</td>
                <td><button class="btn btn-primary" @click="update(index)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td>
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
                        this.reservations.push(response.data.data);
                    }
                }).catch(function(error){
                    console.log(error);
                });
            },
            update(index){
                let data = new FormData();
                if (this.candidates[index].skills_card && !this.candidates[index].skills_card.number)
                    data.append('skills_card_id', this.skillsCards[this.candidates[index].skills_card]['id']);
                axios.post(`/api/candidate/${this.candidates[index].id}`, data).then((response) => {
                    window.alert(response.data.message);
                    this.candidates[index].skills_card = this.skillsCards[this.candidates[index].skills_card];
                    console.log(response);
                }).catch(function(error){
                    console.log(error.response);
                });
            },
            remove(index){
                axios.delete(`/api/candidate/${this.candidates[index].id}`).then((response) => {
                    window.alert(response.data.message);
                    if (response.status === 200){
                        this.candidates.splice(index, 1);
                    }
                }).catch(function(error){
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
