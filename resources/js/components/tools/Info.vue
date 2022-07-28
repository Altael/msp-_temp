<template>
    <div>
        <div class="infoBlock" @click="info_modal = true">
            <slot name="label"><div class="infoBlock-icon" :class="icon" :title="__(title)"></div></slot>
        </div>
        <div class="infoBlockModal" :class="{'withText': withText, 'withVideo': withVideo}" v-if="info_modal">
            <div class="infoBlockModal-back"></div>
            <div class="infoBlockModal-content">
                <div class="infoBlockModal-tools" @click="info_modal = false">
                    <div class="infoBlockModal-toolsHead">{{ __(title) }}</div>
                    <div class="infoBlockModal-toolsClose">
                        <div class="msppIcons msppIcons-x"></div>
                    </div>
                </div>
                <div class="infoBlockModal-body">
                    <slot></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            withText: Boolean,
            withVideo: Boolean,
            title: String,
            icon: {
                type: String,
                default: "msppIcons-help-circle"
            }
        },

        data() {
            return {
                info_modal: false
            }
        },

        watch: {
            info_modal() {
                if(this.info_modal) {
                    document.body.classList.add('modalOpen');
                } else {
                    document.body.classList.remove('modalOpen');
                }
            }
        }
    }
</script>
