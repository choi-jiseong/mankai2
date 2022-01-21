<template>
    <li class="flex p-1" v-for="(message, index) in messages" :key="index"
        :class="message.user.id == user.id ? 'justify-end' : 'justify-start'">

        <div>
            <div v-if="message.user.id != user.id"
                class="h-10 w-10 rounded-full border overflow-hidden">
                <img :src="message.user.profile_photo_url ? message.user.profile_photo_url : message.user.profile_photo_path "
                    alt="Avatar" class="h-full w-full" />
            </div>
        </div>
        <div class="flex-row ml-4 max-w-md" @contextmenu="showContextMenu($event, message)">
            <div v-if="message.user.id != user.id">
                {{message.user.name}}
            </div>
            <div v-if="message.message"
                :id="'message-'+message.id"
                class="message relative px-4 py-2 text-gray-700 rounded-lg shadow text-center"
                :class="message.user.id == user.id ? 'bg-red-300' : 'bg-gray-100'" style="word-break: break-word;">
                {{ message.message }}
            </div>
            <div v-if="message.file">
                <div v-if="message.file.startsWith('[')" class="message flex flex-wrap">
                    <img v-for="image in JSON.parse(message.file)" :key="image" :id="'message-'+message.id" @click="openPhotoModal = true, this.clickPhoto = image"  class="message w-1/2" :src="'/storage/'+image"  alt="">
                </div>
                <img @click="openPhotoModal = true, this.clickPhoto = image"  :id="'message-'+message.id" v-else-if="message.file.startsWith('images', 1)" class="message" :src="'/storage/'+message.file" alt="">
                <div v-else >
                    <div class="message border border-2 rounded-xl h-16 text-center p-3">
                        <a class="message" :href="'/storage/'+message.file">{{ message.file.split('_')[1] }}</a>
                    </div>
                </div>
            </div>

            <div class="text-right">{{moment(message.updated_at).format('A HH:mm')}}</div>
        </div>

    </li>
    <ul v-show="false" id="message-set-menu" class="absolute list-unstyle bg-white border">
        <li @click="copyItem()" class="border hover:bg-red-500">복사</li>
        <li @click="updateItem()" class="border hover:bg-red-500">update</li>
        <li @click="removeItem()" class="border hover:bg-red-500">삭제</li>
    </ul>
    <jet-dialog-modal :show="openPhotoModal">

        <template #content>
            <img class="message" :src="'/storage/'+this.clickPhoto" alt="">
        </template>
        <template #footer>
            <button @click="downloadPhoto" class="flex items-center justify-center h-10 w-8 text-gray-400">
                <span class="material-icons">
                    mood
                </span>
            </button>
        </template>

    </jet-dialog-modal>
</template>

<script>
    import moment from 'moment'
    import $ from 'jquery'
    import {
        VuemojiPicker,
        EmojiClickEventDetail,
        VuemojiPickerStyle
    } from 'vuemoji-picker'
    import JetDialogModal from '@/JetStream/DialogModal.vue'
export default {
    props : ['messages', 'user'],
    components: {
        VuemojiPicker,
        JetDialogModal,
        moment,
    },
    data() {
        return {
            newMsg: '',
            moment: moment,
            setMessage: null,
            openPhotoModal : false,
            clickPhoto : null,
}
    },
    methods: {
            showContextMenu(e, message) {
                console.log(1);
                console.log(message);
                if (e.target.className.startsWith("message")) {
                    e.preventDefault();
                    var menu = document.getElementById("message-set-menu");
                    menu.style.left = e.pageX + 'px'  //퍼센트로 가능한지 찾아봐야됨
                    menu.style.top = e.pageY + 'px'
                    menu.style.display = 'block'
                    this.setMessage = message;
                } else {
                    this.hideContextMenu();
                }
            },
            hideContextMenu() {
                document.getElementById("message-set-menu").style.display = "none"
                this.showEmojiValue = 0
            },
            copyItem() {
                console.log(this.setMessage);
            },
            updateItem() {
                console.log(this.setMessage);
            },
            removeItem() {
                console.log(this.setMessage);
                axios.delete('/chat/delete/message/'+this.setMessage.id)
                    .then(response => {
                        console.log('delete');
                        this.$emit('deleteMessage');
                    });
            },
    },

}
</script>

<style scoped>
    .scrollbar-w-2::-webkit-scrollbar {
        width: 0.25rem;
        height: 0.25rem;
        /* display: none; */
    }
    .scrollbar-track-blue-lighter::-webkit-scrollbar-track {
        --bg-opacity: 1;
        background-color: #f7fafc;
        background-color: rgba(247, 250, 252, var(--bg-opacity));
    }
    .scrollbar-thumb-blue::-webkit-scrollbar-thumb {
        --bg-opacity: 1;
        background-color: #edf2f7;
        background-color: rgba(237, 242, 247, var(--bg-opacity));
        background-color: #a0aec0;
    }
    .scrollbar-thumb-rounded::-webkit-scrollbar-thumb {
        border-radius: 0.25rem;
    }
    emoji-picker {
        --num-columns: 6;
        --emoji-size: 20rem;
        --background: gray;
    }
    .fade-enter-active,
    .fade-leave-active {
        transition: opacity .5s
    }
    .fade-enter,
    .fade-leave-to {
        opacity: 0
    }
</style>
