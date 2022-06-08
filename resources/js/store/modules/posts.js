const state = {
    posts: null,
    postsStatus: null,
    postMessage: '',
};

const getters = {
    posts: state => {
        return state.posts;
    },
    newsStatus: state => {
        return {
            postsStatus: state.postsStatus,
        }
    },
    postMessage: state => {
        return state.postMessage;
    }
};

const actions = {
    fetchNewsPosts({commit, state}) {
        commit('setPostsStatus', 'loading');

        axios.get('/posts')
            .then(res => {
                console.log(res.data);
                commit('setPosts', res.data);
                commit('setPostsStatus', 'success');
            })
            .catch(error => {
                commit('setPostsStatus', 'error');
            });
    },
    fetchUserPosts({commit, dispatch}, userId) {
        commit('setPostsStatus', 'loading');

        axios.get('/users/' + userId + '/posts')
            .then(res => {
                commit('setPosts', res.data);
                commit('setPostsStatus', 'success');
            })
            .catch(error => {
                commit('setPostsStatus', 'error');
            });
    },
    postMessage({commit, state}) {
        commit('setPostsStatus', 'loading');

        axios.post('/posts', { body: state.postMessage })
            .then(res => {
                commit('pushPost', res.data);
                commit('setPostsStatus', 'success');
                commit('updateMessage', '');
            })
            .catch(error => {
            });
    },
    likePost({commit, state}, data) {
        axios.post('/posts/' + data.postId + '/like')
            .then(res => {
                commit('pushLikes', { likes: res.data, postKey: data.postKey });
            })
            .catch(error => {
            });
    },
    commentPost({commit, state}, data) {
        axios.post('/posts/' + data.postId + '/comment', { body: data.body })
            .then(res => {
                commit('pushComments', { comments: res.data, postKey: data.postKey });
            })
            .catch(error => {
            });
    }
};

const mutations = {
    setPosts(state, posts) {
        
        
        state.posts = posts;
        //console.log('list'+list);
    },
    setPostsStatus(state, status) {
        state.postsStatus = status;
    },
    updateMessage(state, message) {
        state.postMessage = message;
    },
    pushPost(state, post) {
        state.posts.data.unshift(post);
    },
    pushLikes(state, data) {
        state.posts.data[data.postKey].data.attributes.likes = data.likes;
    },
    pushComments(state, data) {
        state.posts.data[data.postKey].data.attributes.comments = data.comments;
    }
};

export default {
    state, getters, actions, mutations,
}
