<template>
    <div>
        <b>#{{ candidate.skills_card.number }}</b>
        <span>{{ candidate.name }}</span>
    </div>
</template>

<script>
    export default {
        name: "candidateItem",
        props:{
            candidate: {
                required: true
            }
        },
        mounted(){
            console.log(this.candidate);
        },
    }
</script>

<style scoped>

</style>
