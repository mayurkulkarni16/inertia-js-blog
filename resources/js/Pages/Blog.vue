<template>
    <breeze-authenticated-layout>
        <form @submit.prevent="form.get('/blog')">
            <div class="relative flex content-center justify-center w-full max-w-md px-2 py-2 mx-auto my-6 rounded-md">
                <input class="h-10 px-5 pr-16 text-sm bg-white border-2 border-gray-300 rounded-lg focus:outline-none"
                type="search" v-model="form.search" placeholder="Search">
                <button type="submit" class="absolute top-0 right-0 mt-5 mr-28">
                    <svg class="w-4 h-4 text-gray-600 fill-current" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px"
                        viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve"
                        width="512px" height="512px">
                        <path
                        d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
                    </svg>
                </button>
            </div>
        </form>
        <div v-for="(post, i) in displayPosts" :key="i" class="w-full max-w-md px-6 py-4 mx-auto my-6 bg-white rounded-md shadow-md">
            <div class="sm:flex sm:justify-between">
                <div class="flex items-center">
                    <div>
                        <h3 class="text-xl font-medium text-gray-800"><inertia-link :href="route('viewPost', {'id':post.id})">{{post.title}}</inertia-link></h3>
                        <span class="text-sm text-gray-800 font-extralight text-md"><span v-if="user"> By - {{post.user.name}}</span></span>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-between mt-4">
                <div>
                    <h4 class="text-xl text-gray-600">Content</h4>
                    <span class="mt-2 font-medium text-gray-800 text-md">{{post.body}}</span>
                </div>
            </div>
            <div class="mt-3">
                <input required :id="post.id" :disabled="user==null" class="w-full h-full px-2 transition-all border-gray-300 rounded-sm border-blue" type="text" name="comment">
            </div>
            <div class="py-2 mt-2 sm:mt-0">
                <button @click="submit(post.id, i)" type="button" :disabled="user==null" class="flex items-center px-2 py-1 text-white bg-blue-600 rounded hover:bg-blue-500 focus:outline-none focus:shadow-outline">
                    <svg class="w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="ml-1 text-sm">Comment</span>
                </button>
            </div>
            <hr>
            <div class="flex items-center justify-between mt-4">
                <div>
                    <h4 class="text-xl text-gray-600">Comments</h4>
                </div>
            </div>
            <div v-for="(comment, l) in post.comments" :key="l" class="flex items-center justify-between mt-4">
                <div>
                    <h3 class="text-sm text-gray-800 font-small">{{comment.body}}</h3>
                    <span class="text-xs text-gray-800 font-extralight text-md"> By - {{user.name}}</span>
                </div>
            </div>
            <br>
            <span v-if="post.comments.length == 3" class="text-xs text-blue-800 font-extralight text-md"><inertia-link :href="route('viewPost', {'id':post.id})">more..</inertia-link></span>
        </div>
        <div class="flex content-center justify-center w-full max-w-md px-2 py-2 mx-auto my-6 rounded-md">
            <nav class="relative z-0 inline-flex items-center justify-center -space-x-px rounded-md shadow-sm" aria-label="Pagination">

                <inertia-link v-for="(link, i) in posts.links" :key="i"
                    :disabled="link.url == null" v-html="link.label"
                    :href="link.url ? link.url : '#'" aria-current="page"
                    class="relative z-10 inline-flex items-center px-4 py-2 text-sm font-medium text-indigo-600 border border-indigo-500 bg-indigo-50">
                </inertia-link>
            </nav>
        </div>
    </breeze-authenticated-layout>
</template>

<script>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated'
    import { useForm } from '@inertiajs/inertia-vue3'
export default{
    name: 'Blog',
    props: {
        'posts': Array,
        'user': Object
    },
    data() {
        return{
            comment: ""
        }
    },
    components: {
        BreezeAuthenticatedLayout,
    },
    methods: {
        // getResults(page) {
        //     if (typeof page === 'undefined') {
        //         page = 1;
        //     }

        //     axios.get('/blog?page=' + page)
        //         .then(response => {
        //             console.log(response);
        //             return response.json();
        //         }).then(data => {
        //             console.log(data);
        //             this.laravelData = data;
        //         });
        // },
        submit: async function(id, i) {
            let comment = document.getElementById(id).value;
            if (!comment || comment.length  == 0)
            {
                alert("Comment can not be null")
                return;
            }
            let form = new FormData();
            form.append('id', id);
            form.append('comment', document.getElementById(id).value);
            await axios.post('/comment', form).then((resp) => {
                    this.displayPosts[i].comments.unshift(resp.data.comment)
                }).catch(error => {
                    console.log();
                });
            if (this.displayPosts[i].comments.length >= 3) this.displayPosts[i].comments.pop()
        }
    },
    created() {
        console.log(this.posts);
    },
    computed: {
        displayPosts() {
            return _.pickBy(this.posts.data, function(f) {
                return f.hide == 0;
            });
        }
    },
    setup() {
        const form = useForm({
            search: null
        })

        return { form }
    }
}
</script>
