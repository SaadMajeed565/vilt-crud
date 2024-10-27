<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

const updateImage = (event: any) => {
    form.image = event.target.files[0]; // Capture the file
};

const form = useForm({
    title: '',
    content: '',
    image: ''
});
// Function to handle form submission
const submit = () => {

    // Sending a POST request
    form.post('/posts', {
        onSuccess: (file) => {
            // Reset the form if needed
            form.reset();
        },
        onError: (errors) => {
            console.error('Errors:', errors);
            // Handle error messages if necessary
        },
    });
};

</script>


<template>
    <div class="w-1/3 mx-auto">
        <h1 class="text-2xl font-bold">Create Post</h1>
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
                Create
            </button>
        </form>
    </div>
</template>