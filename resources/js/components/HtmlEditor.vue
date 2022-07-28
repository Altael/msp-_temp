<template>
    <div>
        <div ref="editor">{{ value }}</div>
        <!--<div>{{ chars }}</div>-->
    </div>
</template>

<script>
    require('summernote/dist/summernote-bs4');

    export default {
        props: {
            value: {
                type: String
            },
            height: {
                type: String,
                default: 70
            },
            airmode: {
                type: Boolean,
                default: true
            }
        },

        data() {
            return {

            }
        },

        mounted() {
            $(this.$refs.editor).summernote({
                height: this.height,
                airMode: this.airmode,
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['view', ['codeview']]
                ]
            });

            $(this.$refs.editor).summernote('code', ' ');
            if(this.value) $(this.$refs.editor).summernote('pasteHTML', this.value);

            $(this.$refs.editor).on('summernote.change', function(we, contents, $editable) {
                this.$emit('input', contents);
            }.bind(this));

            this.$watch('value', function (value) {
                let text = $(this.$refs.editor).summernote('code');
                if (value !== text) {
                    $(this.$refs.editor).summernote('code', value);
                }
            });
        },

        computed: {
            chars() {
                if(this.value) return this.stripHtml(this.value).length;
            }
        },

        methods: {
            stripHtml(html) {
                    let tmp = document.createElement("DIV");
                    tmp.innerHTML = html;
                    return tmp.textContent || tmp.innerText || "";
                }
        }
    }
</script>
