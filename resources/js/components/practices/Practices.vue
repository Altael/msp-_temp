<template>
    <div id="amCategories" class="amPage">
        <div class="amPage-title" @click="back()">
            {{ __('Practices') }}
        </div>
        <div class="amCategories-content">
            <div class="amCategories-items">
                <div class="amCategories-item withSevronRight">
                    <div class="amCategories-itemTitle textOverflowRow">
                        {{ __('Category Name первого уровня из категории Practices') }}
                    </div>
                    <div class="amCategories-itemSubtitle textOverflowRows">
                        {{ __('Category Description') }}
                    </div>
                </div>

            </div>
        </div>

    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'

    export default {
        components: {
            Multiselect
        },

        data() {
            return {
                page: 1,
                perPage: 10,
                total: 0,

                programs: [],
                item: null,
                itemIndex: null,
                editor: null,
                isProcessing: false,

                sortBy: 'created_at',
                sortOrder: 'desc',
            }
        },

        mounted() {
            this.getData();
        },

        computed: {
            skip() {
                return (this.page - 1) * this.perPage;
            },
        },

        watch: {
            page() {
                this.getData();
            },

            filters: {
                deep: true,
                handler() {
                    //if(this.filters.sex === "null") this.filters.sex = null;
                    this.page = 1;
                    this.getData();
                }
            },
        },

        methods: {
            getData() {
                let params = {
                    //ru: this.filters.ru ? this.filters.ru : null,

                    sortBy: this.sortBy,
                    sortOrder: this.sortOrder,

                    take: this.perPage,
                    skip: this.skip,
                };

                axios.get('/programs-list', {params: params}).then(response => {
                    this.programs = response.data.programs;
                    //this.total = response.data.total;
                });
            },

            save() {
                if(this.isProcessing) return;
                this.isProcessing = 1;
                axios.post('/programs-list', {program: this.item}).then(response => {
                    this.isProcessing = 0;
                    this.getData();
                    this.close();
                }).catch(error => {
                    this.isProcessing = 0;
                });
            },

            close() {
                this.item = null;
                this.editor = null;
            },

            edit(item, index) {
                this.item = JSON.parse(JSON.stringify(item));
                this.itemIndex = index;
                this.editor = 1;
            },

            create() {
                this.item = {
                    id: null,
                    slug: '',
                    name_en: '',
                    name_ru: ''
                };
                this.editor = 1;
            },

            sort(column) {
                if (this.sortBy === column) {
                    this.sortOrder = this.sortOrder === 'desc' ? 'asc' : 'desc';
                } else {
                    this.sortOrder = 'desc';
                    this.sortBy = column;
                }

                this.$nextTick(() => {
                    this.getData();
                });
            },

            back() {
                window.history.back();
            }
        }
    }

</script>
