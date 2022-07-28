<template>
    <div>
        <div class="dhrtModalWindow-footerButton" @click="fileUploader = true">{{ __('Upload files to server') }}</div>

        <modal-window v-if="fileUploader" @close="closeFile" @enter="uploadFile" :valid="!!file && !isProcessing"
                      :buttonList="['Close', 'Save']" @save="uploadFile"
                      :windowName="__('File upload')">
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('Choose file') }}</div>
                <input type="file" name="file_upload_file" @change="selectFile" class="appForm-input">
            </div>
            <div class="appForm-group">
                <div class="appForm-groupTitle">{{ __('File name (without extension). Leave empty to keep original name') }}</div>
                <input type="text" name="file_upload_file_name" v-model="fileName" class="appForm-input">
            </div>
        </modal-window>

        <modal-window v-if="fileUploadSuccess" @close="closeSuccess" @enter="closeSuccess"
                      :buttonList="['Close']"
                      :windowName="'File uploaded successfully'">
            {{ __('File uploaded successfully') }}
        </modal-window>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                file: null,
                fileName: '',
                fileUploader: false,
                fileUploadSuccess: false,

                isProcessing: false
            }
        },

        methods: {
            closeFile() {
                this.fileUploader = false;
            },

            closeSuccess() {
                this.fileUploadSuccess = false;
                this.fileUploader = false;
                this.$emit('media-uploaded');
            },

            selectFile(e) {
                this.file = e.target.files[0];
            },

            uploadFile() {
                const data = new FormData();
                data.append('file', this.file);
                data.append('fileName', this.fileName);
                this.isProcessing = true;
                axios.post('/upload-file', data).then(response => {
                    this.isProcessing = false;
                    if(response.data.status === 'ok') {
                        this.fileUploadSuccess = true;
                    }
                });
            }
        }
    }
</script>
