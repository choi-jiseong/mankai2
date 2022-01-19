<template>
    <app-layout icon="chat">
        <div class="flex flex-row  h-[89vh] antialiased text-gray-800">
            <div class="flex flex-row w-96 flex-shrink-0 bg-gray-100 p-4 hidden sm:block">

                <div class="flex flex-col w-full h-full pl-4 pr-4 py-4 -mr-4 ">
                    <div class="flex flex-row items-center">
                        <div class="flex flex-row items-center">
                            <div class="text-xl font-semibold">Messages</div>
                            <div
                                class="flex items-center justify-center ml-2 text-xs h-5 w-5 text-white bg-red-500 rounded-full font-medium">
                                5</div>
                        </div>
                        <div class="ml-auto">
                            <button @click="openRoomInvite = true"
                                class="flex items-center justify-center h-7 w-7 bg-gray-200 text-gray-500 rounded-full">
                                <span class="material-icons">
                                    add
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="mt-5">
                        <ul class="flex flex-row items-center justify-between">
                            <li>
                                <a href="#"
                                    class="flex items-center pb-3 text-xs font-semibold relative text-indigo-800">
                                    <span>All Conversations</span>
                                    <span class="absolute left-0 bottom-0 h-1 w-6 bg-indigo-800 rounded-full"></span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center pb-3 text-xs text-gray-700 font-semibold">
                                    <span>Archived</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center pb-3 text-xs text-gray-700 font-semibold">
                                    <span>Starred</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="mt-5">
                        <div class="text-xs text-gray-400 font-semibold uppercase">Team</div>
                    </div>
                    <div class="mt-2">
                        <div class="flex flex-col -mx-4">
                            <div class="relative flex flex-row items-center p-4">
                                <div class="absolute text-xs text-gray-500 right-0 top-0 mr-4 mt-3">5 min</div>
                                <div
                                    class="flex items-center justify-center h-10 w-10 rounded-full bg-pink-500 text-pink-300 font-bold flex-shrink-0">
                                    T
                                </div>
                                <div class="flex flex-col flex-grow ml-3">
                                    <div class="text-sm font-medium">Cuberto</div>
                                    <div class="text-xs truncate w-40">Lorem ipsum dolor sit amet, consectetur
                                        adipisicing elit. Debitis, doloribus?</div>
                                </div>
                                <div class="flex-shrink-0 ml-2 self-end mb-1">
                                    <span
                                        class="flex items-center justify-center h-5 w-5 bg-red-500 text-white text-xs rounded-full">5</span>
                                </div>
                            </div>
                            <div
                                class="flex flex-row items-center p-4 bg-gradient-to-r from-red-100 to-transparent border-l-2 border-red-500">
                                <div
                                    class="flex items-center justify-center h-10 w-10 rounded-full bg-pink-500 text-pink-300 font-bold flex-shrink-0">
                                    T
                                </div>
                                <div class="flex flex-col flex-grow ml-3">
                                    <div class="flex items-center">
                                        <div class="text-sm font-medium">UI Art Design</div>
                                        <div class="h-2 w-2 rounded-full bg-green-500 ml-2"></div>
                                    </div>
                                    <div class="text-xs truncate w-40">Lorem ipsum dolor sit amet, consectetur
                                        adipisicing elit. Debitis, doloribus?</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5">
                        <div class="text-xs text-gray-400 font-semibold uppercase">Personal</div>
                    </div>
                    <div class="h-full overflow-hidden relative pt-2">
                        <div  class="flex flex-col divide-y h-full overflow-y-auto -mx-4"  >
                            <div @click="fetchMessages(room.id, chatUsers[index])" v-for="(room, index) in rooms"
                                :key="room.id" class="flex flex-row items-center p-4 relative">
                                <div class="absolute text-xs text-gray-500 right-0 top-0 mr-4 mt-3">2 hours ago</div>
                                <div
                                    class="flex items-center justify-center h-10 w-10 rounded-full bg-pink-500 text-pink-300 font-bold flex-shrink-0">
                                    T
                                </div>
                                <div class="flex flex-col flex-grow ml-3">
                                    <div class="text-sm font-medium">{{ chatUsers[index] }}</div>
                                    <div class="text-xs truncate w-40">Good after noon! how can i help you?</div>
                                </div>
                                <div class="flex-shrink-0 ml-2 self-end mb-1">
                                    <span
                                        class="flex items-center justify-center h-5 w-5 bg-red-500 text-white text-xs rounded-full">3</span>
                                </div>
                            </div>

                        </div>
                        <div class="absolute bottom-0 right-0 mr-2">
                            <button
                                class="flex items-center justify-center shadow-sm h-10 w-10 bg-red-500 text-white rounded-full">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col h-full w-full bg-white px-4 py-6">
                <div class="flex flex-row items-center py-4 px-6 rounded-2xl shadow">
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

                                <li class="flex p-1" v-for="(message, index) in messages.data" :key="index"
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

                                        <img :id="'message-'+message.id" v-if="message.file.startsWith('images', 1)" class="message" :src="'/storage/'+message.file" alt="">
                                        <div v-else>
                                            <a :href="'/storage/'+message.file">{{ message.file }}</a>
                                        </div>
                                        <div class="text-right">{{moment(message.updated_at).format('A HH:mm')}}</div>
                                    </div>

                                </li>
                                <ul v-show="false" id="message-set-menu" class="absolute list-unstyle bg-white border">
                                    <li @click="copyItem()" class="border hover:bg-red-500">복사</li>
                                    <li @click="updateItem()" class="border hover:bg-red-500">update</li>
                                    <li @click="removeItem()" class="border hover:bg-red-500">삭제</li>
                                </ul>
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
                            <button class="flex items-center justify-center h-10 w-8 text-gray-400">
                                <span class="material-icons">
                                    attachment
                                </span>
                            </button>
                            <label class="flex cursor-pointer items-center justify-center h-10 w-8 text-gray-400 ml-1 mr-2">
                                <span class="material-icons">
                                    image
                                </span>
                                <input type='file' class="hidden" ref="file" @change="sendMessage" />
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
        <jet-dialog-modal :show="openRoomInvite">
            <template #title>
                Favorite
            </template>
            <template #content>
                <div>
                    <div @click="this.checkUser = user" v-for="user in users" :key="user.id">{{user.name}}</div>
                </div>
            </template>
            <template #footer>
                <button @click="createRoom(this.checkUser.id)">createRoom</button>
            </template>

        </jet-dialog-modal>
    </app-layout>

