<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-2 border-bottom-primary">
                <div class="card-header bg-primary text-white">
                    <div class='d-flex'>
                        <h4 class='card-title flex-grow-1'>
                            {{ post.data.attributes.title }}
                        </h4>
                    </div>
                </div>

                <div class="card-body">
                    <div class='body'>
                        <p class="text-dark">{{ post.data.attributes.body }}</p>
                        <div class="row">
                            <CoolLightBox 
                              :items="post.data.attributes.post_image.data" 
                              :index="index"
                              @close="index = null">
                            </CoolLightBox>

                            <div class="flex my-4 items-center image"
                                v-for="(image, imageIndex) in post.data.attributes.post_image.data"
                                :key="imageIndex"
                                @click="index = imageIndex"
                                :style="{ backgroundImage: 'url('+ image + ')' }">
                                <img :src="image" class="img-fluid w-100 img-thumbnail shadow-1-strong p-1" style="height:300px" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-2 mb-2 p-0">
                                <textarea v-model="commentBody" type="text" name="comment" rows="4" class="form-control mb-2 border border-3 border-primary focus:outline-none" placeholder="Write your comment"></textarea>
                                <button v-if="commentBody"
                                        class="btn btn-info focus:outline-none"
                                        @click="$store.dispatch('commentPost', { body: commentBody, postId: post.data.post_id, postKey: $vnode.key }); commentBody = ''">
                                    Post
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <button class="btn btn-primary text-sm focus:outline-none"
                                    :class="[post.data.attributes.likes.user_likes_post ? 'bg-blue-600 text-white' : '']"
                                    @click="$store.dispatch('likePost', { postId: post.data.post_id, postKey: $vnode.key })">
                                <i class="fas fa-heart"></i> {{ post.data.attributes.likes.like_count }}
                            </button>
                            </div>

                            <div class="col-md-6 text-right">
                                <button class="btn btn-default justify-center text-sm text-dark focus:outline-none"
                                    @click="comments = ! comments">
                                    <p class="m-1">{{ post.data.attributes.comments.comment_count }} Comments</p>
                                </button>
                            </div>
                        </div>
                        
                        <div v-if="comments" class="pt-2">
                            <div class="flex my-4 items-center" v-for="comment in post.data.attributes.comments.data">
                                <div class="flex-1">
                                    <div class="bg-gray-200 rounded-lg p-2 text-sm">
                                        <a class="font-bold text-blue-700" :href="'/users/' + comment.data.attributes.commented_by.data.user_id">
                                            {{ comment.data.attributes.commented_by.data.attributes.user_name }}
                                        </a>
                                        <p class="inline">
                                            {{ comment.data.attributes.body }}
                                        </p>
                                    </div>
                                    <div class="text-xs pl-2">
                                        <p>{{ comment.data.attributes.commented_at }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import CoolLightBox from 'vue-cool-lightbox'
    import 'vue-cool-lightbox/dist/vue-cool-lightbox.min.css'
    export default {
        components: {
            CoolLightBox,
        },
        name: "Post",

        props: [
            'post',
        ],

        data: () => {
            return {
                comments: false,
                commentBody: '',
                index: null
            }
        }
    }
</script>

<style scoped>

</style>
