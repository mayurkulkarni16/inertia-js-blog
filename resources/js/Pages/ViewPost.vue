<template>
    <breeze-authenticated-layout>
        <div class="w-full max-w-md px-6 py-4 mx-auto my-6 bg-white rounded-md shadow-md">
            <div class="sm:flex sm:justify-between">
                <div class="flex items-center">
                    <div>
                        <h3 class="text-xl font-medium text-gray-800">{{post.title}}</h3>
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
                <input required :id="post.id" v-model="comment" :disabled="user==null" class="w-full h-full px-2 transition-all border-gray-300 rounded-sm border-blue" type="text" name="comment" id="">
            </div>
            <div class="py-2 mt-2 sm:mt-0">
                <button @click="submit(post.id, i)" :disabled="user==null" class="flex items-center px-2 py-1 text-white bg-blue-600 rounded hover:bg-blue-500 focus:outline-none focus:shadow-outline">
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
            <div v-for="(comment, l) in post.all_comments" :key="l" class="flex items-center justify-between mt-4">
                <div>
                    <h3 class="text-sm text-gray-800 font-small">{{comment.body}}</h3>
                    <span class="text-xs text-gray-800 font-extralight text-md"> By - {{user.name}}</span>
                </div>
            </div>
        </div>
    </breeze-authenticated-layout>
</template>
<script>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated'
export default {
    components: {
        BreezeAuthenticatedLayout
    },
    props: {
        'post': Object,
        'user': Object
    },
    methods: {
        submit: async function(id, i) {
            if (document.getElementById(id).value.length  == 0){
                alert("Comment can not be null")
                return;
            }
            let form = new FormData();
            form.append('id', id);
            form.append('comment', document.getElementById(id).value);
            await axios.post('/comment', form).then((resp) => {
                    this.post.all_comments.unshift(resp.data.comment)
                }).catch(error => {
                    console.log();
                });
        }
    }
}
</script>
