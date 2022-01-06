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
                                    <ul class="list-unstyled overflow-y-scroll" scroll-region style="height:300px;">
                                        <li class="p-2" v-for="(message, index) in messages" :key="index">
                                            <strong>{{ message.user.name }}</strong>
                                            {{ message.message }}
                                        </li>
                                    </ul>
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
                newMessage : ''
            }
        },
        methods : {
            fetchMessages() {
                axios.get('/chat/messages').then(response => {
                    this.messages = response.data;
                })
            },
            sendMessage() {

                this.messages.push({
                    user:this.user,
                    message:this.newMessage
                });
                this.$inertia.post('/chat/send', {message: this.newMessage}, {
                    preserveScroll : true,
                    onSuccess : () => this.newMessage = ''
                });
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
            });
        },
        created() {
            this.fetchMessages();
        }
    })
</script>

