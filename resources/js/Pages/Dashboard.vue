<template>
    <breeze-authenticated-layout>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="w-full py-8 md:px-32">
                            <div class="overflow-hidden border-b border-gray-200 rounded shadow">
                                <table class="min-w-full bg-white table-auto">
                                    <thead class="text-white bg-gray-800">
                                        <tr>
                                            <th class="w-1/3 px-4 py-3 text-sm font-semibold text-left uppercase">Title</th>
                                            <th class="px-4 py-3 text-sm font-semibold text-left uppercase">Body</th>
                                            <th class="px-4 py-3 text-sm font-semibold text-left uppercase">Edit</th>
                                            <th class="px-4 py-3 text-sm font-semibold text-left uppercase">Delete</th>
                                            <th class="px-4 py-3 text-sm font-semibold text-left uppercase">Activate / Deactivate</th>
                                            <th class="px-4 py-3 text-sm font-semibold text-left uppercase">Comments</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-700">
                                        <tr v-for="(post, i) in posts.data" :key="i">
                                            <td class="w-1/3 px-4 py-3 text-left">{{post.title}}</td>
                                            <td class="px-4 py-3 text-left">{{post.body}}</td>
                                            <td class="px-4 py-3 text-left"><inertia-link class="hover:text-blue-500" :href="route('getPostPage', {'id' : post.id})">Edit</inertia-link></td>
                                            <td class="px-4 py-3 text-left"><inertia-link class="hover:text-blue-500" :href="route('deletePost', {'id' : post.id})">Delete</inertia-link></td>
                                            <td class="px-4 py-3 text-center"><inertia-link class="hover:text-blue-500" :href="route('hidePost', {'id' : post.id})"><input type="checkbox" value="true" :checked="post.hide"/></inertia-link></td>
                                            <td class="px-4 py-3 text-left"><inertia-link class="hover:text-blue-500" :href="route('postComments', {'id' : post.id})">Comments</inertia-link></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="flex content-center justify-center w-full max-w-md px-2 py-2 mx-auto my-6 rounded-md">
                                    <nav class="relative z-0 inline-flex items-center justify-center -space-x-px rounded-md shadow-sm" aria-label="Pagination">

                                        <inertia-link v-for="(link, i) in posts.links" :key="i"
                                            :disabled="link.url == null" v-html="link.label"
                                            :href="link.url ? link.url : '#'" aria-current="page"
                                            class="relative z-10 inline-flex items-center px-4 py-2 text-sm font-medium text-indigo-600 border border-indigo-500 bg-indigo-50">
                                        </inertia-link>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </breeze-authenticated-layout>
</template>

<script>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated'
    import PostComment from "./PostComments.vue";

    export default {
        components: {
            BreezeAuthenticatedLayout,
            PostComment
        },
        props: {
            'posts': Array
        },
        data() {
            return{
            }
        },
        methods: {
        },
        created() {
            console.log(this.posts);
            // axios.get('/getMyPosts').then(resp => {
            //     this.posts = resp.data.data;
            // });
        }
    }
</script>
