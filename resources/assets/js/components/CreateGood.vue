<template>
    <div class="modal is-active">
          <div class="modal-background"></div>
          <div class="modal-card">
            <header class="modal-card-head">
              <p class="modal-card-title">{{$t("CreateGood.newGood")}}</p>
            </header>
            <section class="modal-card-body">
                <crud-form @submitted="submit" :category_id="category_id" :good="good"></crud-form>
            </section>
          </div>
    </div> 
</template>

<script>

    import Vue from 'vue'
    import CreateForm from './CRUDForm.vue';
    Vue.component('crud-form',CreateForm);
    
    export default {
       data: function() {
            return {
                category_id: this.$route.params.id,
                good: {
                    name: '',
                    photo: '',
                    description: '',
                },
                url: this.$root.prefix_url + '/creategood',
            }
      },
      methods:{
            submit(formData) {
                this.$http.post(this.url, formData)
                    .then(response => {
                        window.busevents.$emit('creategoods',response.body);
                    }).catch(response => {
                        console.log('ERROR_CREATE_GOOD');
                    });
            },
      },
    }
</script>