</template>

<script>
    import {
        defineComponent
    } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import axios from 'axios'
    import moment from 'moment'
    import $ from 'jquery'
    import {
        VuemojiPicker,
        EmojiClickEventDetail,
        VuemojiPickerStyle
    } from 'vuemoji-picker'
    import JetDialogModal from '@/JetStream/DialogModal.vue'
    import FileUpload from 'vue-upload-component'
    export default defineComponent({
        props: ['user', 'rooms', 'chatUsers'],
        components: {
            AppLayout,
            VuemojiPicker,
            JetDialogModal,
            FileUpload
        },
        data() {
            return {
                users: [],
                messages: [],
                newMessage: '',
                newMsg: '',
                setMessage: null,
                moment: moment,
                showEmojiValue: 0,
                locale: '',
                openRoomInvite: false,
                checkUser: null,
                currentRoom: null,
                currentToUser: null,
                loading: false,
                isfullpage: false,
            }
        },
        methods: {
            createRoom(id) {
                axios.post('/chat/create/room', {
                    id: id
                }).then(response => {
                    console.log('success');
                })
            },
            showContextMenu(e, message) {
                console.log(message);
                if (e.target.className.startsWith("message")) {
                    e.preventDefault();
                    var menu = document.getElementById("message-set-menu");
                    menu.style.left = e.pageX + 'px'  //퍼센트로 가능한지 찾아봐야됨
                    menu.style.top = e.pageY + 'px'
                    menu.style.display = 'block'
                    console.log(message.id)
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
                        this.fetchMessages(this.currentRoom, this.currentToUser);
                    });
            },
            fetchMessages(roomId, toUser) { //메세지 가져오기
                axios.get('/chat/messages/' + roomId).then(response => {

                    this.messages = response.data;
                    console.log(this.messages.data[0].file.startsWith('files', 1));
                });
                // this.$inertia.get('/chat/messages');
                this.currentRoom = roomId;
                this.currentToUser = toUser;
            },
            sendMessage() { //메세지 보내기
                if (this.newMessage == '') {
                    console.log(this.$refs);
                    if(this.$refs.file){

                        // this.messages.data.unshift({
                        //     user: this.user,
                        //     message: this.newMessage,
                        //     image : this.$refs.image.files[0],
                        // });
                        const formData = new FormData();
                        formData.append('message', this.newMessage);
                        formData.append('room_id', this.currentRoom);
                        formData.append('file', this.$refs.file.files[0]);
                        axios.post('/chat/send', formData, {headers: {'Content-Type': 'multipart/from-data'}}).then(response => {
                            console.log(1);
                            this.fetchMessages(this.currentRoom, this.currentToUser);
                        });
                        this.newMessage = '',
                            this.onButtom();
                        // this.$inertia.post('/chat/send', formData, {headers: {'Content-Type': 'multipart/from-data'}});
                    }else {
                        return;
                    }

                } else {
                    this.messages.data.unshift({
                        user: this.user,
                        message: this.newMessage,
                        image : this.$refs.image.files[0],
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
                // Echo.join('user')
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
                    // console.log(event.message);
                    this.fetchMessages(this.currentRoom, this.currentToUser);
                    // console.log(this.messages.data);
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
            // this.fetchMessages();
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
