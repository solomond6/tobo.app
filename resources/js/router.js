import Vue from 'vue';
import VueRouter from 'vue-router';
import UserShow from "./views/Users/Show";
import NewsFeed from "./views/NewsFeed";

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',

    routes: [
        {
            path: '/admin/dashboard', name: 'dashboard', component: NewsFeed,
            meta: { title: 'News Feed' }
        },
        {
            path: '/agent/dashboard', name: 'dashboard', component: NewsFeed,
            meta: { title: 'News Feed' }
        },
        {
            path: '/moderator/dashboard', name: 'dashboard', component: NewsFeed,
            meta: { title: 'News Feed' }
        },
        {
            path: '/users/:userId', name: 'user.show', component: UserShow,
            meta: {title: 'Profile'}
        },
     ]
});
