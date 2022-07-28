<template>
    <div>
        <div class="amScroll" @click="scrollToTop">
            <span class="msppIcons msppIcons-chevron-up"></span>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                offset: 0,
                cont: null
            }
        },

        watch: {
            offset() {
                if(this.offset > (window.innerHeight / 2)) {
                    $('.amScroll').addClass('show');
                } else {
                    $('.amScroll').removeClass('show');
                }
            }
        },

        mounted() {
            this.cont = $('.dhrtScroll-wrapperInner');

            this.cont.on('scroll', () => {
                this.offset = this.cont.scrollTop();
            });
        },

        methods: {
            scrollToTop() {
                this.cont.animate({ scrollTop: 0 }, 500);
            }
        }
    }
</script>
