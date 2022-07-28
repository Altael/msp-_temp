<template>
    <div class="appHeaderTools" v-if="$root.user_info">
        <div class="appTools-search">
            <input type="text" class="appSearch-input" :placeholder="__('Search')">
            <svg class="appSearch-btn" xmlns="http://www.w3.org/2000/svg" width="21.089" height="21.089" viewBox="0 0 21.089 21.089">
                <g id="Эллипс_53" data-name="Эллипс 53" fill="#f9f9f9" stroke="#707070" stroke-width="2">
                    <circle cx="9" cy="9" r="9" stroke="none"/>
                    <circle cx="9" cy="9" r="8" fill="none"/>
                </g>
                <line id="Линия_25" data-name="Линия 25" x2="4.497" y2="4.497" transform="translate(15.177 15.177)" fill="none" stroke="#707070" stroke-linecap="round" stroke-width="2"/>
            </svg>
        </div>
        <div class="appTools-lesson" v-if="!$root.user_info.current_lesson && !$root.user_info.call_requests.includes('adequate-1')">
            <a href="/call-request"><div class="appTools-lessonBtn">{{ __('Leave call request') }}</div></a>
        </div>
<!--        <div class="appTools-meeting" v-if="$root.user_info.call_requests.includes('adequate-1') && adequate1">
            <div class="appTools-meetingTxt">{{ __('Собеседование') }}</div><div class="appTools-meetingTime">{{ adequate1 }}</div>
        </div>-->
        <div class="appTools-notice">
            <div class="appTools-noticeBtn">
                <svg class="appTools-noticeBtnIcon" xmlns="http://www.w3.org/2000/svg" width="24.006" height="30.288" viewBox="0 0 24.006 30.288">
                    <g id="bell" transform="translate(-53.014 0)">
                        <path id="Контур_179" data-name="Контур 179" d="M184.9,465.044a4.575,4.575,0,0,0,8.376,0Z" transform="translate(-124.075 -437.488)" fill="#a8aaab"/>
                        <path id="Контур_180" data-name="Контур 180" d="M199.791,2.894a10.291,10.291,0,0,1,3.514.616V3.374A3.378,3.378,0,0,0,199.931,0h-.28a3.378,3.378,0,0,0-3.374,3.374v.134A10.312,10.312,0,0,1,199.791,2.894Z" transform="translate(-134.774)" fill="#a8aaab"/>
                        <path id="Контур_181" data-name="Контур 181" d="M76.107,99.943H53.926a.9.9,0,0,1-.891-.694.862.862,0,0,1,.475-.981,4.707,4.707,0,0,0,1.432-1.947c1.234-2.608,1.493-6.281,1.493-8.9A8.581,8.581,0,0,1,73.6,87.383c0,.011,0,.023,0,.034,0,2.622.259,6.3,1.493,8.9a4.706,4.706,0,0,0,1.432,1.947.862.862,0,0,1,.475.981A.9.9,0,0,1,76.107,99.943Zm.427-1.668h0Z" transform="translate(0 -74.165)" fill="#a8aaab"/>
                    </g>
                </svg>
                <svg class="appTools-noticeBtnAlert" xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 9 9">
                    <circle id="Эллипс_52" data-name="Эллипс 52" cx="4.5" cy="4.5" r="4.5" fill="#ff6d35"/>
                </svg>
            </div>

        </div>
        <div class="appTools-lang">
            <lang-selector></lang-selector>
        </div>
    </div>
</template>
<script>
let moment = require('moment');

export default {
    data() {
        return {
            call_requests: []
        }
    },

    mounted() {
        this.getData();
    },

    computed: {
        adequate1() {
            let adequate_request = this.call_requests.find(request => {
                return request.slug === 'adequate-1'
            });

            return adequate_request ? moment(adequate_request.date).format('DD.MM HH:mm') : null;
        }
    },

    methods: {
        getData() {
            axios.get('/user-info').then( response => {
                this.call_requests = response.data.requests.calls_details;
            })
        }
    }
}
</script>
