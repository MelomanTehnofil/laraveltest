<template>
    <div id="select_good">
        <input type="checkbox" @change="checked" v-model="checkdata">
        {{data.id}}
    </div>
</template>

<script>
    export default {
        props: ['data'],
        data: function(){
            return {
               checkdata: false,
            }
        },
        methods: {
            checked: function(){
                if (this.checkdata == true){
                    window.busevents.$emit('checkedrowadd',this.data.id);
                }else{
                    window.busevents.$emit('checkedrowtrash',this.data.id);
                }
            }
        }
    }
</script>


