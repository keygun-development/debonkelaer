<template>
    <div>
        <div ref="editor"></div>
        <input type="hidden" name="postcontent" v-model="editorContent">
    </div>
</template>
<script>
import Quill from "quill";
import "quill/dist/quill.core.css";
import "quill/dist/quill.bubble.css";
import "quill/dist/quill.snow.css";

export default {
    props: {
        text: {
            type: String,
            default: "",
        },
        name: {
            type: String,
            default: "editor",
        },
    },
    data() {
        return {
            editor: null,
            editorContent: this.text,
        };
    },
    mounted() {
        var _this = this;

        this.editor = new Quill(this.$refs.editor, {
            modules: {
                toolbar: [
                    [
                        {
                            header: [1, 2, 3, 4, false],
                        },
                    ],
                    ["bold", "italic", "underline", "link"],
                ],
            },
            theme: "snow",
            formats: ["bold", "underline", "header", "italic", "link"],
            placeholder: "Typ hier iets!",
        });
        this.editor.root.innerHTML = this.text;
        this.editor.on("text-change", function () {
            _this.editorContent = _this.editor.root.innerHTML;
            _this.$emit("update:text", _this.editorContent);
        });
    },
};
</script>
