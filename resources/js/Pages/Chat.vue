<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white">
                    <div class="flex flex-row">
                        <div class="w-2/3">
                            <div class="flex flex-col">
                                <div class="">Messages</div>
                                <div class="p-0 relative">
                                    <ul class="list-unstyled overflow-y-scroll" id="chatBody" style="height:300px;">
                                        <li class="p-2" v-for="(message, index) in messages" :key="index">
                                            <div :class="message.user.id == user.id ? 'text-right' : ''">
                                                <strong v-if="message.user.id != user.id" :class="messages[index-1].user.id == message.user.id ? 'opacity-0':''" class="mr-2">{{ message.user.name }}</strong>
                                                <span class="rounded-md p-2 shadow-md" :class="message.user.id == user.id ? 'bg-blue-300 text-white' : 'bg-gray-300 text-gray-900'">{{ message.message }}</span>
                                            </div>
                                        </li>
                                    </ul>
                                    <button @click="onButtom()" id="newMsg" v-show="newMsg" class="absolute bottom-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-11/12 bg-gray-300 rounded-xl opacity-50">
                                         {{ this.newMsg }}
                                    </button>
                                </div>
                                <input type="text" v-model="newMessage" @keyup.enter="sendMessage" class="form-control" name="message" placeholder="enter your message">
                                <span class="text-muted">user is typing</span>
                            </div>
                        </div>
                        <div class="w-1/3">
                            <div class="card card-default">
                                <div class="card-header">Active Users</div>
                                <div class="card-body">
                                    <ul>
                                        <li class="py-2" v-for="(user,index) in users" :key="index">{{ user.name }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import axios from 'axios'


    export default defineComponent({
        props : ['user'],
        components: {
            AppLayout,
        },
        data() {
            return {
                users :[],
                messages : [],
                newMessage : '',
                newMsg : '',
            }
        },
        methods : {
            fetchMessages() {  //메세지 가져오기
                axios.get('/chat/messages').then(response => {
                    this.messages = response.data;
                });
                // this.onButtom();
            },
            sendMessage() { //메세지 보내기
                if(this.newMessage == '') {
                    return ;
                }else {
                    this.messages.push({
                        user:this.user,
                        message:this.newMessage
                    });
                    axios.post('/chat/send', {message: this.newMessage}).then(response => {
                        this.newMessage = '',
                        this.onButtom()
                    });
                }

            },
            onButtom() {  // 스크롤 맨 밑으로
                document.getElementById('chatBody').scrollTop = document.getElementById('chatBody').scrollHeight;
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
            .listen('MessageSent', (event) => {  //이벤트
                this.messages.push(event.message);
                if(document.getElementById('chatBody').scrollTop != document.getElementById('chatBody').scrollHeight - 300) { //메세지 왔을 때 밑에 띄워주는 newMsg에 메세지 저장
                    this.newMsg = event.message.message;
                }else{
                    setTimeout(()=> {
                        document.getElementById('chatBody').scrollTop = document.getElementById('chatBody').scrollHeight
                    }, 0)
                }
            });
            const vm = this;
            document.getElementById('chatBody').addEventListener('scroll', function(){  //채팅창 스크롤 이벤트
                console.log(document.getElementById('chatBody').scrollTop)
                console.log(document.getElementById('chatBody').scrollHeight)
                if(document.getElementById('chatBody').scrollTop == document.getElementById('chatBody').scrollHeight-300){ //스크롤 맨 밑으로 내리면 newMsg false로
                    console.log(1)
                    vm.newMsg = ''

                }

            });

        },
        created() {
            this.fetchMessages();

        }
    })
</script>



