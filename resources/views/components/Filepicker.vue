<template>
    <div :class="imageSelected">
        <label :for="props.name"><slot></slot></label>
        <div class="relative" v-if="image && image.type.includes('image')">
            <img :src="image.url" class="p-4 h-[200px] w-[200px] m-auto">
            <div class="absolute z-index-1 w-[200px] h-[200px] left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2">
                <i class="fa-regular fa-circle-xmark fa-lg text-secondary hover:text-amber-400 transition ease-in-out cursor-pointer float-right px-2 py-4" v-on:click="onFileRemove()"></i>
            </div>
        </div>
        <input type="file" class="filepicker" ref="input" v-bind="inputAttributes" v-on:change="onInputChange">
    </div>
</template>

<script setup>

    import { ref, defineProps, computed } from 'vue';

    let input = ref(null);
    let image = ref(null)

    const props = defineProps({
        accept: {
            type: String,
            default: ''
        },
        name: {
            type: String,
            default: ''
        },
        required: {
            type: Boolean,
            default: false
        }
    })

    const inputAttributes = {
        accept: props.accept,
        name: props.name,
    }

    if(props.required){
        inputAttributes['required'] = true
    }

    function onInputChange() {
        image.value = {
            url: URL.createObjectURL(input.value.files[0]),
            type: input.value.files[0].type 
        } 
        
    }

    function onFileRemove(){
        input.value.value = ''
        image.value = null
    }

    const imageSelected = computed(() => {
        return image.value 
            ? 'bg-gray-100' 
            : '';      
    });

</script>