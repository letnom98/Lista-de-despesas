<template>
    <div>
        <nav class="navbar navbar-dark bg-dark">
            <a class="navbar-brand" href="/">Lista de despesas</a>
            <div class="text-end">
                <router-link :to="{name:'addItem'}" class="btn btn-light ml-5"> Adicionar <span><i class="fas fa-plus"></i></span></router-link>
            </div>
        </nav>
    </div>
</template>

<script>
// import AddItem from './addItem'
export default {
    // components:{
    //     AddItem
    // }
}
</script>

<style>
    nav{
        padding: 15px;
    }
</style>