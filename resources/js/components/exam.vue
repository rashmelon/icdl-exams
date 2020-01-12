<template>
    <div class="container-fluid">
        <div class="jumbotron jumbotron-fluid mt-3 p-3 d-flex justify-content-between">

            <a href="/" class="btn btn-outline-dark"><i class="fa fa-arrow-left mr-2" aria-hidden="true"></i>back</a>
            <div class="h3">
                Categories
            </div>

            <b-button v-b-toggle.addNewExamDate variant="primary"><i class="fa fa-plus mr-2" aria-hidden="true"></i>New Exam</b-button>

            <div class="">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text px-3">Filter: </span>
                    </div>
                    <input CLASS="form-control" type="date" placeholder="filter date" v-model="selectedDate" @change="filter">
                </div>
            </div>

        </div>

        <b-collapse id="addNewExamDate" class="mt-2">
            <b-card class="shadow mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <input type="date" class="form-control" v-model="exam.date">
                    </div>
                    <div class="col-md-4">
                        <input type="time" class="form-control" v-model="exam.time">
                    </div>
                    <div class="col">
                        <button class="btn btn-primary" @click="create">Create</button>
                    </div>
                </div>
            </b-card>
        </b-collapse>


        <hr>

        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <td width="5%" class="align-middle">index</td>
                    <td width="5%" class="align-middle">Date</td>
                    <td class="align-middle">Time</td>
                    <td class="align-middle">Reservations</td>
                    <td width="5%" class="align-middle">View</td>
                    <td width="5%" class="align-middle">Update</td>
                    <td width="5%" class="align-middle">Delete</td>
                </tr>
            </thead>
            <tbody class="table-hover">
                <tr v-for="(ex, index) in exams">
                    <td>{{index+1}}</td>
                    <td><input type="date" class="form-control text-right" v-model="ex.date"></td>
                    <td><input type="time" class="form-control" v-model="ex.time"></td>
                    <td>{{ex.reservations_count}}</td>
                    <td width="3%"><a :href="'/exam/'+ex.id"><button class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></button></a></td>
                    <td><button class="btn btn-primary" @click="update(index)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td>
                    <td><button class="btn btn-danger" @click="remove(index)"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>
                </tr>
            </tbody>
        </table>

    </div>

</template>

<script>
    export default {
        name: "exam",
        data: function () {
            return {
                exam: [],
                full_exams: [],
                exams: [],
                selectedDate: null,
            }
        },
        mounted(){
            console.log(new Date());
            this.getData();
        },
        methods:{
            getData(){
                axios.get(`/api/exam`).then((response) => {
                    this.exams = response.data.data;
                    this.full_exams = response.data.data;
                }).catch(function(error){
                    console.log(error);
                });
            },
            create(){
                let data = new FormData();
                data.append('date', this.exam['date']);
                data.append('time', this.exam['time']);

                axios.post(`/api/exam`, data).then((response) => {
                    window.alert(response.data.message);
                    if (response.status === 200){
                        this.full_exams.push(response.data.data);
                        this.filter();
                        this.exam = [];
                    }
                }).catch(function(error){
                    console.log(error);
                });
            },
            update(index){
                let data = new FormData();
                data.append('date', this.exams[index].date);
                data.append('time', this.exams[index].time);

                axios.post(`/api/exam/${this.exams[index].id}`, data).then((response) => {
                    window.alert(response.data.message);
                    this.filter();
                }).catch(function(error){
                    console.log(error.response);
                });
            },
            remove(index){
                axios.delete(`/api/exam/${this.exams[index].id}`).then((response) => {
                    window.alert(response.data.message);
                    if (response.status === 200){
                        this.full_exams.splice(index, 1);
                        this.filter();
                    }
                }).catch(function(error){
                    console.log(error);
                });
            },
            filter(){
                this.exams = this.selectedDate? this.full_exams.filter(exam => exam.date === this.selectedDate):this.full_exams;
            }
        }
    }
</script>

<style scoped>
    td{
        text-align: center;
    }
</style>
