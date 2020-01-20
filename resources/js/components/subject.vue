<template>
    <div class="container-fluid w-auto">
        <div class="jumbotron jumbotron-fluid mt-3 p-3 d-flex justify-content-between">
            <a href="/category" class="btn btn-outline-dark"><i class="fa fa-arrow-left mr-2" aria-hidden="true"></i>back</a>
            <div class="h3">
                {{category.name}} subjects
            </div>
            <b-button v-b-toggle.addNewSubject variant="primary"><i class="fa fa-plus mr-2" aria-hidden="true"></i>New Subject</b-button>
        </div>

        <b-collapse id="addNewSubject" class="">
            <b-card class="shadow mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>name</label>
                            <input class="form-control" v-model="subject.name" placeholder="name">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Office/No Office</label>
                            <select v-model="subject.office" class="form-control">
                                <option v-for="(el, index) in officeArray" :value="index">
                                    {{el}}
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

        <hr>


        <table class="table table-bordered">
            <thead>
            <tr>
                <td width="2%">index</td>
                <td>name</td>
                <td width="30%">Office/No Office</td>
                <td width="7%">update</td>
                <td width="7%">delete</td>
            </tr>
            </thead>
            <tbody class="table-hover">
            <tr v-for="(subject, index) in subjects">
                <td>{{index+1}}</td>
                <td><input class="form-control" v-model="subject.name"></td>
                <td>
                    <select class="form-control"  v-model="subject.office">
                        <option v-for="el in officeArray"
                                :selected="(!subject.office && el === 'office') || (subject.office && el === 'no office')"
                                :value="el === 'office'? 0:1">
                            {{el}}
                        </option>
                    </select>
                </td>
                <td><button class="btn btn-primary" @click="update(index)"><i class="fa fa-pencil-square-o text-white fa-2x" aria-hidden="true"></i></button></td>
                <td><button class="btn btn-danger" @click="remove(index)"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button></td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: "subject",
        data: function () {
            return {
                subject: [],
                subjects: [],
                officeArray: ['office', 'no office']
            }
        },
        mounted(){
            this.getData();
        },
        props:{
            category: {
                required: true
            }
        },
        methods:{
            getData(){
                axios.get(`/api/subject?category_id=${this.category.id}`).then((response) => {
                    this.subjects = response.data.data;
                }).catch(function(error){
                    console.log(error);
                });
            },
            create(){
                let data = new FormData();
                data.append('name', this.subject['name']);
                data.append('office', this.subject['office']);
                data.append('category_id', this.category.id);
                axios.post(`/api/subject`, data).then((response) => {
                    window.alert(response.data.message);
                    if (response.status === 200){
                        this.subjects.push(response.data.data);
                        this.subject['name'] = "";
                        this.subject['office'] = "";
                    }
                }).catch(function(error){
                    console.log(error);
                });
            },
            update(index){
                let data = new FormData();
                data.append('name', this.subjects[index].name);
                data.append('office', this.subjects[index].office);
                axios.post(`/api/subject/${this.subjects[index].id}`, data).then((response) => {
                    window.alert(response.data.message);
                    console.log(response);
                }).catch(function(error){
                    console.log(error);
                });
            },
            remove(index){
                if(confirm('Are you sure you want to delete it? \n اتاكد تاني!')) {
                    axios.delete(`/api/subject/${this.subjects[index].id}`).then((response) => {
                        window.alert(response.data.message);
                        if (response.status === 200) {
                            this.subjects.splice(index, 1);
                        }
                    }).catch(function (error) {
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
</style>
