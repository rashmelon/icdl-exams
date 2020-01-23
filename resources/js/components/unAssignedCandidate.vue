<template>
    <div class="container-fluid w-auto">
        <div class="jumbotron jumbotron-fluid mt-3 p-3 d-flex justify-content-between">
            <a href="/" class="btn btn-outline-dark"><i class="fa fa-arrow-left mr-2" aria-hidden="true"></i>back</a>
        </div>
        <table class="table table-bordered table-hoverable">
            <thead class="thead-dark">
            <tr>
                <td class="align-middle">#</td>
                <td class="align-middle" width="10%">Skill Card</td>
                <td class="align-middle">Arabic Name</td>
                <td class="align-middle">English Name</td>
                <td class="align-middle" style="width: 150px">National ID</td>
                <td class="align-middle" width="10%">First Mobile</td>
                <!--<td class="align-middle" width="5%">Second Mobile</td>-->
                <td class="align-middle" width="5%">#Tests</td>
                <td class="align-middle" width="5%">Absence</td>
                <!--<td class="align-middle">Notes</td>-->
                <td class="align-middle">Cer. State</td>
                <td class="align-middle">Finished</td>
                <td class="align-middle">View</td>
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
                            {{skill.category.name}} {{skill.number}}
                        </option>
                    </select>
                </td>
                <td><input class="form-control text-right" v-model="can.arabic_name"></td>
                <td><input class="form-control" v-model="can.english_name"></td>
                <td><input class="form-control" v-model="can.national_id" style="width: 150px"></td>
                <td><input class="form-control" v-model="can.mobile1"></td>
                <!--<td><input class="form-control" v-model="can.mobile2"></td>-->
                <td><input class="form-control" v-model="can.reservations_count+can.tests" type="number"></td>
                <td><input class="form-control" v-model="can.absence" type="number"></td>
                <!--<td><input class="form-control" v-model="can.notes"></td>-->
                <td>
                    <select class="form-control" v-model="can.certificate_state">
                        <template v-for="(state) in states">
                            <option :value="state">
                                {{state}}
                            </option>
                        </template>
                    </select>
                </td>
                <td><input type="checkbox" class="form-control" v-model="can.finished"></td>
                <td><a :href="`/candidate/${can.id}`" target="_blank"><button class="btn btn-success"><i class="fa fa-eye" aria-hidden="true"></i></button></a></td>
                <td><button class="btn btn-primary" @click="update(index)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td>
                <td><button class="btn btn-danger" @click="remove(index)"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>
            </tr>
            </tbody>
        </table>

    </div>

</template>

<script>

    export default {
        name: "unAssignedCandidate",
        data: function () {
            return {
                candidate: {'skills_card':[], 'mobile2':''},
                candidates: [],
                skillsCards: [],
                states:['', 'arrived', 'delivered'],
            }
        },
        mounted(){
            this.getData();
            this.getSkills();
        },
        methods:{
            getData(){
                axios.get(`/api/candidate?unassigned=true`).then((response) => {
                    this.candidates = response.data.data;
                }).catch(function(error){
                    console.log(error);
                });
            },
            getSkills(){
                axios.get(`/api/skills-card?unused=true`).then((response) => {
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
                data.append('tests', this.candidate['tests']? this.candidate['tests']:0);
                data.append('money', this.candidate['money']? this.candidate['money']:0);
                data.append('notes', this.candidate['notes']);
                if (this.candidate['skills_card']['id'])
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
                if(confirm('Are you sure you want to delete it?!')){
                    axios.delete(`/api/candidate/${this.candidates[index].id}`).then((response) => {
                        window.alert(response.data.message);
                        if (response.status === 200){
                            this.candidates.splice(index, 1);
                        }
                    }).catch(function(error){
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
    .state-1 , .state-true{
        background: rgba(202, 197, 66, 0.64);
    }
</style>
