<template>
    <app-layout icon="chat">
        <div class="flex flex-row  h-[89vh] antialiased text-gray-800">

            <chat-room-list :rooms="rooms" :users="this.users" :chatUsers="chatUsers" @roomList="fetchMessages" />

            <div class="flex flex-col h-full w-full bg-white px-4 py-6">
                <div v-show="currentRoom" class="flex flex-row items-center py-4 px-6 rounded-2xl shadow">
                    <div class="flex items-center justify-center h-10 w-10 rounded-full bg-pink-500 text-pink-100">
                        T
                    </div>
                    <div class="flex flex-col ml-3">
                        <div class="font-semibold text-sm">{{ this.currentToUser }}</div>
                        <div class="text-xs text-gray-500">Active</div>
                    </div>
                    <div class="ml-auto">
                        <ul class="flex flex-row items-center space-x-2">
                            <li>
                                <a href="#"
                                    class="flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-400 h-10 w-10 rounded-full">
                                    <span>
                                        <svg class="w-5 h-5" fill="currentColor" stroke="none" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                            </path>
                                        </svg>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-400 h-10 w-10 rounded-full">
                                    <span>
                                        <svg class="w-5 h-5" fill="currentColor" stroke="none" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-400 h-10 w-10 rounded-full">
                                    <span>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                            </path>
                                        </svg>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
                <div class="h-full">
                      <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2  flex space-x-2 animate-pulse"
                                v-show="loading">
                                <div class="w-8 h-8 bg-blue-400 rounded-full"></div>
                                <div class="w-8 h-8 bg-blue-400 rounded-full"></div>
                                <div class="w-8 h-8 bg-blue-400 rounded-full"></div>
                            </div>

                    <div class="h-full" @contextmenu.prevent @click="hideContextMenu()">
                        <div>
                            <ul id="chatBody"
                                class="space-y-2  overflow-y-auto max-h-[67vh] flex flex-col-reverse w-full p-2 scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch ">

                                <chat-messages :messages="this.messages.data" :user="user" @deleteMessage="this.fetchMessages(this.currentRoom, this.currentToUser)" />

                            </ul>
                            <div class="relative">
                                <button @click="onButtom(), this.newMsg = ''" id="newMsg" v-show="newMsg"
                                    class="absolute bottom-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-11/12 bg-gray-300 rounded-xl opacity-50">
                                    {{ this.newMsg }}
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="fixed  bottom-[12vh] sm:right-10">
                    <VuemojiPicker :isDark=false v-if="showEmojiValue==1" :locale="locale"
                        @emojiClick="handleEmojiClick" :picker-style="style"
                        class="emojipicker scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch" />
                </div>
                <div v-if="currentRoom" class="flex flex-row items-center">
                    <div class="flex flex-row items-center w-full border rounded-3xl h-12 px-2">

                        <button class="flex items-center justify-center h-10 w-10 text-gray-400 ml-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z">
                                </path>
                            </svg>
                        </button>

                        <discord-picker class="text-gray-400 mb-4 mr-3" gif-format="md" @update:value="value = $event"
                            @emoji="setEmoji" />
                        <div class="w-full">
                            <input v-model="newMessage" @keyup.enter="sendMessage" type="text"
                                class="border border-transparent w-full focus:outline-none text-sm h-10 flex items-center"
                                placeholder="Type your message....">
                        </div>
                        <div class="flex flex-row">
                            <button @click="showEmoji" class="flex items-center justify-center h-10 w-8 text-gray-400">
                                <span class="material-icons">
                                    mood
                                </span>
                            </button>
                            <label class="flex cursor-pointer items-center justify-center h-10 w-8 text-gray-400 ml-1 mr-2">
                                <span class="material-icons">
                                    attachment
                                </span>
                                <input type='file' class="hidden" multiple ref="file" @change="sendMessage" />
                            </label>
                        </div>
                    </div>
                    <div class="ml-6">
                        <button @click="sendMessage"
                            class="flex items-center justify-center h-10 w-10 rounded-full bg-gray-200 hover:bg-gray-300 text-indigo-800 text-white">
                            <span class="material-icons small">
                                navigate_next
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>

</template>

