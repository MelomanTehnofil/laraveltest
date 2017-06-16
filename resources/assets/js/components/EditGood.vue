<template>
    <div class="modal is-active">
          <div class="modal-background"></div>
          <div class="modal-card">
            <header class="modal-card-head">
              <p class="modal-card-title">{{$t("EditGood.title")}}</p>
            </header>
            <section class="modal-card-body">
                <div class=content>
                    <edit-form @submitted="submit" :good="good"></edit-form>
                </div>
            </section>
          </div>
    </div> 
</template>

<script>

    import Vue from 'vue'
    import EditForm from './CRUDForm.vue';
    Vue.component('edit-form',EditForm);
    
    export default {
       created(){
            this.$http.get(this.$root.prefix_url + '/good/' + this.good_id)
                .then(response => {
                    this.good = response.data;
                })
                .catch(response => {
                    console.log('ERROR_EDIT_CATEGORY');
                });
       },
       data: function() {
            return {
                good_id: this.$route.params.id,
                good: {},
                url: this.$root.prefix_url + '/updategood/',
            }
      },
      methods:{
            submit(formData) {
                formData.set('_method', 'PUT'); 
                let url = this.url + this.good_id;

                this.$http.post(url, formData)
                    .then(response => {
                        window.busevents.$emit('editgoods',response.body);
                    }).catch(response => {
                        console.log('ERROR_UPDATE_GOOD');
                    });
            },
      },
    }
</script>
