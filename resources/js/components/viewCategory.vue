<template>
    <div class="container-fluid w-auto">

        <div class="jumbotron jumbotron-fluid mt-3 p-3 d-flex justify-content-between">
            <a :href="'/category'" class="btn btn-outline-dark"><i class="fa fa-arrow-left mr-2" aria-hidden="true"></i>back</a>
            <div class="h3">
                {{category.name}}
            </div>
            <div class=""></div>
        </div>

        <div class="d-flex flex-column">

            <div class="my-3">
                <a class="btn btn-primary" :href="`/category/${category.id}/skills-card`">Skills Card</a>
            </div>

            <div class="my-3">
                <a class="btn btn-primary" :href="`/category/${category.id}/subject`">Subject</a>
            </div>

            <div class="my-3">
                <a class="btn btn-primary" :href="`/category/${category.id}/candidate`">Candidates</a>
            </div>

        </div>

    </div>
</template>

<script>
    export default {
        name: "viewCategory",
        props:{
            category: {
                required: true
            }
        },
    }
</script>

<style scoped>
    td{
        text-align: center;
    }
</style>
