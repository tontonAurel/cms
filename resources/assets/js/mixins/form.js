import { quillEditor } from 'vue-quill-editor'

export default {
    components: {
        quillEditor
    },

    data () {
        return {
            loading: false,
            editorOption: {
                modules: {
                    toolbar: [
                        ['bold', 'italic'],
                    ],
                }
            },
            content: "",
        }
    },
    methods: {
        onSubmit () {
            this.loading = true
            this.$forceUpdate()
        }
    }
}