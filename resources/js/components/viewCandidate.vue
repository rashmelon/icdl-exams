<template>
    <div class="container-fluid w-auto">
        <div class="jumbotron jumbotron-fluid mt-3 p-3 d-flex justify-content-between">
            <a href="/" class="btn btn-outline-dark"><i class="fa fa-arrow-left mr-2" aria-hidden="true"></i>back</a>
            <div class="h3" v-if="candidate.skills_card">
                {{candidate.skills_card.category.name}}
            </div>
            <div class=""></div>
        </div>
        <b-card class="shadow mb-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>arabic name</label>
                        <input class="form-control text-right" v-model="candidate['arabic_name']" placeholder="arabic name" dir="rtl">
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
                        <label>Absence</label>
                        <input class="form-control" v-model="candidate['absence']" placeholder="notes">
                    </div>
                </div>
                <div class="col-md-4">
                    <label>Certificate</label>
                    <select class="form-control" v-model="candidate.certificate_state">
                        <template v-for="(state) in states">
                            <option :value="state">
                                {{state}}
                            </option>
                        </template>
                    </select>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>notes</label>
                        <input class="form-control" v-model="candidate['notes']" placeholder="notes">
                    </div>
                </div>
                <div class="col-md-4" v-if="candidate['skills_card']">
                    <div class="form-group">
                        <label>Skill number</label>
                        <br>
                        <span>{{candidate['skills_card']['number']}}</span>
                    </div>
                </div>

                <div class="col-md-4" v-else>
                    <div class="form-group">
                        <label>Choose Skill</label>
                        <select type="" class="form-control" v-model="category" @change="getSkills">
                            <option v-for="cat in categories" :value="cat.id">
                                {{ cat.name }}
                            </option>
                        </select>

                        <select type="" class="form-control" v-model="candidate['skills_card']" @change="getSkills">
                            <option v-for="sk in skillsCards" :value="sk">
                                {{ sk.number }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Finished</label>
                        <input class="form-control" type="checkbox" v-model="candidate['finished']" placeholder="notes">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <button class="btn btn-primary" @click="update">Update</button>
                    </div>
                </div>
            </div>
        </b-card>
        <hr>

        <div class="row">
            <div class="col-md-6">
                <candidate-reservation :candidate="candidate"></candidate-reservation>
            </div>
            <div class="col-md-6">
                <candidate-payment :candidate="candidate">

                </candidate-payment>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "viewCandidate",
        data: function () {
            return {
                skillsCards: [],
                categories: [],
                category: {},
                states:['', 'arrived', 'delivered'],
                payments: [],
                payment: {},
            }
        },
        props:{
            candidate: {
                required: true
            },
        },
        mounted(){
            this.getCategories();
        },
        methods:{
            getCategories(){
                axios.get(`/api/category`).then((response) => {
                    this.categories = response.data.data;
                    console.log(response);
                }).catch(function(error){
                    console.log(error);
                });
            },
            getSkills(){
                axios.get(`/api/skills-card?category_id=${this.category}&unused=true`).then((response) => {
                    this.skillsCards = response.data.data;
                    console.log(response);
                }).catch(function(error){
                    console.log(error);
                });
            },
            update(index){
                let data = new FormData();
                data.append('arabic_name', this.candidate.arabic_name);
                data.append('english_name', this.candidate.english_name);
                data.append('national_id', this.candidate.national_id);
                data.append('mobile1', this.candidate.mobile1);
                data.append('mobile2', this.candidate.mobile2);
                data.append('tests', this.candidate.tests);
                data.append('money', this.candidate.money);
                data.append('notes', this.candidate.notes);
                data.append('absence', this.candidate.absence);
                data.append('certificate_state', this.candidate.certificate_state);
                data.append('finished', this.candidate.finished?1:0);
                data.append('skills_card_id', this.candidate.skills_card['id']);
                axios.post(`/api/candidate/${this.candidate.id}`, data).then((response) => {
                    window.alert(response.data.message);
                    if (this.skill)
                        this.candidate.skills_card = this.skill;
                    console.log(response);
                }).catch(function(error){
                    console.log(error.response);
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
