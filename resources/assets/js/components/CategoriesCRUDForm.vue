<template>
    <form @submit.prevent="submit">

        <div class="field">
            <label class="label" for="name">
                {{$t("CatregoriesCRUDForm.name")}}
            </label>
            <p class="control">
                <input
                    v-model="category.name"
                    type="text"
                    id="name"
                    v-bind:placeholder="$t('CatregoriesCRUDForm.name_placeholder')">
             </p>
        </div>    

        <div class="field is-grouped">
          <p class="control">
                <button class="button is-primary is-small">
                    {{$t("CatregoriesCRUDForm.buttonSave")}}
                </button>
          </p>
          <p class="control">
            <router-link :to="{name: '/'}">
                <button class="button is-small">
                   {{$t("CatregoriesCRUDForm.buttonCancel")}}
                </button>                
            </router-link>
          </p>
        </div>

    </form>
</template>

<script>

    export default {
        props: {
            category: {
                type: Object,
                required: true
            },
        },
        methods: {
            submit() {
                let formData = new FormData();
                formData.append('id', this.category.id);
                formData.append('name', this.category.name);
                this.$emit('submitted',formData);
                this.closeForm();
            },
            closeForm(){
                 this.$root._router.back();                
            }    
        },
    }
</script>
