import  Vue from 'vue';
import Vuex from 'vuex';
import CoolLightBox from 'vue-cool-lightbox'
import 'vue-cool-lightbox/dist/vue-cool-lightbox.min.css'
import User from './modules/user';
import Title from './modules/title';
import Profile from './modules/profile';
import Posts from './modules/posts';

Vue.use(Vuex);
Vue.use(CoolLightBox);

export default new Vuex.Store({
    modules: {
        User,
        Title,
        Profile,
        Posts,

    }
});
