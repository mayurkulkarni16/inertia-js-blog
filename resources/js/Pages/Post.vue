<template>
    <breeze-authenticated-layout>
        <!-- component -->
        <div class="w-full max-w-md px-6 py-4 mx-auto my-6 bg-white rounded-md shadow-md">
            <div v-if="$page.props.flash.success" class="flex items-center justify-center px-2 py-1 m-1 font-medium text-green-100 bg-white bg-green-700 border border-green-700 rounded-md ">
                <div class="flex-initial max-w-full text-xl font-normal">
                    <div class="py-2">
                        <div class="text-sm font-base">{{$page.props.flash.success}}</div>
                    </div>
                </div>
            </div>
            <div class="flex justify-center">
                <div class="flex items-center">
                    <div class="ml-2">
                        <h3 class="text-lg font-medium text-center text-gray-800" align="center">Create Post</h3>
                    </div>
                </div>
            </div>
            <form @submit.prevent="form.post('/postComment')">
                <div class="items-center justify-between mt-4">
                    <input type="hidden" name="id" id="">
                    <div>
                        <h4 class="text-sm text-gray-600">Title</h4>
                        <div class="pt-0 mb-3">
                            <input required type="text" v-model="form.title" placeholder="Placeholder" class="relative w-full px-3 py-3 text-sm bg-white border-0 rounded shadow outline-none placeholder-blueGray-300 text-blueGray-600 focus:outline-none focus:ring"/>
                        </div>
                        <div v-if="form.errors">{{ form.errors.title }}</div>
                        <div v-if="form.flash">{{ form.flash.success }}</div>
                    </div>
                    <div>
                        <h4 class="text-sm text-gray-600">Body</h4>
                        <div class="pt-0 mb-3">
                            <input required type="text" v-model="form.body" placeholder="Placeholder" class="relative w-full px-3 py-3 text-sm bg-white border-0 rounded shadow outline-none placeholder-blueGray-300 text-blueGray-600 focus:outline-none focus:ring"/>
                        </div>
                        <div v-if="form.errors">{{ form.errors.body }}</div>
                    </div>
                </div>
                <div class="mt-2 sm:mt-0">
                    <button class="flex items-center px-2 py-1 text-white bg-blue-600 rounded hover:bg-blue-500 focus:outline-none focus:shadow-outline">
                        <svg class="w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="ml-1 text-sm">Save</span>
                    </button>
                </div>
            </form>
        </div>
    </breeze-authenticated-layout>
</template>

<script>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated'
    import { useForm } from '@inertiajs/inertia-vue3'
import axios from 'axios'
export default {
    components: {
        BreezeAuthenticatedLayout
    },
    props: {
        'post': Object
    },
    data() {
        return{
        }
    },
    created() {
        if (this.post != null){
            this.form.id = this.post.id;
            this.form.title = this.post.title;
            this.form.body = this.post.body;
        }
    },
    setup() {
        const form = useForm({
            id: null,
            title: "",
            body: "",
        })

        return { form }
    }
}
</script>
