<template>
    <div class="container-fluid w-auto">
        <div class="jumbotron jumbotron-fluid mt-3 p-3 d-flex justify-content-between">
            <a href="/category" class="btn btn-outline-dark"><i class="fa fa-arrow-left mr-2" aria-hidden="true"></i>back</a>
            <div class="h3">
                {{category.name}}
            </div>
            <b-button v-b-toggle.addNewSkillcard variant="primary"><i class="fa fa-plus mr-2" aria-hidden="true"></i>New Number</b-button>
            <b-button v-b-toggle.addNewRange variant="primary"><i class="fa fa-plus mr-2" aria-hidden="true"></i>New Range</b-button>
        </div>

        <b-collapse id="addNewSkillcard" class="">
            <b-card class="shadow mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input class="form-control" v-model="skillCard['number']" placeholder="number">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <button class="btn btn-primary" @click="create">Create</button>
                        </div>
                    </div>
                </div>
            </b-card>
        </b-collapse>

        <b-collapse id="addNewRange">
            <b-card class="shadow mb-4">
                <div class="row">
                    <div class="col-md-1">
                        <div class="form-group">
                            <input class="form-control" v-model="range['first']" placeholder="First">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <input class="form-control" v-model="range['second']" placeholder="Second">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input class="form-control" v-model="range['start']" placeholder="Start Number">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input class="form-control" v-model="range['range']" placeholder="Range">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <button class="btn btn-primary" @click="createRange">Create</button>
                        </div>
                    </div>
                </div>
            </b-card>
        </b-collapse>

        <hr>
        <div class=" d-block mx-auto" style="width: 200px">
            <div class="input-group my-3 paging form-group text-center">
                <div class="input-group-prepend">
                    <button @click="minusOne" class="btn btn-dark rounded">
                        <i class="fa fa-arrow-circle-left" aria-hidden="true"></i>
                    </button>
                </div>
                <input class="form-control" type="number" v-model="page" style="width:40px" @change="getData">
                <div class="input-group-append">
                    <button @click="plusOne" class="btn btn-dark rounded">
                        <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                    </button>
                </div>

            </div>
        </div>

        <hr>

        <table class="table table-bordered">
            <thead>
            <tr>
                <td width="2%">index</td>
                <td>number</td>
                <td width="40%">used</td>
                <td width="5%">update</td>
                <td width="5%">delete</td>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(skill, index) in skills">
                <td>{{(page-1)*100+index+1}}</td>
                <td>{{skill.number}}</td>
                <td>
                    <select class="form-control" v-model="skill.used">
                        <option v-for="el in used"
                                v-if="el !== 'used' ||(el === 'used' && skill.used)"
                                :selected="(skill.used && el === 'used') || (!skill.used && el === 'unused')"
                                :value="el === 'used'? 1:0">
                            {{el}}
                        </option>
                    </select>
                </td>
                <td><button class="btn btn-primary" @click="update(index)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td>
                <td><button class="btn btn-danger" @click="remove(index)"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: "skillsCard",
        data: function () {
            return {
                skillCard: [],
                skills: [],
                range: [],
                used: ['used', 'unused'],
                page: 1,
                lastPage: 1,
                baseUrl: `/api/skills-card?category_id=${this.category.id}`,
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
                axios.get(`${this.baseUrl}&paginate=100&page=${this.page}`).then((response) => {
                    this.skills = response.data.data.data;
                    this.page = response.data.data.current_page;
                    this.lastPage = response.data.data.last_page;
                }).catch(function(error){
                    console.log(error);
                });
            },
            create(){
                let data = new FormData();
                data.append('number', this.skillCard['number']);
                data.append('category_id', this.category.id);
                axios.post(`/api/skills-card`, data).then((response) => {
                    if (response.status === 200){
                        window.alert(response.data.message);
                        let data = response.data.data;
                        data['used'] = 0;
                        this.skills.push(data);
                        this.skillCard = [];
                    }
                }).catch(function(error){
                    window.alert(error.response.data.message);
                    console.log(error);
                });
            },
            createRange(){
                let data = new FormData();
                data.append('first', this.range['first']);
                data.append('second', this.range['second']);
                data.append('start', this.range['start']);
                data.append('range', this.range['range']);
                data.append('category_id', this.category.id);
                axios.post(`/api/skills-card-range`, data).then((response) => {
                    window.alert(response.data.message);
                    if (response.status === 200){
                        let data = response.data.data;

                        for (let i = 0; i < data.length; i++) {
                            data[i].used = 0;
                            this.skills.push(data[i]);
                        }
                        this.range = [];
                    }
                }).catch(function(error){
                    console.log(error);
                });
            },
            update(index){
                let data = new FormData();
                data.append('used', this.skills[index].used);
                console.log(this.skills[index].used);
                axios.post(`/api/skills-card/${this.skills[index].id}`, data).then((response) => {
                    window.alert(response.data.message);
                    console.log(response);
                }).catch(function(error){
                    console.log(error);
                });
            },
            remove(index){
                if(confirm('Are you sure you want to delete it?!')) {
                    axios.delete(`/api/skills-card/${this.skills[index].id}`).then((response) => {
                        window.alert(response.data.message);
                        if (response.status === 200) {
                            this.skills.splice(index, 1);
                        }
                    }).catch(function (error) {
                        console.log(error);
                    });
                }
            },
            plusOne(){
                if (this.page < this.lastPage){
                    this.page++;
                    this.getData();
                }
            },
            minusOne(){
                if (this.page > 1){
                    this.page--;
                    this.getData();
                }
            }
        }
    }
</script>

<style scoped>
    td{
        text-align: center;
    }
</style>
