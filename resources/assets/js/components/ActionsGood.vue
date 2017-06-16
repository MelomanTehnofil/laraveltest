<template>
    <div id="actions_good">
        <p class="field">
            <div class="action">
                <router-link :to="{name: 'updategood',params: {id: this.data.id}}" class="button is-small">
                        <span class="icon is-small">
                             <i class="fa fa-pencil"></i>
                        </span>
                        <span>{{$t("ActionsGood.buttonUpdate")}}</span>
                </router-link>
            </div>
            <div class="action">
                    <a class="button is-small" @click="this.deleteIsCategory">
                        <span class="icon is-small">
                             <i class="fa fa-times"></i>
                        </span>
                        <span>{{$t("ActionsGood.buttonRemove")}}</span>
                    </a>
            </div>
            <div class="action">
                    <a class="button is-small" @click="this.delete">
                        <span class="icon is-small">
                             <i class="fa fa-minus"></i>
                        </span>
                        <span>{{$t("ActionsGood.buttonDelete")}}</span>
                    </a>
            </div>
        </p>
    </div>
</template>

<script>
    export default {
        props: ['data'],
        methods: {
            deleteIsCategory(){
                this.$http.get(this.$root.prefix_url + '/delgoodiscat/' + this.data.id + '/ '+ this.data.category_id)
                    .then(response => {
                        window.busevents.$emit('deletegood',response.body);
                    })
                    .catch(response => {
                        console.log('ERROR_DELETE_IS_CATEGORY_GOOD');
                    });
            },
            delete() {
                this.$http.get(this.$root.prefix_url + '/deletegood/' + this.data.id)
                    .then(response => {
                        window.busevents.$emit('deletegood',response.body);
                    })
                    .catch(response => {
                        console.log('ERROR_DELETE_GOOD');
                    });
            },
        },
    }
</script>


