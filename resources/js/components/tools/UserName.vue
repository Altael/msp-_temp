<template>
    <div class="appUser-name" @click="details(id)" :title="name">
        {{ name }}
    </div>
</template>

<script>

    export default {
        props: {
            social: {
                type: String,
                default: null
            },
            spiritual: {
                type: String,
                default: null
            },
            alias: {
                type: String,
                default: null
            },
            id: {
                type: Number,
                default: null
            }
    },

        data() {
            return {
                user_id: null
            }
        },

        computed: {
            name() {
                let result = '';

                if(this.spiritual) {
                    result += this.spiritual;
                    result += ' (';
                    result += this.social;
                    result += ')';
                } else {
                    result += this.social;
                }

                if(this.alias) {
                    if(this.spiritual || this.social) {
                        result += ' / ';
                    }
                    result += this.alias;
                }

                return result;
            }
        },

        methods: {
            details(id) {
                this.$root.member_info_user_id = id;
            }
        }
    }
</script>
