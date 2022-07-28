/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./textpager');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.mixin(require('./trans'));

Vue.component('user-request', require('./components/user/UserRequest.vue').default);
Vue.component('user-conversations', require('./components/user/UserConversations.vue').default);
Vue.component('user-question-list', require('./components/user/UserQuestionList.vue').default);
Vue.component('user-new-question', require('./components/user/UserNewQuestion.vue').default);
Vue.component('user-question', require('./components/user/UserQuestion.vue').default);
Vue.component('user-lessons', require('./components/user/UserLessons.vue').default);
Vue.component('user-missing-lessons', require('./components/user/MissingLessons.vue').default);
Vue.component('user-missing-lessons-am', require('./components/user/MissingLessonsAM.vue').default);

Vue.component('request-list', require('./components/RequestList.vue').default);
Vue.component('initiation-list', require('./components/InitiationList.vue').default);
Vue.component('requests-count-badge', require('./components/RequestsCountBadge.vue').default);

Vue.component('notifications', require('./components/Notifications.vue').default);
Vue.component('support-button', require('./components/SupportButton.vue').default);
Vue.component('support-menu-item', require('./components/SupportMenuItem.vue').default);

Vue.component('conversations', require('./components/conversations/Conversations.vue').default);
Vue.component('question-list', require('./components/conversations/QuestionList.vue').default);
//Vue.component('user-new-question', require('./components/UserNewQuestion.vue').default);
Vue.component('question', require('./components/conversations/Question.vue').default);
Vue.component('dropdown', require('./components/Dropdown.vue').default);
Vue.component('object-dropdown', require('./components/ObjectDropdown.vue').default);
Vue.component('questions-unread-badge', require('./components/conversations/UnreadBadge.vue').default);

Vue.component('geo', require('./components/geo/Geo.vue').default);
Vue.component('sectors', require('./components/geo/Sectors.vue').default);
Vue.component('regions', require('./components/geo/Regions.vue').default);
Vue.component('dioceses', require('./components/geo/Dioceses.vue').default);
Vue.component('districts', require('./components/geo/Districts.vue').default);
Vue.component('district-areas', require('./components/geo/DistrictAreas.vue').default);
Vue.component('units', require('./components/geo/Units.vue').default);
Vue.component('unit-users', require('./components/geo/UnitUsers.vue').default);

Vue.component('user-list', require('./components/users/UserList').default);
Vue.component('user-edit', require('./components/users/UserEdit').default);
Vue.component('user-profile', require('./components/users/UserProfile').default);

Vue.component('statistics', require('./components/statistics/Main').default);
Vue.component('statistics-unit', require('./components/statistics/Unit').default);
Vue.component('statistics-lessons', require('./components/statistics/Lessons').default);
Vue.component('statistics-initiations', require('./components/statistics/Initiations').default);
Vue.component('events-report', require('./components/practices/EventsReport').default);
Vue.component('unit-diagram', require('./components/practices/UnitDiagram').default);

Vue.component('user-info', require('./components/UserInfo').default);
Vue.component('avatar', require('./components/Avatar').default);
Vue.component('modal-window', require('./components/ModalWindow').default);
Vue.component('fs-modal-window', require('./components/FullscreenModalWindow').default);
Vue.component('diary', require('./components/Diary').default);
Vue.component('user-diary-info', require('./components/user/UserDiaryInfo').default);
Vue.component('diary-edit', require('./components/DiaryEdit').default);
Vue.component('pagination', require('./components/Pagination').default);
Vue.component('social-authorize', require('./components/tools/SocialAuthorize').default);
Vue.component('requested-image', require('./components/sadvipra/RequestedImage').default);

Vue.component('easter-egg', require('./components/EasterEgg').default);

Vue.component('materials', require('./components/materials/Materials').default);
Vue.component('materials-theme', require('./components/materials/MaterialsTheme').default);
Vue.component('materials-sub-theme', require('./components/materials/MaterialsSubTheme').default);
Vue.component('materials-topic', require('./components/materials/MaterialsTopic').default);

Vue.component('spiritual-names', require('./components/handbooks/SpiritualNames').default);
Vue.component('missing-lessons', require('./components/handbooks/MissingLessons').default);
Vue.component('fastings-list', require('./components/handbooks/FastingsList').default);
Vue.component('fastings-list-am', require('./components/handbooks/FastingsListAM').default);
Vue.component('nearest-fasting', require('./components/handbooks/NearestFasting').default);
Vue.component('puzzle-editor', require('./components/handbooks/RewardEditor').default);
Vue.component('samgiits-editor', require('./components/handbooks/SamgiitsEditor').default);
Vue.component('lessons-requirements', require('./components/handbooks/LessonsRequirements').default);
Vue.component('posts-lang', require('./components/handbooks/PostsLang').default);
Vue.component('posts-categories', require('./components/handbooks/PostsCategories').default);
Vue.component('media-lib', require('./components/handbooks/MediaLibrary').default);
Vue.component('programs', require('./components/handbooks/Programs').default);
Vue.component('statuses', require('./components/handbooks/Statuses').default);
Vue.component('roles', require('./components/handbooks/Roles').default);
Vue.component('practices', require('./components/practices/Practices').default);
Vue.component('dharmacakra', require('./components/practices/Dharmacakra').default);
Vue.component('prabhat-samgiits', require('./components/practices/PrabhatSamgiits').default);
Vue.component('upload-file', require('./components/UploadFile').default);
Vue.component('add-web-file', require('./components/tools/AddWebFile').default);

