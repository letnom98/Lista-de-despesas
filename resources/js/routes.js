
import Vue from 'vue';
import VueRouter from 'vue-router';
import ListView from './vue/listView.vue';
import AddItem from './vue/addItem.vue';
Vue.use(VueRouter);
export const router = new VueRouter({
    routes: [
        {
            path: '/', name: 'home', component: ListView,
            children: [
                { path: 'add', name:'addItem' , component: AddItem}
            ]
        }
    ]
})  