<template>

    <div class="container-fluid">
        <div class="jumbotron jumbotron-fluid mt-3 p-3 d-flex justify-content-between">
            <div class="h3">
                {{candidate.english_name}}
            </div>
            <b-button v-b-toggle.addNewExam variant="primary"><i class="fa fa-plus mr-2" aria-hidden="true"></i>New Payment</b-button>
        </div>

        <b-collapse id="addNewExam">
            <b-card class="shadow mb-4">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="number" class="form-control" v-model="payment" placeholder="amount">
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
                <td class="align-middle" width="10%">Payment</td>
                <td class="align-middle" width="1%">Update</td>
                <td class="align-middle" width="1%">Delete</td>
            </tr>
            </thead>
            <tbody class="table-hover">
            <tr v-for="(pay, index) in payments">
                <td>{{index+1}}</td>
                <td><input type="number" v-model="pay.amount" class="form-control"></td>
                <td><button class="btn btn-primary" @click="update(index)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td>
                <td><button class="btn btn-danger" @click="remove(index)"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: "candidatePayment",
        data: function () {
            return {
                payment: "",
                payments: [],
            }
        },
        mounted(){
            this.getData();
        },
        props:{
            candidate: {
                required: true
            }
        },
        methods:{
            getData(){
                axios.get(`/api/payment?candidate=${this.candidate.id}`).then((response) => {
                    this.payments = response.data.data;
                }).catch(function(error){
                    console.log(error);
                });
            },
            create(){
                let data = new FormData();
                data.append('candidate_id', this.candidate.id);
                data.append('amount', this.payment);

                axios.post(`/api/payment`, data).then((response) => {
                    window.alert(response.data.message);
                    if (response.status === 200){
                        this.payments.push(response.data.data);
                        this.payment = {};
                    }
                }).catch(function(error){
                    console.log(error);
                });
            },
            update(index){
                let data = new FormData();
                data.append('candidate_id', this.payments[index].candidate_id);
                data.append('amount', this.payments[index].amount);

                axios.post(`/api/payment/${this.payments[index].id}`, data).then((response) => {
                    window.alert(response.data.message);
                    console.log(response);
                }).catch(function(error){
                    window.alert(error.response.data.message);
                    console.log(error.response);
                });
            },
            remove(index){
                axios.delete(`/api/payment/${this.payments[index].id}`).then((response) => {
                    window.alert(response.data.message);
                    if (response.status === 200){
                        this.payments.splice(index, 1);
                    }
                }).catch(function(error){
                    console.log(error);
                });
            },
        }
    }
</script>

<style scoped>

</style>
