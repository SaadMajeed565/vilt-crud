<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    post: Object // Expecting an object representing the post to be edited
});

// Initialize form with post data
const form = useForm({
    id: props.post.id, // Include the post ID
    title: props.post.title,
    content: props.post.content,
    image: null // Initialize image to null
});

// Determine the current image URL
const currentImage = props.post.image ? `/storage/${props.post.image}` : null;

// Function to handle image upload
const updateImage = (event: Event) => {
    const input = event.target as HTMLInputElement;
    const file = input.files?.[0];
    if (file) {
        form.image = file; // Set the selected file to the form image
    }
};

// Function to submit the form
const submit = () => {
    // Sending a PATCH request to update the post
    form.patch(`/posts/${props.post.id}`, {
        onSuccess: () => {
            form.reset(); // Reset the form on success
        },
        onError: (errors) => {
            console.error('Errors:', errors); // Log any errors
        },
    });
};
</script>

<template>
    <div class="w-1/3 mx-auto">
        <h1 class="text-2xl font-bold">Edit Post</h1>
        <form @submit.prevent="submit">
            <div class="my-2">
                <label for="title" class="block">Title</label>
                <input type="text" id="title" placeholder="Title" v-model="form.title" class="w-full border rounded-md p-2" />
                <p v-if="form.errors.title" class="text-red-500 text-sm">{{ form.errors.title[0] }}</p>
            </div>
            <div class="my-2">
                <label for="image" class="block">Image</label>
                <div v-if="currentImage">
                    <img :src="currentImage" alt="Current Post Image" class="max-w-xs max-h-40 mb-2" />
                </div>
                <input type="file" @change="updateImage" id="image" class="border rounded-md p-2" />
            </div>
            <div class="my-4">
                <label for="content" class="block">Content</label>
                <textarea id="content" placeholder="Start typing here..." v-model="form.content" class="w-full border rounded-md p-2"></textarea>
                <p v-if="form.errors.content" class="text-red-500 text-sm">{{ form.errors.content[0] }}</p>
            </div>
            <button 
                class="bg-blue-500 px-3 py-1 text-white rounded-lg" 
                type="submit"
                :disabled="form.processing" 
            >
                Update
            </button>
        </form>
    </div>
</template>

<style scoped>
/* Add any component-specific styles here */
</style>
