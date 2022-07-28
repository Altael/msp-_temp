<template>
    <div>
        <div class="dhrtModalWindow-footerButton dhrtModalWindow-footerSave" @click="create()">{{ __('Add online file') }}</div>

        <modal-window v-if="file && editor" @close="close" @enter="save()" :valid="file.path && file.type && !isProcessing"
                      @cancel="close" :buttonList="['Cancel', 'Save']" @save="save()"
                      :windowName="__('Add online file')">
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Link') }}</div>
                <input type="text" name="middle_name" v-model="file.path" class="appForm-input">
            </div>
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('File type') }}</div>
                <div class="dhrtRadio">
                    <label>
                        <input type="radio" class="dhrtRadio-noView" v-model="file.type" value="image">
                        <span class="dhrtRadioView"></span>
                        <span>{{ __('Image') }}</span>
                    </label>
                    <label>
                        <input type="radio" class="dhrtRadio-noView" v-model="file.type" value="audio">
                        <span class="dhrtRadioView"></span>
                        <span>{{ __('Audio') }}</span>
                    </label>
                    <label>
                        <input type="radio" class="dhrtRadio-noView" v-model="file.type" value="video">
                        <span class="dhrtRadioView"></span>
                        <span>{{ __('Video') }}</span>
                    </label>
                </div>
            </div>
        </modal-window>
    </div>
</template>
<script>
    export default{
        data() {
            return {
                file: null,
                editor: false,

                isProcessing: false
            }
        },

        methods: {
            create() {
                this.file = {
                    id: null,
                    path: null,
                    type: null,
                    source: 'url'
                };
                this.editor = true;
            },

            close() {
                this.editor = false;
                this.remove = false;
                this.file = null;
            },

            save() {
                this.isProcessing = true;
                axios.post('/save-file',  {file: this.file}).then(response => {
                    this.isProcessing = false;
                    this.close();
                    this.$emit('saved');
                });
            },
        }
    }
</script>
