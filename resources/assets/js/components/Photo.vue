<template>
    <img
        :src="photo"
        :alt="this.data.name"
        :title="this.data.name"
        :width="115"
        :height="115">
</template>

<script>
    export default {
        props: ['data'],
        computed: {
            photo() {
                if(! this.data.photo) {
                    this.data.photo = 'default.png';
                }

                return '/storage/photos/' + this.data.photo;
            },
        }
    }
</script>
