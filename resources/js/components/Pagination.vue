<template>
    <div class="appPageTools-wrap">
        <div class="appPageTools-total">
            <template v-if="showTotal">{{ __('Showing') }}: {{ totalUsers }} {{ __('results of') }} {{ total }}</template>
        </div>
        <div class="appPageTools pagination">
            <div class="appPageTools-btn" :class="{disabled: page === 1}" @click.prevent="change(1)"><div class="appPageTools-btnText">«</div></div>
            <div class="appPageTools-btn" v-if="number !== '...'" :class="{active: page === number}" v-for="number of pagination(page, pages)" @click.prevent="change(number)"><div class="appPageTools-btnText">{{ number }}</div></div>
            <div class="appPageTools-btn disabled" v-else><div class="appPageTools-btnText">...</div></div>
            <div class="appPageTools-btn" :class="{disabled: page === pages}" @click.prevent="change(pages)"><div class="appPageTools-btnText">»</div></div>
        </div>
    </div>
</template>


<script>
    export default {
        props: {
            value: { type: Number },
            perPage: { type: Number },
            total: { type: Number },
            totalUsers: {type: Number},
            showTotal: { type: Boolean, default: false }
        },

        computed: {
            skip() {
                return (this.page - 1) * this.perPage;
            },

            pages() {
                return parseInt(this.total / this.perPage) + (this.total % this.perPage ? 1 : 0)
            },

            page() {
                return this.value;
            }
        },

        methods: {
            pagination(c, m) {
                let current = c,
                    last = m,
                    delta = 2,
                    left = current - delta,
                    right = current + delta + 1,
                    range = [],
                    rangeWithDots = [],
                    l;

                for (let i = 1; i <= last; i++) {
                    if (i === 1 || i === last || i >= left && i < right) {
                        range.push(i);
                    }
                }

                for (let i of range) {
                    if (l) {
                        if (i - l === 2) {
                            rangeWithDots.push(l + 1);
                        } else if (i - l !== 1) {
                            rangeWithDots.push('...');
                        }
                    }
                    rangeWithDots.push(i);
                    l = i;
                }

                return rangeWithDots;
            },

            change(number) {
                this.$emit('input', number);
            }
        },
    }
</script>
