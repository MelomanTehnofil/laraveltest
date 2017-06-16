<template>
    <div class="showactions">               
        <div class="action" v-bind:class="{hide: isFolder}">
            <router-link :to="{name: 'createcategory', params: {id: model.id}}">
                <i class="fa fa-plus is-small"></i>
            </router-link>
        </div>
        <div class="action">
            <router-link :to="{name: 'updatecategory', params: {id: model.id}}">
                <i class="fa fa-pencil is-small"></i>
            </router-link>
        </div>
        <div class="action">
            <a @click="deleted(model.id)">               
                <i class="fa fa-minus is-small"></i>
            </a>
        </div>
    </div> 
</template>

<script>
    export default {
        props: ['model','isFolder'],
        methods: {
            deleted: function(id){
                window.busevents.$emit('deletecategory',id);
            },
        }
    }
</script>


