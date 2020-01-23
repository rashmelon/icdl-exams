<template>
    <div class="container-fluid w-auto">
        <div class="jumbotron jumbotron-fluid mt-3 p-3 d-flex justify-content-between">

            <a href="/" class="btn btn-outline-dark"><i class="fa fa-arrow-left mr-2" aria-hidden="true"></i>back</a>
            <div class="h3">
                Instuctions
            </div>

            <b-button v-b-toggle.addNewExamDate variant="primary"><i class="fa fa-plus mr-2" aria-hidden="true"></i>New Instruction</b-button>

        </div>

        <b-collapse id="addNewExamDate" class="mt-2">
            <b-card class="shadow mb-4">
                <div class="row">
                    <div class="col-md-9">
                        <input type="text" class="form-control" v-model="instruction.name" placeholder="instruction">
                    </div>

                    <div class="col-md-2">
                        <input type="number" class="form-control" v-model="instruction.order">
                    </div>

                    <div class="col-md-1">
                        <button class="btn btn-primary btn-block" @click="create">Create</button>
                    </div>
                </div>
            </b-card>
        </b-collapse>


        <hr>

        <table class="table table-bordered ">
            <thead class="thead-dark">
            <tr>
                <td class="align-middle" width="5%">Index</td>
                <td class="align-middle" width="8%">Order</td>
                <td class="align-middle">Name</td>
                <td class="align-middle" width="5%">Update</td>
                <td class="align-middle" width="5%">Delete</td>
            </tr>
            </thead>
            <tbody class="table-hover">
            <tr v-for="(inst, index) in instructions">
                <td class="text-center">{{index+1}}</td>
                <td><input type="number" class="form-control text-center" v-model="inst.order"></td>
                <td><input type="text" class="form-control text-right" v-model="inst.name" dir="rtl"></td>
                <td><button class="btn btn-primary" @click="update(index)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td>
                <td><button class="btn btn-danger" @click="remove(index)"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>
            </tr>
            </tbody>
        </table>

    </div>
</template>

<script>
    export default {
        name: "instruction",
        data: function () {
            return {
                instruction: {},
                instructions: [],
            }
        },
        mounted(){
            this.getData();
        },
        methods:{
            getData(){
                axios.get(`/api/instruction`).then((response) => {
                    this.instructions = response.data.data;
                }).catch(function(error){
                    console.log(error);
                });
            },
            create(){
                let data = new FormData();
                data.append('name', this.instruction['name']);
                data.append('order', this.instruction['order']);

                axios.post(`/api/instruction`, data).then((response) => {
                    window.alert(response.data.message);
                    if (response.status === 200){
                        this.instructions.push(response.data.data);
                        this.instruction = {};
                    }
                }).catch(function(error){
                    console.log(error);
                });
            },
            update(index){
                let data = new FormData();
                data.append('name', this.instructions[index].name);
                data.append('order', this.instructions[index].order);

                axios.post(`/api/instruction/${this.instructions[index].id}`, data).then((response) => {
                    window.alert(response.data.message);
                    this.filter();
                }).catch(function(error){
                    console.log(error.response);
                });
            },
            remove(index){
                if(confirm('Are you sure you want to delete it?!')) {
                    axios.delete(`/api/instruction/${this.instructions[index].id}`).then((response) => {
                        window.alert(response.data.message);
                        if (response.status === 200) {
                            this.instructions.splice(index, 1);
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
</style>
