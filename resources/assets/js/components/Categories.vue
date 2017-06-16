<template>
    <div id="categories">
        <aside class="menu">
            <ul class="menu-list">
              <item :model="treeData">
              </item>
            </ul>
        </aside>    
    </div>
</template>

<script>

    import Vue from 'vue'
    import Items from './Item.vue';
    Vue.component('Item',Items);

    export default {
       created(){
           window.busevents.$on('updatecategory',this.updatecategory);
           window.busevents.$on('createcategory',this.createcategory);
           window.busevents.$on('deletecategory',this.deleted);
       }, 
       name: "categories",
       mounted() {
            this.getCategories(this.url);
       },
       props: ['url'],
       data: function() {
            return {
              treeData: {

              },
            }
      },
      methods:{
            updatecategory: function (category){
                 function updatec (treeObj){
                      if (treeObj.id == category.id) {
                         treeObj.name = category.name   
                      }else{
                          treeObj.children.forEach(function (child){updatec(child)});
                      }
                  }
                  updatec(this.treeData);
            },
            createcategory: function (category,parent_id){
                    var tree = this.treeData.children;
                    category['children']=[];    
                    function createelem (child,index,elements) {
                         if (child.id == parent_id) {
                              child.children.push(category);
                              Vue.set(child, 'children', child.children);
                         }else if (typeof child.children !== "undefined"){
                            child.children.forEach(function (child,index,elements) {createelem(child,index,elements)});
                         }
                    }
                    if (this.treeData.id == parent_id) {
                        this.treeData.children.push(category);
                        Vue.set(this.treeData, 'children', this.treeData.children);
                    }else{
                        tree.forEach( function (child,index,elements) {createelem(child,index,elements)} );
                    }
            },
            deletecategory: function (id){
                    if (typeof id !== 'undefined') {
                          var tree = this.treeData.children;
                          function delelem (child,index,elements) {
                             if (child.id == id) {
                                  elements.splice(index,1);
                             }else if (typeof child.children !== "undefined"){
                                child.children.forEach(function (child,index,elements) {delelem(child,index,elements)});
                             }
                          }
                          tree.forEach( function (child,index,elements) {delelem(child,index,elements)} );
                     }
            },
            deleted: function (id){
                this.$http.get(this.$root.prefix_url + '/deletecategory/' + id)
                    .then(response => {
                        this.deletecategory(id);
                        window.busevents.$emit('refreshgood');
                    })
                    .catch(response => {
                        console.log('ERROR_DELETE_CATEGORY');
                    });
            },
            getCategories(url){
                if(typeof url != "undefined"){
                    this.$http.get(url).then(response => {
                            this.treeData = response.body[1];
                        }).catch(response => {
                            console.log('ERROR_GET_CATEGORIES');
                        });
                }
            }
      }, 

    }
</script>