Vue.component('diary-record', require('./components/diary/Record').default);
Vue.component('diary-am', require('./components/diary/AM').default);
Vue.component('diary-edit-stage', require('./components/diary/DiaryEditStage').default);
Vue.component('custom-numpad', require('./components/CustomNumpadInput').default);

Vue.component('user-profile-am', require('./components/users/UserProfileAM').default);

Vue.component('telegram-connect', require('./components/TelegramConnect').default);
Vue.component('mobile-connect', require('./components/MobileConnect').default);
Vue.component('install-pwa', require('./components/InstallPWA').default);
Vue.component('lang-selector', require('./components/LangSelector').default);
Vue.component('sub-lang-selector', require('./components/SubLangSelector').default);
Vue.component('lang-page', require('./components/LangPage').default);
Vue.component('settings-panel', require('./components/tools/SettingsPanel').default);
Vue.component('text-pager', require('./components/tools/TextPager').default);

Vue.component('posts', require('./components/blog/Posts').default);
Vue.component('category-listing', require('./components/blog/CategoryListing').default);
Vue.component('post', require('./components/blog/Post').default);
Vue.component('education', require('./components/blog/Education').default);
Vue.component('news', require('./components/blog/News').default);
Vue.component('svadhyaya', require('./components/blog/Svadhyaya').default);
Vue.component('daily-quote', require('./components/blog/DailyQuote').default);

Vue.component('unit', require('./components/user/Unit').default);
Vue.component('unit-programs', require('./components/user/UnitPrograms').default);

Vue.component('html-editor', require('./components/HtmlEditor.vue').default);
Vue.component('audio-player', require('./components/AudioPlayer').default);
Vue.component('declension', require('./components/Declension').default);
Vue.component('page-title', require('./components/PageTitle').default);
Vue.component('scroll-to-top', require('./components/tools/ScrollToTop').default);
Vue.component('unit-user-settings', require('./components/tools/UnitUserSettings').default);
Vue.component('statuses-filter', require('./components/tools/StatusesFilter').default);
Vue.component('info', require('./components/tools/Info').default);
Vue.component('user-name', require('./components/tools/UserName').default);
Vue.component('member-info', require('./components/tools/MemberInfo').default);
Vue.component('user-tools', require('./components/tools/UserTools').default);
Vue.component('action-dropdown', require('./components/tools/ActionDropdown').default);
Vue.component('lang-setting', require('./components/tools/LangSetting').default);
Vue.component('roles-cheat', require('./components/tools/RolesCheat').default);
Vue.component('confirm-pop-up', require('./components/tools/ConfirmPopUp').default);
Vue.component('confirm-pop-up-shell', require('./components/tools/ConfirmPopUpShell').default);
Vue.component('app-header-tools', require('./components/tools/AppHeaderTools').default);

Vue.component('get-lesson', require('./components/sadvipra/GetLesson').default);
Vue.component('call-requests', require('./components/sadvipra/CallRequests').default);

Vue.component('med-for-eve', require('./components/sadvipra/MedForEve').default);

import Notifications from 'vue-notification'
Vue.use(Notifications, {
    'componentName': 'alerts'
});

import Toasted from 'vue-toasted';
Vue.use(Toasted);

import VueCookies from 'vue-cookies';
Vue.use(VueCookies);
$cookies.config('1d');

var VueTouch = require('vue-touch');
Vue.use(VueTouch, {name: 'v-touch'});

let vh = window.innerHeight * 0.01;
document.documentElement.style.setProperty('--vh', `${vh}px`);
window.addEventListener('resize', () => {
    let vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty('--vh', `${vh}px`);
});

import VueRouter from 'vue-router';
Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history'
});

const app = new Vue({
    el: '#app',

    data: {
        showSupport: false,
        diaryEdit: false,
        loading: false,

        member_info_user_id: null,

        permissions: [],
        roles: [],
        sadvipra: false,
        user_info: null,
    },
    router,

    computed: {
        am() {
            return $('html').attr('data-am') === "1";
        },

        registered() {
            return $('html').attr('data-registered') === "1";
        },

        lang() {
            return $('html').attr('lang');
        },

        platform() {
            return this.am ? 'am' : (this.sadvipra ? 'sadvipra' : 'app');
        }
    },

    mounted() {
        axios.get('/user-info').then( response => {
            this.permissions = response.data.permissions;
            this.roles = response.data.roles;
            this.sadvipra = response.data.sadvipra;
            this.user_info = {
                name: response.data.name,
                meditation_hours: response.data.meditation_hours,
                current_lesson: response.data.current_lesson,
                spiritual_name: response.data.spiritual_name,
                first_name: response.data.first_name,
                last_name: response.data.last_name,
                phone: response.data.phone,
                telegram: response.data.telegram,
                call_requests: response.data.requests.calls
            }
        })
    }
});
