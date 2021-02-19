<template>
    <div class="container list">
        <router-view @reload="hasQuery()"></router-view>
        <div class="row align-items-center">
            <div class="col-9">
                <h1>Despesas</h1>
            </div>
            <div class="col-3 text-end">
                <button class="btn btn-success" @click="filterForm = !filterForm">
                    <span v-if="window.width>600">Filtrar </span><i class="fas fa-filter"></i>
                </button>
            </div>
            <FilterForm v-if="filterForm" @close="filterForm=false" @reloadList="hasQuery()"></FilterForm>
        </div>
        <div v-if="bills.length > 0" class="row align-items-center">
            <div class="col-12">
                    Total: R$ {{total.toFixed(2)}}
            </div>
        </div>
        <div v-show="bills.length < 1" class="text-center mt-5">
            <h3> Nenhuma despesa encontrada!</h3>
        </div>
        <div v-for="(bill,index) in bills" :key="index">
            <ListItem  :bill="bill" @billchanged="getBillsList()"></ListItem>
        </div>
    </div>
</template>

<script>
import FilterForm from './filterForm'
import ListItem from './listItem'
export default {
    components:{
        ListItem,
        FilterForm
    },
    data(){
        return{
            bills:[],
            total:0,
            filterForm:false,
            window:{
                width:0,
                height:0
            }
        }
    },
    methods:{
        hasQuery(){
            if(typeof this.$route.query.filter != 'undefined'){
                this.getBillsList(this.$route.query.filter)
            }
            else{
                this.getBillsList()
            }
        },
        getBillsList(params = ''){
            axios.get('api/items/?' + params)
            .then( response =>{
                this.bills = response.data
                this.total = 0
                this.bills.forEach(e => {
                    this.total += e.cost
                });
            })
            .catch(error=>{
                console.log(error)
            })

        },
        onResize() {
            this.window.width = window.innerWidth;
            this.window.height = window.innerHeight;
        }
    },
    created(){
        this.hasQuery(),
        window.addEventListener('resize', this.onResize),
        this.onResize()
    },
    destroyed() {
        window.removeEventListener('resize', this.onResize)
    }
}
</script>

<style>

    .list{
        width:100%;
        margin:20px 0px;
        font-size: 20px;
    }

</style>