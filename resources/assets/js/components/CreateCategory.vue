<template>
    <div class="modal is-active">
          <div class="modal-background"></div>
          <div class="modal-card">
            <header class="modal-card-head">
              <p class="modal-card-title">{{$t("CreateCategory.newCategory")}}</p>
            </header>
            <section class="modal-card-body">
               <categories-crud-form @submitted="submit" :category="category"></categories-crud-form>
            </section>
          </div>
    </div> 
</template>

<script>

    import Vue from 'vue'
    import CategoriesCreateForm from './CategoriesCRUDForm.vue';
    Vue.component('categories-crud-form',CategoriesCreateForm);
    
    export default {
       data: function() {
            return {
                category: {
                       id: '',
                       name: '', 
                },
                category_id: this.$route.params.id,
                url: this.$root.prefix_url + '/createcategory/',
            }
      },
      methods:{
            submit(formData) {
                formData.set('_method', 'PUT'); 
                let url = this.url + this.category_id;

                this.$http.post(url, formData)
                    .then(response => {
                        window.busevents.$emit('createcategory',response.body,this.category_id);
                    }).catch(response => {
                        console.log('ERROR_CREATE_CATEGORY');
                    });
            },
      },
    }
</script>
