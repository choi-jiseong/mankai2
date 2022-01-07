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
                                <div class="p-0">
                                    <ul class="list-unstyled overflow-y-scroll" id="chatBody" style="height:300px;">
                                        <li class="p-2" v-for="(message, index) in messages" :key="index">
                                            <strong>{{ message.user.name }}</strong>
                                            {{ message.message }}
                                        </li>
                                    </ul>
                                        <button @click="onButtom()" id="newMsg" v-show="newMsg" class="bg-blue-500">
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
    import VueChatScroll from 'vue-chat-scroll'


    export default defineComponent({
        props : ['user'],
        components: {
            AppLayout,
            VueChatScroll
        },
        data() {
            return {
                users :[],
                messages : [],
                newMessage : '',
                newMsg : ''
            }
        },
        methods : {
            fetchMessages() {
                axios.get('/chat/messages').then(response => {
                    this.messages = response.data;
                });
            },
            sendMessage() {

                this.messages.push({
                    user:this.user,
                    message:this.newMessage
                });
                axios.post('/chat/send', {message: this.newMessage}).then(response => {
                    this.newMessage = '',
                    this.onButtom()
                });
            },
            onButtom() {
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
            .listen('MessageSent', (event) => {
                this.messages.push(event.message);
                if(document.getElementById('chatBody').scrollTop != document.getElementById('chatBody').scrollHeight - 300) {
                    this.newMsg = event.message.message;
                }else{
                    setTimeout(()=> {
                        document.getElementById('chatBody').scrollTop = document.getElementById('chatBody').scrollHeight
                    }, 0)
                }
            });
            const vm = this;
             document.getElementById('chatBody').addEventListener('scroll', function(){
                 console.log(document.getElementById('chatBody').scrollTop)
                 console.log(document.getElementById('chatBody').scrollHeight)
                if(document.getElementById('chatBody').scrollTop == document.getElementById('chatBody').scrollHeight-300){
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

<style scoped>
#newMsg {
    position: absolute;
    top : 480px;
    left : 35px;
    width : 400px;
}
</style>

