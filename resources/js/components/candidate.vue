<template>
    <div class="container-fluid">
        <div class="jumbotron jumbotron-fluid mt-3 p-3 d-flex justify-content-between">
            <a href="/category" class="btn btn-outline-dark"><i class="fa fa-arrow-left mr-2" aria-hidden="true"></i>back</a>
            <div class="h3">
                {{category.name}} Candidates
            </div>
            <b-button v-b-toggle.addNewCandidate variant="primary"><i class="fa fa-plus mr-2" aria-hidden="true"></i>New Candidate</b-button>
        </div>
        <b-collapse id="addNewCandidate" class="mt-2">
            <b-card class="shadow mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>arabic name</label>
                            <input class="form-control text-right" v-model="candidate['arabic_name']" placeholder="arabic name">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>english name</label>
                            <input class="form-control" v-model="candidate['english_name']" placeholder="english name">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>national id</label>
                            <input class="form-control" v-model="candidate['national_id']" placeholder="national id">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>first mobile</label>
                            <input class="form-control" v-model="candidate['mobile1']" placeholder="first mobile">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>second mobile</label>
                            <input class="form-control" v-model="candidate['mobile2']" placeholder="second mobile">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">

                            <label>number of tests</label>
                            <input type="number" min="0" class="form-control" v-model="candidate['tests']" placeholder="number of tests">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>money to be paid</label>
                            <input type="number" min="0" class="form-control" v-model="candidate['money']" placeholder="money to be paid">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>notes</label>
                            <input class="form-control" v-model="candidate['notes']" placeholder="notes">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Skill number</label>
                            <select class="form-control" v-model="candidate['skills_card']['id']">
                            <option v-for="(skill, index) in skillsCards"
                                    :selected="index === 0"
                                    :value="skill.id">
                                {{skill.number}}
                            </option>
                        </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <button class="btn btn-primary" @click="create">Create</button>
                        </div>
                    </div>
                </div>
            </b-card>
        </b-collapse>


        <hr>

        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <td class="align-middle">index</td>
                    <td class="align-middle" width="10%">Skill Card</td>
                    <td class="align-middle">Arabic Name</td>
                    <td class="align-middle">English Name</td>
                    <td class="align-middle">National ID</td>
                    <td class="align-middle" width="5%">First Mobile</td>
                    <td class="align-middle" width="5%">Second Mobile</td>
                    <td class="align-middle" width="5%"># Tests</td>
                    <td class="align-middle" width="5%"><i class="fa fa-usd" aria-hidden="true"></i></td>
                    <td class="align-middle">Notes</td>
                    <td class="align-middle">Cer. State</td>
                    <td class="align-middle">Finished</td>
                    <td class="align-middle">Update</td>
                    <td class="align-middle">Delete</td>
                </tr>
            </thead>
            <tbody class="table-hover">
                <tr v-for="(can, index) in candidates" :class="'state-'+can.finished">
                    <td>{{index+1}}</td>
                    <td v-if="can.skills_card && can.skills_card.number">{{can.skills_card.number}}</td>
                    <td v-else-if="can.skills_card || can.skills_card ===0">{{skillsCards[can.skills_card].number}}</td>
                    <td v-else>
                        <select class="form-control" v-model="can.skills_card">
                            <option v-for="(skill, index1) in skillsCards"
                                    :value="index1">
                                {{skill.number}}
                            </option>
                        </select>
                    </td>
                    <td><input class="form-control text-right" v-model="can.arabic_name"></td>
                    <td><input class="form-control" v-model="can.english_name"></td>
                    <td><input class="form-control" v-model="can.national_id"></td>
                    <td><input class="form-control" v-model="can.mobile1"></td>
                    <td><input class="form-control" v-model="can.mobile2"></td>
                    <td><input class="form-control" v-model="can.reservations_count+can.tests" type="number"></td>
                    <td><input class="form-control" v-model="can.money" type="number"></td>
                    <td><input class="form-control" v-model="can.notes"></td>
                    <td>
                        <select class="form-control" v-model="can.certificate_state">
                            <template v-for="(state) in states">
                                <option v-if="state === can.certificate_state" selected :value="state">
                                    {{state}}
                                </option>
                                <option v-else :value="state">
                                    {{state}}
                                </option>
                            </template>
                        </select>
                    </td>
                    <td><input type="checkbox" class="form-control" v-model="can.finished"></td>

                    <td><button class="btn btn-primary" @click="update(index)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td>
                    <td><button class="btn btn-danger" @click="remove(index)"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>
                </tr>
            </tbody>
        </table>

    </div>

</template>

<script>
    import skillsCard from "./skillsCard";

    export default {
        name: "candidate",
        data: function () {
            return {
                candidate: {'skills_card':[]},
                candidates: [],
                skillsCards: [],
                states:['', 'arrived', 'delivered'],
            }
        },
        mounted(){
            this.getData();
            this.getSkills();
        },
        props:{
            category: {
                required: true
            }
        },
        methods:{
            getData(){
                axios.get(`/api/candidate?category_id=${this.category.id}&reservations_count=true`).then((response) => {
                    this.candidates = response.data.data;
                }).catch(function(error){
                    console.log(error);
                });
            },
            getSkills(){
                axios.get(`/api/skills-card?category_id=${this.category.id}&unused=true`).then((response) => {
                    this.skillsCards = response.data.data;
                    console.log(response);
                }).catch(function(error){
                    console.log(error);
                });
            },
            create(){
                let data = new FormData();
                data.append('arabic_name', this.candidate['arabic_name']);
                data.append('english_name', this.candidate['english_name']);
                data.append('national_id', this.candidate['national_id']);
                data.append('mobile1', this.candidate['mobile1']);
                data.append('mobile2', this.candidate['mobile2']);
                data.append('tests', this.candidate['tests']);
                data.append('money', this.candidate['money']);
                data.append('notes', this.candidate['notes']);
                data.append('skills_card_id', this.candidate['skills_card']['id']);

                axios.post(`/api/candidate`, data).then((response) => {
                    window.alert(response.data.message);
                    if (response.status === 200){
                        this.candidates.push(response.data.data);
                        this.candidate = {'skills_card':[]};
                    }
                }).catch(function(error){
                    console.log(error);
                });
            },
            update(index){
                let data = new FormData();
                data.append('arabic_name', this.candidates[index].arabic_name);
                data.append('english_name', this.candidates[index].english_name);
                data.append('national_id', this.candidates[index].national_id);
                data.append('mobile1', this.candidates[index].mobile1);
                data.append('mobile2', this.candidates[index].mobile2);
                data.append('tests', this.candidates[index].tests);
                data.append('money', this.candidates[index].money);
                data.append('notes', this.candidates[index].notes);
                data.append('certificate_state', this.candidates[index].certificate_state);
                data.append('finished', this.candidates[index].finished?1:0);
                console.log(index);
                if ((this.candidates[index].skills_card || this.candidates[index].skills_card === 0) && !this.candidates[index].skills_card.number){
                    data.append('skills_card_id', this.skillsCards[this.candidates[index].skills_card]['id']);
                    console.log(this.skillsCards[this.candidates[index].skills_card]['id']);
                }
                axios.post(`/api/candidate/${this.candidates[index].id}`, data).then((response) => {
                    window.alert(response.data.message);
                    if ((this.candidates[index].skills_card || this.candidates[index].skills_card === 0) && !this.candidates[index].skills_card.number)
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
    .state-1 , .state-true{
        background: rgba(202, 197, 66, 0.64);
    }
</style>
