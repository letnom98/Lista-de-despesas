<template>
  <div class="billsList">
      <Navigation></Navigation>
      <div class="view">
          <router-view></router-view>
      </div>
  </div>
</template>
<script>
import Navigation from './navigation'
export default {
    components: {
        Navigation
    }
}
</script>

<style scoped>
    .billsList{
        height: 100vh;
        margin: none;
        font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        /* background-color:#c9c4c4; */
    }
    .view{
        width:80%;
        font-size: 32px;
        margin: 30px auto;
        margin-top:0px;
        padding: 30px 0;
    }
</style>
