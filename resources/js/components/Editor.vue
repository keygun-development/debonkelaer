<template>
    <div id="app">
        <editor
            name="postcontent"
            v-model="content"
            api-key="fyqf04lt7rkwyb2yvkpp25egrhbx75itwx71nfc541t0ckef"
            :init="{
            resize: false,
         height: 400,
         menubar: false,
         toolbar:
           'undo redo | formatselect | bold italic backcolor | \
           alignleft aligncenter alignright alignjustify | \
           bullist numlist outdent indent | removeformat | help'
       }"
        />
    </div>
</template>

<script>
import Editor from '@tinymce/tinymce-vue'

export default {
    data() {
        return {
            content: this.text
        }
    },

    components: {
        'editor': Editor
    },

    props: {
        text: String
    }
}
</script>
