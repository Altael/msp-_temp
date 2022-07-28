<template>
    <a v-show="show" href="#"
       class="appMenu-item" @click.prevent="install()">
        <span class="appMenu-itemIcon appIcons msppIcons-pen-tool"></span>
        <span class="appMenu-itemText">{{ __('Install MSP on your home screen') }}</span>
    </a>
</template>

<script>
    export default {
        data() {
            return {
                install_event: null,
                show: false
            }
        },

        mounted() {
            window.addEventListener('beforeinstallprompt', (e) => {
                e.preventDefault();
                this.install_event = e;
                this.show = true;
            });
        },

        methods: {
            install() {
                this.install_event.prompt();
                this.install_event.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('User accepted the A2HS prompt');
                    } else {
                        console.log('User dismissed the A2HS prompt');
                    }
                    this.install_event = null;
                });
            }
        }
    }
</script>
