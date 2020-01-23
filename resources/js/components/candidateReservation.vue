<template>


    <b-card>

        <div class="jumbotron jumbotron-fluid mt-3 p-3 d-flex justify-content-between">
            <b-button v-b-toggle.addNewReservation variant="primary"><i class="fa fa-plus mr-2" aria-hidden="true"></i>New Reservation</b-button>
        </div>

        <b-collapse id="addNewReservation">
            <b-card class="shadow mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Subject</label>
                            <select type="" class="form-control" v-model="subject">
                                <option v-for="sub in subjects" :value="sub">
                                    {{ sub.name }}
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
                <td class="align-middle" width="1%">#</td>
                <td class="align-middle" width="25%">subject</td>
                <td class="align-middle" >Date</td>
                <td class="align-middle" width="5%">Notes</td>
                <td class="align-middle text-center" width="5%">Exam</td>
                <td class="align-middle text-center" width="5%">Update</td>
                <td class="align-middle text-center" width="5%">Delete</td>
            </tr>
            </thead>
            <tbody class="table-hover">
            <tr v-for="(res, index) in reservations">
                <td>{{index+1}}</td>
                <td v-if="new Date(res.exam.date) > new Date()">
                    <select type="" class="form-control" v-model="res.subject_id">
                        <option v-for="sub in subjects" :value="sub.id">
                            {{ sub.name }}
                        </option>
                    </select>
                </td>
                <td v-else>{{ res.subject.name }}</td>

                <td v-if="new Date(res.exam.date) > new Date()">
                    <select type="" class="form-control" v-model="res.exam_id">
                        <option v-for="ex in exams" :value="ex.id">
                            {{ ex.date }} - {{ new Date(Date.parse(ex.date+' '+ex.time)).getHours() <= 12? new Date(Date.parse(ex.date+' '+ex.time)).getHours() : new Date(Date.parse(ex.date+' '+ex.time)).getHours() - 12}}
                        </option>
                    </select>
                </td>
                <td v-else="">
                    {{ res.exam.date }} - {{ new Date(Date.parse(res.exam.date+' '+res.exam.time)).getHours() <= 12? new Date(Date.parse(res.exam.date+' '+res.exam.time)).getHours() : new Date(Date.parse(res.exam.date+' '+res.exam.time)).getHours() - 12}}
                </td>
                <td>{{res.notes}}</td>
                <td class="text-center"><a :href="`/exam/${res.exam.id}`"><button class="btn btn-success"><i class="fa fa-eye" aria-hidden="true"></i></button></a></td>
                <td><button class="btn btn-primary" @click="update(index)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td>
                <td class="text-center"><button class="btn btn-danger" @click="remove(index)"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>
            </tr>
            </tbody>
        </table>
    </b-card>
</template>

<script>
    export default {
        name: "candidateReservation",
        data: function () {
            return {
                reservations: [],
                subjects: [],
                subject: {},
                exams: [],
                exam: {},
            }
        },
        mounted(){
            this.getReservations();
            this.getSubjects();
            this.getExams();
        },
        props:{
            candidate: {
                required: true
            }
        },methods: {
            getReservations() {
                axios.get(`/api/reservation?candidate=${this.candidate.id}`).then((response) => {
                    this.reservations = response.data.data;
                    for (var i = 0; i < this.reservations.length; i++) {
                        this.reservations[i].not_paid = this.reservations[i].candidate.reservations_count
                            + this.reservations[i].candidate.tests
                            - this.reservations[i].subject.category.free_tests
                            - this.reservations[i].candidate.payments_count;
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            },
            getSubjects() {
                axios.get(`/api/subject?candidate=${this.candidate.id}`).then((response) => {
                    this.subjects = response.data.data;
                }).catch(function (error) {
                    console.log(error);
                });
            },
            getExams() {
                axios.get(`/api/exam?coming=true`).then((response) => {
                    this.exams = response.data.data;
                }).catch(function (error) {
                    console.log(error);
                });
            },
            create(){
                let data = new FormData();
                if (this.exam && this.exam.id && this.subject && this.subject.id){
                    data.append('candidate_id', this.candidate.id);
                    data.append('exam_id', this.exam.id);
                    data.append('subject_id', this.subject.id);

                    axios.post(`/api/reservation`, data).then((response) => {
                        if (response.status === 200){
                            window.open(`/reservation-pdf/${response.data.data.id}`);
                            this.reservations.push(response.data.data);
                            this.exam = {};
                            this.subject = {};
                        }
                    }).catch(function(error){
                        window.alert(error.response.message);
                        console.log(error.response);
                    });
                }else if (!this.exam && !this.exam.id){
                    window.alert('Please choose exam')
                }else if (!this.subject && !this.subject.id){
                    window.alert('Please choose subject')
                }
            },
            update(index){
                let data = new FormData();
                data.append('exam_id', this.reservations[index].exam_id);
                data.append('subject_id', this.reservations[index].subject_id);

                axios.post(`/api/reservation/${this.reservations[index].id}`, data).then((response) => {
                    if (response.status === 200){
                        window.open(`/reservation-pdf/${this.reservations[index].id}`);
                    }
                }).catch(function(error){
                    window.alert(error.response.message);
                    console.log(error.response);
                });
            },
            remove(index){
                if(confirm('Are you sure you want to delete it?!')) {
                    axios.delete(`/api/reservation/${this.reservations[index].id}`).then((response) => {
                        window.alert(response.data.message);
                        if (response.status === 200) {
                            this.reservations.splice(index, 1);
                        }
                    }).catch(function (error) {
                        window.alert(error.response.data.message);
                        console.log(error);
                    });
                }
            },
        },
    }
</script>

<style scoped>

</style>
