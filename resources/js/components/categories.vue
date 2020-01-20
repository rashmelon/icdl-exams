 <template>
    <div class="container-fluid w-auto">


        <div class="jumbotron jumbotron-fluid mt-3 p-3 d-flex justify-content-between">
            <a href="/" class="btn btn-outline-dark"><i class="fa fa-arrow-left mr-2" aria-hidden="true"></i>back</a>
            <div class="h3">
                Categories
            </div>
            <b-button v-b-toggle.addNewCandidate variant="primary"><i class="fa fa-plus mr-2" aria-hidden="true"></i>New Category</b-button>
        </div>
        <b-collapse id="addNewCandidate" class="mt-2">
            <b-card class="shadow mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <input class="form-control" v-model="category.name" placeholder="name">
                    </div>
                    <div class="col-md-4">
                        <input type="number" class="form-control" v-model="category.free_tests" placeholder="Free Tests">
                    </div>
                    <div class="col">
                        <button class="btn btn-primary" @click="create">Create</button>
                    </div>
                </div>
            </b-card>
        </b-collapse>


        <hr>

        <table class="table table-bordered table-responsive-lg">
            <thead>
                <tr>
                    <!--<td>index</td>-->
                    <td>name</td>
                    <td>Total Skills</td>
                    <td>Used Skills</td>
                    <td>Unused Skills</td>
                    <td>Free Tests</td>
                    <td>Subjects</td>
                    <td>SkillsCard</td>
                    <td>Subject</td>
                    <td>Candidate</td>
                    <td>Update</td>
                    <td>Delete</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(cat, index) in categories">
                    <!--<td width="3%">{{index+1}}</td>-->
                    <td width="20%"><input class="form-control" v-model="cat.name" style="min-width: 140px;"></td>
                    <td width="8%">{{cat.total}}</td>
                    <td width="8%">{{cat.used}}</td>
                    <td width="8%">{{cat.unused}}</td>
                    <td width="8%">{{cat.free_tests}}</td>
                    <td width="8%">{{cat.subjects.length}}</td>
                    <td width="3%"><a class="btn btn-success" :href="`/category/${cat.id}/skills-card`"><i class="fa fa-credit-card fa-2x" aria-hidden="true"></i></a></td>
                    <td width="3%"><a class="btn btn-info" :href="`/category/${cat.id}/subject`"><i class="fa fa-sticky-note-o fa-2x" aria-hidden="true"></i></a></td>
                    <td width="3%"><a class="btn btn-primary" :href="`/category/${cat.id}/candidate`"><i class="fa fa-user-secret fa-2x" aria-hidden="true"></i></a></td>
                    <td width="3%"><button class="btn btn-warning" @click="update(index)"><i class="fa fa-pencil-square-o text-white fa-2x" aria-hidden="true"></i></button></td>
                    <td width="3%"><button class="btn btn-danger" @click="remove(index)"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button></td>
                </tr>
            </tbody>
        </table>

    </div>

</template>

<script>
    export default {
        name: "categories",
        data: function () {
            return {
                category: {},
                categories: [],
            }
        },
        mounted(){
            this.getData();
        },
        methods:{
            getData(){
                axios.get(`/api/category`).then((response) => {
                    this.categories = response.data.data;
                    for (var i = 0; i < this.categories.length; i++){
                        var used = 0, unused = 0;
                        for(var j = 0; j < this.categories[i].skills_cards.length; j++){
                            this.categories[i].skills_cards[j].used? used++:unused++;
                        }
                        this.categories[i]['used'] = used;
                        this.categories[i]['unused'] = unused;
                        this.categories[i]['total'] = used+unused;
                    }
                }).catch(function(error){
                    console.log(error);
                });
            },
            create(){
                let data = new FormData();
                data.append('name', this.category.name);
                data.append('free_tests', this.category.free_tests);
                axios.post(`/api/category`, data).then((response) => {
                    window.alert(response.data.message);
                    if (response.status === 200){
                        var data = response.data.data;
                        data['used'] = 0;
                        data['unused'] = 0;
                        data['total'] = 0;
                        data['subjects'] = [];
                        this.categories.push(data);
                        this.category = {};
                    }
                }).catch(function(error){
                    console.log(error);
                });
            },
            update(index){
                let data = new FormData();
                data.append('name', this.categories[index].name);
                axios.post(`/api/category/${this.categories[index].id}`, data).then((response) => {
                    window.alert(response.data.message);
                    console.log(response);
                }).catch(function(error){
                    console.log(error);
                });
            },
            remove(index){
                if(confirm('Are you sure you want to delete it? \n اتاكد تاني!')) {
                    axios.delete(`/api/category/${this.categories[index].id}`).then((response) => {
                        window.alert(response.data.message);
                        if (response.status === 200) {
                            this.categories.splice(index, 1);
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
