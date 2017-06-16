<template>
    <div class="item">
        <p v-if="isFolder" @dblclick="toggle" class="menu-label hov cursor-is-poiner">
               <span class="icon">               
                    <i class="fa" v-bind:class="{'fa-folder-open': open,'fa-folder': !open}"></i>
               </span>
               <span class="action" v-bind:class="{'is-select': isActive}" > {{model.name}} </span>
               <actions-category :isFolder="isFolder" :model="model"></actions-category>
        </p>    

        <li class="product hov cursor-is-poiner" v-if="!isFolder" @dblclick="toggle">
             <span class="item-product">
                 <a v-bind:class="{'is-active': isActive}" > {{model.name}} </a>
                 <actions-category :isFolder="isFolder" :model="model"></actions-category>
             </span>
        </li>

        <ul  class="menu-list" v-show="open" v-if="isFolder">
          <item
            v-for="model in model.children"
            :model="model">
          </item>
          <li>
            <router-link :to="{name: 'createcategory', params: {id: model.id}}">
                <span class="icon">               
                    <i class="fa fa-plus is-small"></i>
                </span>                
            </router-link>
          </li>
        </ul>
     </div> 
</template>

<script>

    import Vue from 'vue'
    import ActionsCatrgory from './ActionsCategory.vue';
    Vue.component('actions-category',ActionsCatrgory);

    export default {
       name: "item",
       props: {
         model: Object
       },
       created(){
           window.busevents.$on('refreshtable',this.selectitem);
       },
       data: function () {
         return {
               open: false,
               isActive: false,
         }
       },
       computed: {
          isFolder: function () {
            return this.model.children &&
              this.model.children.length
          } 
        },
        methods: {
         selectitem: function (id){
             if (this.model.id == id)   {
                    this.isActive = true;
             }else{
                    this.isActive = false;
             }
         }, 
         toggle: function () {
           if (this.isFolder) {
             this.open = !this.open
           }
           window.busevents.$emit('getgoods',this.model.id);
         }, 
        }     
    }
</script>




