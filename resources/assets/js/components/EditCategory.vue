<template>
    <div class="modal is-active">
          <div class="modal-background"></div>
          <div class="modal-card">
            <header class="modal-card-head">
              <p class="modal-card-title">{{$t("EditCategory.title")}}</p>
            </header>
            <section class="modal-card-body">
               <categories-crud-form @submitted="submit" :category="category"></categories-crud-form>
            </section>
          </div>
    </div> 
</template>

<script>

    import Vue from 'vue'
    import CategoryEditForm from './CategoriesCRUDForm.vue';
    Vue.component('categories-crud-form',CategoryEditForm);
    
    export default {
        created() {
            this.$http.get(this.$root.prefix_url + '/category/' + this.category_id)
                .then(response => {
                    this.category = response.data;
                })
                .catch(response => {
                    console.log('ERROR_EDIT_CATEGORY');
                });
        },
       data: function() {
            return {
                category_id: this.$route.params.id,
                category: {
                       id: '',
                       name: '', 
                },
                url: this.$root.prefix_url + '/updatecategory/',
            }
      },
      methods:{
            submit(formData) {
                formData.set('_method', 'PUT'); 
                let url = this.url + this.category_id;

                this.$http.post(url, formData)
                    .then(response => {
                        window.busevents.$emit('updatecategory',this.category);
                    }).catch(response => {
                        console.log('ERROR_UPDATE_CATEGORY');
                    });
            },
      },
    }
</script>
