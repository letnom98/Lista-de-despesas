<template>
<div class="card mt-3">
  <div class="card-body">
      <!-- Card Normal -->
      <div v-if="!editing">
        <div class="card-title">
            <div class="row">
                <div class=" col-12 col-sm-8">
                    <h5>{{bill.title}}</h5>
                </div>
                <div class="col-12 col-sm-4 text-md-end ">
                    <h5>{{formatDate(bill.date)}}</h5>
                </div>
            </div>
        </div>
        <h6 class="card-subtitle mb-2">Custo : R$ {{bill.cost.toFixed(2)}}</h6>
        <h6 class="card-subtitle mb-2">Categoria: {{bill.category}}</h6>
        <h6 v-if="bill.paid" class="card-subtitle mb-2">Status: <span class="text-success">Paga</span></h6>
        <h6 v-else class="card-subtitle mb-2">Status: <span class="text-danger">Aguardando pagamento</span></h6>
        <p class="card-text">{{bill.description}}</p>
        <div class="row justify-content-between text-center options">
            <div class="col mt-2 mb-2"  v-show="!bill.paid">
                <button class="btn btn-success text-white" @click="payBill()"><span v-if="window.width > 600">Pagar </span><i class="fas fa-money-bill"></i></button>
            </div>
            <div class="col mt-2 mb-2">
                <button class="btn btn-primary text-white" @click="openEditingMenu();editing=true"><span v-if="window.width > 600">Editar </span> <i class="fas fa-pen"></i></button>
            </div>
            <div class="col mt-2 mb-2">
                <button class="btn btn-danger text-white" @click="showDeleteConfirmModal=true"><span v-if="window.width > 600">Deletar </span><i class="fas fa-trash"></i></button>
            </div>
        </div>
      </div>
      <!-- Modo edição -->
      <div v-else>
            <ul v-if="error.hasError">
                <li class="text-danger" v-for="(message,index) in error.messages" :key="index">
                    <h6>{{message[0]}}</h6>
                </li>
            </ul>
            <form>
                <div class="row">
                    <div class="form-group col-md-8">
                        <input type="text" class="form-control" v-model="edited.title" placeholder="Estabelecimento">
                    </div>
                    <div class="form-group col-md-4">
                        <input type="date" class="form-control" :max="today" v-model="edited.date">
                    </div>
                </div>
                <div class="form-group ">
                    <input type="number" class="form-control" step="0.01" v-model="edited.cost">
                </div>
                <div class="form-group">
                    <select class="form-control" v-model="edited.category">
                        <option value="Lazer">Lazer</option>
                        <option value='Alimentação'>Alimentação</option>
                        <option value="Lojas">Lojas</option>
                        <option value="Automóvel">Automóvel</option>
                        <option value="Serviços">Serviços</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" v-model="edited.description" placeholder="Descrição">
                </div>
                <div class="form-row">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="paidCheck" v-model="edited.paid">
                        <label class="form-check-label" for="paiCheck">
                            Foi paga
                        </label>
                    </div>
                </div>
            </form>
            <div class="row justify-content-between text-center options">
                <div class="col mt-2 mb-2">
                    <button class="btn btn-danger text-white" @click="error.hasError = false;editing=false"><span v-if="window.width > 600">Cancelar </span> <i class="far fa-times-circle"></i></button>
                </div>
                <div class="col mt-2 mb-2">
                    <button class="btn btn-success text-white" @click="updateCheck(edited)"><span v-if="window.width > 600">Concluir </span><i class="far fa-check-circle"></i></button>
                </div>
            </div>
      </div>
  </div>
  <DeleteConfirmModal v-if="showDeleteConfirmModal" @close="showDeleteConfirmModal=false" @delete="showDeleteConfirmModal=false;removeItem()"></DeleteConfirmModal>
</div>
</template>

<script>
import DeleteConfirmModal from './deleteConfirmModal'
export default {
    props:['bill'],
    components:{
        DeleteConfirmModal
    },
    data(){
        return{
            today:'',
            editing:false,
            edited:{
                title:'',
                date:[],
                cost:0,
                category:'',
                description:'',
                paid:false
            },
            showDeleteConfirmModal:false,
            window:{
                width:0,
                height:0
            },
            error:{
                hasError:false,
                messages:[]
            }
        }
    },
    created() {
        window.addEventListener('resize', this.onResize),
        this.onResize(),
        this.getCurrentDate()
    },
    destroyed() {
        window.removeEventListener('resize', this.onResize)
    },
    methods:{
        getCurrentDate(){
            let today = new Date().toISOString().slice(0, 10)
            this.today = today
        },
        onResize() {
            this.window.width = window.innerWidth;
            this.window.height = window.innerHeight;
        },
        updateCheck(UpdatedObject = this.bill){
            this.error.hasError = false
            this.error.messages=[]
            axios.put('api/item/' + this.bill.id,{
                item:UpdatedObject
            })
            .then(response => {
                if(response.status == 200 ){
                    this.editing=false
                    this.$emit('billchanged')
                }
            })
            .catch( error => {
                this.error.messages = error.response.data.errors
                this.error.hasError = true
            })
        },
        payBill(){
            this.bill.paid = true
            this.updateCheck()
        },
        removeItem(){
            axios.delete('api/item/' + this.bill.id)
            .then( response => {
                if(response.status == 200){
                    this.$emit('billchanged')
                }
            })
            .catch(error => {
                console.log( error )
            })
        },
        openEditingMenu(){
            this.edited.title = this.bill.title
            this.edited.date = this.bill.date
            this.edited.cost = this.bill.cost
            this.edited.category = this.bill.category
            this.edited.description = this.bill.description
            this.edited.paid = this.bill.paid
        },
        formatDate(){
            let date =[]
            date = this.bill.date.split('-')
            return date[2] + '/' + date[1] + '/' + date[0]
        }
    }
}
</script>
<style>
    .card{
        border-radius: 15px;
        background-color:#c9c4c4;
    }
    .options .btn{
        width: 90%;
    }
</style>