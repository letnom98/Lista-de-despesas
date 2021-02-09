<template>
  <transition name="fade">
      <div class="card" id="filter">
          <div class="card-body">
              <form>
                <div class="row mb-4">
                    <div class="form-group col-md-6">
                        <label for="establishment">Estabelecimento</label>
                        <input id="establishment" type="text" v-model="search.title" class="form-control" placeholder="Estabelecimento"/>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="cost">Valor</label>
                        <input id="cost" v-model="search.cost" type="number" step="0.01" class="form-control" />
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="form-group col-md-4">
                            <label for="date">Data</label>
                            <input id="date" v-model="search.date" type="date" class="form-control" />
                    </div>
                    <div class="form-group col-md-4">
                        <label for="category">Categoria</label>
                        <select id="category" class="form-control" v-model="search.category">
                            <option value="Lazer">Lazer</option>
                            <option value='Alimentação'>Alimentação</option>
                            <option value="Lojas">Lojas</option>
                            <option value="Automóvel">Automóvel</option>
                            <option value="Serviços">Serviços</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="payment_status">Status de pagamento</label>
                        <select id="payment_status" class="form-control" v-model="search.paid">
                            <option value="1">Paga</option>
                            <option value="0">Aguardando Pagamento</option>
                        </select>
                    </div>
                </div>
            </form>
            <div class="row text-white mt-3 mb-3">
                        <div class="col text-center">
                            <button class="btn btn-danger" @click="$emit('close')"><span v-if="window.width>600">Cancelar </span><i class="fas fa-times"></i></button>
                        </div>
                        <div class="col text-center">
                            <button class="btn btn-success" @click="filter()"><span v-if="window.width>600">Buscar </span><i class="fas fa-search"></i></button>
                        </div>
            </div>
          </div>
      </div>
  </transition>
</template>

<script>
export default {
    data(){
        return{
            search:{
                title: '',
                cost: 0,
                date: '',
                category: '',
                paid:''
            },
            window:{
                width:0,
                height:0
            }
        }
    },
    created() {
        window.addEventListener('resize', this.onResize),
        this.onResize()
    },
    destroyed() {
        window.removeEventListener('resize', this.onResize)
    },
    methods:{
        onResize() {
            this.window.width = window.innerWidth;
            this.window.height = window.innerHeight;
        },
        filter(){
            let filterQuery = ''
            Object.keys(this.search).forEach(key=>{
                if(this.search[key]!=''){
                    filterQuery = filterQuery == '' ? filterQuery + `${key}=${this.search[key]}` : filterQuery + `&&${key}=${this.search[key]}`
                }
            })
            if(this.$route.query.filter != filterQuery){  
                this.$router.push({name:'home',query:{filter:filterQuery}})
            }
            this.$emit('reloadList')
            this.$emit('close')
        }
    }
}
</script>

<style scoped>
    .card{
        background-color: none !important;
        border-color: #c1c1c1c1;
        border-style: solid;
    }
</style>