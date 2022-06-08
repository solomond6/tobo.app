<template>
    <div class="bg-white h-12 px-4 flex items-center border-b border-gray-400 shadow-sm">
        <div class="w-1/3">
            <div class="flex">
                <router-link to="/">
                    Home
                </router-link>

                <div class="ml-2 relative">
                    

                </div>
            </div>
        </div>
        <div class="w-1/3 flex justify-center items-center h-full">
            <router-link to="/" class="px-6 border-b-2 border-blue-500 h-full flex items-center ">
                dghdg
            </router-link>
            <router-link :to="'/users/' + authUser.data.user_id" class="px-6 border-b-2 border-white h-full flex items-center ">
                <!--<img :src="authUser.data.attributes.profile_image.data.attributes.path" alt="profile image for user" class="w-8 h-8 object-cover rounded-full">-->
            </router-link>
            <router-link to="/" class="px-6 border-b-2 border-white h-full flex items-center ">
                dfgdye
            </router-link>
        </div>
        <div class="w-1/3 flex justify-end">
            ghfvjhvjj
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        name: "Nav",

        computed: {
            ...mapGetters({
                authUser: 'authUser'
            })
        }
    }
</script>

<style scoped>

</style>
