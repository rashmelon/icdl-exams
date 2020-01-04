<template>
    <div class="container-fluid">
        <div class="jumbotron jumbotron-fluid mt-3 p-3 d-flex justify-content-between">
            <a :href="'/category/'+category.id" class="btn btn-outline-dark"><i class="fa fa-arrow-left mr-2" aria-hidden="true"></i>back</a>
            <div class="h3">
                {{category.name}}
            </div>
            <b-button v-b-toggle.addNewSkillcard variant="primary"><i class="fa fa-plus mr-2" aria-hidden="true"></i>New Number</b-button>
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
                <td>{{index+1}}</td>
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
                used: ['used', 'unused']
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
                axios.get(`/api/skills-card?category_id=${this.category.id}`).then((response) => {
                    this.skills = response.data.data;
                }).catch(function(error){
                    console.log(error);
                });
            },
            create(){
                let data = new FormData();
                data.append('number', this.skillCard['number']);
                data.append('category_id', this.category.id);
                axios.post(`/api/skills-card`, data).then((response) => {
                    window.alert(response.data.message);
                    if (response.status === 200){
                        let data = response.data.data;
                        data['used'] = 0;
                        this.skills.push(data);
                        this.skillCard = [];
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
                axios.delete(`/api/skills-card/${this.skills[index].id}`).then((response) => {
                    window.alert(response.data.message);
                    if (response.status === 200){
                        this.skills.splice(index, 1);
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
