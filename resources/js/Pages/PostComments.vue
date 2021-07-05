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
                                            <th class="w-2/3 px-4 py-3 text-sm font-semibold text-left uppercase">Comment</th>
                                            <th class="px-4 py-3 text-sm font-semibold text-left uppercase">Activate / Deactivate</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-grey-700">
                                        <tr v-for="(comment, c) in comments" :key="c">
                                            <td class="w-2/3 px-4 py-3 text-left">{{comment.body}}</td>
                                            <td class="px-4 py-3 text-left">
                                                <!-- Toggle A -->
                                                <inertia-link :href="route('hideComment', {'id':comment.id})">
                                                    <input type="checkbox" value="true" :checked="comment.hide"/>
                                                </inertia-link>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </breeze-authenticated-layout>
</template>

<style>
</style>

<script>

    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated'
export default {
    props: {'comments': Array},
    components: {
        BreezeAuthenticatedLayout
    }
}
</script>
