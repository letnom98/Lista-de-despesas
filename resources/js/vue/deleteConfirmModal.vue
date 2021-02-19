<template>
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <div class="modal-header">
                        <h3>Tem certeza que deseja excluir essa despesa?</h3>
                    </div>
                    <div class="modal-body">
                        Uma vez excluída, essa despesa não poderá ser recuperada. 
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" @click="$emit('close')">Cancelar</button>
                        <button class="btn btn-success" @click="$emit('delete')">Prosseguir</button>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
export default {

}
</script>

<style scoped>
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
    text-align: center;
}

.modal-mask .modal-wrapper .modal-container .modal-header{
    display: block;
    font-size: 0.2em;
    border: none;
}
  
.modal-mask .modal-wrapper .modal-container .modal-body {
    display: block;
    padding: 10px;
    margin: auto;
    border: none;
    font-size: 0.9em;
}


.modal-mask .modal-wrapper .modal-container .modal-footer{
    display: block;
    padding: 8px 0px;
    border: none;
    text-align: center;
}

.modal-mask .modal-wrapper .modal-container button{
    padding: 0.8em;
    margin: 0 30px;

}

</style>