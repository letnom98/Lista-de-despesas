<template>
  <transition name="modal">
  <div class="modal-mask">
    <div class="modal-wrapper ">
        <div class="modal-container">
            <div class="modal-body">
                  <ul v-if="error.hasError">
                    <li class="text-danger" v-for="(message,index) in error.messages" :key="index">
                        <h6>{{message[0]}}</h6>
                    </li>
                  </ul>
                    <form>
                      <div class="row">
                          <div class="form-group col-12">
                            <label for="title">Estabelecimento</label>
                            <input id="title"  class="form-control" v-model="bill.title" type="text" placeholder="Digite o estabelecimento da sua despesa...">
                          </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-12 ">
                          <label for="cost">Valor</label>
                          <input id="cost" class="form-control" type="number" step="0.01" v-model="bill.cost" placeholder="Digite o valor da sua despesa..." >
                        </div>
                      </div>
                      <div class="row justify-content-md-between">
                        <div class="form-group col-12 col-lg-6 ">
                          <label for="date">Data</label>
                          <input id="date" class="form-control" type="date" :max='today' v-model="bill.date">
                        </div>
                        <div class="form-group col-12 col-lg-6">
                          <label for="category">Categoria</label>
                          <select id='category' class="form-control" v-model="bill.category">
                            <option value="Lazer">Lazer</option>
                            <option value='Alimentação'>Alimentação</option>
                            <option value="Lojas">Lojas</option>
                            <option value="Automóvel">Automóvel</option>
                            <option value="Serviços">Serviços</option>
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group">  
                          <label for="description">Descrição</label>
                          <input id="description" class="form-control" v-model="bill.description" type="text" placeholder="Descreva sua despesa...">
                        </div>
                      </div>
                    </form>
              </div>
              <div class="modal-footer">
                      <div class="col-5 text-center">
                        <router-link :to="{name: 'home'}" class="btn btn-danger"> 
                            Cancelar 
                            <span>
                              <i class="fas fa-times fa-xs"></i>
                            </span>
                        </router-link>
                      </div>
                      <div class="col-5 text-center">
                        <button class="btn btn-success"
                          @click.stop.prevent="addBill()"> 
                            Adicionar  
                            <span>
                              <i class="fas fa-plus fa-xs"></i>
                            </span>
                        </button>
                      </div>
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
      bill: {
        title:'',
        category:'Lazer',
        description:'',
        cost: '',
        date:''
      },
      error:{
        hasError:false,
        messages:[]
      },
      today:''
    }
  },
  methods:{
    addBill(){
      this.error.hasError = false
      this.error.messages = []
      axios.post('api/item/store',{
        item: this.bill
      })
      .then(response => {
        if(response.status == 201){
          this.bill.title =''
          this.bill.date=''
          this.bill.cost=''
          this.bill.description=''
          this.bill.category = ''
          this.error.hasError = false
          this.error.messages.length = 0
          this.$emit('reload')
          this.$router.push({name:'home'})
        }
      })
      .catch(error=>{
        this.error.hasError = true
        this.error.messages = error.response.data.errors
        console.log(this.error.messages);
      })
     },
     getCurrentDate(){
       let today = new Date().toISOString().slice(0, 10)
       this.today = today
     }
   },
   created(){
     this.getCurrentDate();
   }
}
</script>

<style scoped>


  .btn{
    color: white;
    margin:5px;
  }

  .modal-mask {
    position: fixed;
    z-index: 9999;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: table;
    transition: opacity 0.3s ease;
}
.modal-mask .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
}
.modal-mask .modal-wrapper .modal-container {
        width: 60%;
        margin: 0px auto;
        padding: 5px 20px;
        background-color: #fff;
        border-radius: 5px;
        padding: 0.5em 2em;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
        transition: all 0.3s ease;
        max-height: calc(100vh - 100px);
        overflow-y: auto;
    }
  
.modal-mask .modal-wrapper .modal-container .modal-body {
        padding: 10px;
        margin: auto;
    }

.form-group label {
            font-size: 1.2em;
    } 

.form-group {
            margin: 8px 0;
    } 

.modal-mask .modal-wrapper .modal-container .modal-footer {
  padding: 5px 0px;
  border: none;
  justify-content: center;
}


</style>