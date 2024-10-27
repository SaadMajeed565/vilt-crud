<script setup>
const props = defineProps({
    post: Object
});

</script>
<template>
    <div class="w-2/3 mx-auto">
        <h2 class="text-5xl font-bold">{{ props.post.title }}</h2>
        <img :src="`/storage/${props.post.image}`" alt="">
        <p class="text-lg italic">{{ props.post.content }}</p>
    </div>
</template>