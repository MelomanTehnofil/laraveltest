<template>
    <form @submit.prevent="submit">

        <div class="field"
            <label class="label" for="name">
                {{$t("CRUDForm.name")}}
            </label>
            <p class="control">
                <input
                    v-model="good.name"
                    type="text"
                    class="form-control"
                    id="name"
                    v-bind:placeholder="$t('CRUDForm.name_placeholder')">
            </p>    
        </div>

        <div class="field">
            <p class="control">
                <image-input :image-src="imageSrc"></image-input>
            </p>
        </div>

        <div
            class="field"
            <label class="label" for="description">
                {{$t("CRUDForm.description")}}
            </label>
            <p class="control">
                <textarea
                    v-model="good.description"
                    class="form-control"
                    id="description"
                    cols="150"
                    rows="5"        
                    v-bind:placeholder="$t('CRUDForm.description_placeholder')">
                </textarea>
            </p>
        </div>

        <div class="field is-grouped">
          <p class="control">
                <button class="button is-primary is-small">
                    {{$t("CRUDForm.buttonSave")}}
                </button>
          </p>
          <p class="control">
            <router-link :to="{name: '/'}">
                <button class="button is-small">
                   {{$t("CRUDForm.buttonCancel")}}
                </button>                
            </router-link>
          </p>
        </div>

    </form>
</template>

<script>

    import Vue from 'vue'
    import ImageInput from './ImageInput.vue';
    Vue.component('image-input',ImageInput);

    export default {
        created() {
            window.busevents.$on('photoUpdated',this.photoUpdated);
        },
        props: {
            category_id: '',
            good: {
                type: Object,
                required: true
            },
        },
        computed: {
            imageSrc() {
                if(this.good.photo instanceof File === false) {
                    if(this.good.photo !== undefined) {
                        let photo = this.good.photo;

                        if(! photo) {
                            photo = 'default.png';
                        }

                        return '/storage/photos/' + photo;
                    }
                }
            }
        },
        methods: {
            submit() {
                let formData = new FormData();

                if(this.good.photo instanceof File) {
                    formData.set('photo', this.good.photo);
                }
                formData.append('name', this.good.name);
                formData.append('description', this.good.description);
                if (this.category_id !== undefined){
                    formData.append('category_id', this.category_id);
                }
                this.$emit('submitted',formData);
                this.closeForm();
            },
            closeForm(){
                 this.$root._router.back();
            },    
            photoUpdated(imageFile) {
                this.good.photo = imageFile;
            },
        },
    }
</script>
