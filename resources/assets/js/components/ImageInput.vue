<template>
    <div class="row">
        <div class="col-md-12">
            <img
                class="img-thumbnail img-reponsive image-preview"
                :src="imageSrc"
                :alt="imageName"
                :title="imageName"
                :width="215"
                :height="215">
        </div>
        <div>
            <span>
                {{$t("Imageinput.label")}}
            </span>
            <input @change="preview" name="image" type="file" accept="image/*">
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            imageSrc: {
                type: String,
                default: '/storage/photos/default.png'
            },
        },
        data() {
            return {
                imageName: null,
            }
        },
        methods: {
            preview(event) {
                let input = event.target;
                let files = input.files;

                if (files && files[0]) {
                    if(files[0].type.match('image.*')) {
                        let reader = new FileReader();

                        reader.onload = (e) => {
                            this.imageSrc = e.target.result;
                            this.imageName = files[0].name;
                        };

                        reader.readAsDataURL(files[0]);

                        window.busevents.$emit('photoUpdated', files[0]);
                    }
                }
            }
        }
    }
</script>
