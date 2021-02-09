<template>
  <transition class="modal fade"  role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <a class="close" @click.stop.prevent="$router.replace({name:'home'})">
          <i class="fa fa-close text-danger" ></i>
        </a>
      </div>
      <div class="modal-body">
        <ul v-if="error.hasError">
          <li class="text-danger" v-for="(message,index) in error.messages" :key="index">
              <h6>{{message[0]}}</h6>
          </li>
        </ul>
        <form>
                          <div class="form-group col-12">
                            <label for="title">Estabelecimento</label>
                            <input id="title"  class="form-control" v-model="bill.title" type="text" placeholder="Digite o estabelecimento da sua despesa...">
                          </div>
                          <div class="form-group d-inline-block col-12 ">
                            <label for="cost">Valor</label>
                            <input id="cost" class="form-control" type="number" step="0.01" v-model="bill.cost" placeholder="Digite o valor da sua despesa..." >
                          </div>
                          <div class="form-group d-inline-block col-12 col-lg-5">
                            <label for="date">Data</label>
                            <input id="date" class="form-control" type="date" :max='today' v-model="bill.date">
                          </div>
                          <div class="form-group d-inline-block col-12 col-lg-5">
                            <label for="category">Categoria</label>
                            <select id='category' class="form-control" v-model="bill.category">
                              <option value="Lazer">Lazer</option>
                              <option value='Alimentação'>Alimentação</option>
                              <option value="Lojas">Lojas</option>
                              <option value="Automóvel">Automóvel</option>
                              <option value="Serviços">Serviços</option>
                            </select>
                          </div>
                          <div class="form-group">  
                            <label for="description">Descrição</label>
                            <input id="description" class="form-control" v-model="bill.description" type="text" placeholder="Descreva sua despesa...">
                          </div>
                        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success"
        @click.stop.prevent="addBill()"> 
          Adicionar  
          <span>
            <i class="fas fa-plus fa-1x"></i>
          </span>
        </button>
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

  .form-group{
    margin:8px;
  }

</style>