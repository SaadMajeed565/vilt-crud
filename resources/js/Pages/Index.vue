<script setup>
import { Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';

const form = useForm({});
const props = defineProps({
    posts: Object
});

const deletePost = (postId) => {
    const confirmDelete = confirm("Are you sure you want to delete this post?");
    if (confirmDelete) {
        form.delete(`/posts/${postId}`, {
            onSuccess: () => {
                form.reset('posts');
                console.log('Post deleted successfully');
                
            },
            onError: (errors) => {
                console.error('Delete Error:', errors);
                // Handle error messages if necessary
            },
        });
    }
};

</script>
<template>
    <div class="w-2/3 mx-auto">
        <div class="flex flex-row justify-between">
            <h1 class="text-3xl font-bold text-teal-600">Posts</h1>
            <Link href="posts/create" class="px-3 py-1 bg-teal-300 rounded-lg">Create</Link>
        </div>


        <div class="flex flex-row gap-5">
            <div v-for="post in props.posts" class="bg-gray-100 p-5 rounded-lg shadow-lg w-60 mt-20">
                <Link :href="`/posts/${post.id}`">
                <img :src="`/storage/${post.image}`" alt="">
                <h2 class="text-xl font-bold text-gray-800">{{ post.title }}</h2>
                </Link>

                <div class="flex flex-row justify-between">
                    <Link :href="`/posts/${post.id}/edit`">Edit</Link>
                    <button @click.prevent="deletePost(post.id)">Delete</button>
                </div>
            </div>
        </div>
    </div>
</template>