<script>
    import {
        defineComponent
    } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import ChatMessages from './ChatMessages.vue'
    import ChatRoomList from './ChatRoomList.vue'
    import axios from 'axios'
    import moment from 'moment'
    import $ from 'jquery'
    import {
        VuemojiPicker,
        EmojiClickEventDetail,
        VuemojiPickerStyle
    } from 'vuemoji-picker'
    import JetDialogModal from '@/JetStream/DialogModal.vue'
    export default defineComponent({
        props: ['user', 'rooms', 'chatUsers'],
        components: {
            AppLayout,
            VuemojiPicker,
            JetDialogModal,
            ChatMessages,
            ChatRoomList,
        },
        data() {
            return {
                users: [],
                messages: [],
                newMessage: '',
                newMsg: '',
                showEmojiValue: 0,
                locale: '',
                currentRoom: null,
                currentToUser: null,
                loading: false,
                isfullpage: false,
            }
        },
        methods: {
            downloadPhoto() {
                axios.get('/chat/download/photo/'+this.clickPhoto).then(response => {
                    console.log('ok');
                })
            },
            hideContextMenu() {
                document.getElementById("message-set-menu").style.display = "none"
                this.showEmojiValue = 0
            },
            fetchMessages(roomId, toUser) { //메세지 가져오기
                console.log(11);
                axios.get('/chat/messages/' + roomId).then(response => {

                    this.messages = response.data;
                });
                this.currentRoom = roomId;
                this.currentToUser = toUser;
            },
            sendMessage() { //메세지 보내기
                if (this.newMessage == '') {
                    console.log(this.$refs);
                    if(this.$refs.file){

                        const formData = new FormData();
                        formData.append('room_id', this.currentRoom);
                        if(this.$refs.file.files.length > 1){
                            for(let i = 0; i <this.$refs.file.files.length; i++ ){
                                formData.append('file[]', this.$refs.file.files[i]);
                            }
                        }else{
                            formData.append('file', this.$refs.file.files[0]);
                        }

                        axios.post('/chat/send', formData, {headers: {'Content-Type': 'multipart/from-data'}}).then(response => {
                            console.log(1);
                            this.fetchMessages(this.currentRoom, this.currentToUser);
                        });
                        this.newMessage = '',
                        this.$refs.file = '',
                        this.onButtom();
                    }else {
                        return;
                    }

                } else {
                    this.messages.data.unshift({
                        user: this.user,
                        message: this.newMessage,
                    });
                    axios.post('/chat/send', {
                        message: this.newMessage,
                        room_id: this.currentRoom,
                    }).then(response => {
                    });
                    this.newMessage = '',
                        this.onButtom();
                }
            },
            onButtom() { // 스크롤 맨 밑으로
                console.log(1);
                document.getElementById('chatBody').scrollTop = document.getElementById('chatBody')
                    .scrollHeight;

            },
            handleEmojiClick(EmojiClickEventDetail) {
                this.newMessage += EmojiClickEventDetail.unicode
            },
            showEmoji() {
                if (this.showEmojiValue == 0) {
                    this.showEmojiValue = 1;
                } else {
                    this.showEmojiValue = 0
                    console.log("0으로")
                }
            },
            loadMore() {
                this.loading = true;
                if (this.messages.current_page == this.messages.last_page) {
                    this.loading = false;
                    return;
                } else {
                    axios.get(this.messages.next_page_url).then(response => {
                        this.messages = {
                            ...response.data,
                            'data': [...this.messages.data, ...response.data.data]
                        };
                        this.messages.data = this.messages.data;
                    }).catch(error => {
                        console.log(error);
                    });
                }
                setTimeout(e => {
                    this.loading = false;
                }, 1000);
            }
        },
        mounted() {
            Echo.join('chat')
                .here(user => {
                    console.log('here');
                    console.log(user);
                    this.users = user;
                })
                .joining(user => {
                    console.log('joining');
                    console.log(user);
                    this.users.push(user);
                })
                .leaving(user => {
                    console.log('leaving');
                    console.log(user);
                    this.users = this.users.filter(u => u.id != user.id);
                })
                .listen('MessageSent', (event) => { //이벤트
                    this.messages.data.unshift(event.message);
                    if (document.getElementById('chatBody').scrollTop !=
                        0) { //메세지 왔을 때 밑에 띄워주는 newMsg에 메세지 저장
                        this.newMsg = event.message.message;
                    } else {
                        // setTimeout(()=> {
                        document.getElementById('chatBody').scrollTop = document.getElementById('chatBody')
                            .scrollHeight
                        // }, 0)
                    }
                })
                .listen('MessageDelete', (event) => {
                    this.fetchMessages(this.currentRoom, this.currentToUser);
                });

            let vm = this;
            const chatBody2 = document.getElementById('chatBody');
            chatBody2.addEventListener('scroll', function () { //채팅창 스크롤 이벤트
                vm.hideContextMenu();
                if (-chatBody2.scrollTop + chatBody2
                    .clientHeight - chatBody2.scrollHeight == -1) {
                    vm.loadMore();
                }
            });
            // 외부영역 클릭 시 팝업 닫기
            const emojipicker = document.getElementsByClassName('emojipicker')
            const chatBody = document.getElementById('chatBody')
            chatBody.addEventListener('click', (e) => {
                e.target === emojipicker ? pass : this.showEmojiValue = 0
            })
        },
        created() {
            var locale = window.navigator.userLanguage || window.navigator.language;
            this.locale = locale.substr(0, 2);
            moment.locale(locale);
        }
    })
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
