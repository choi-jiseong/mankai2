<template>
<div class="container mx-auto">
      <div class="min-w-full border rounded lg:grid lg:grid-cols-3">
        <div class="border-r border-gray-300 lg:col-span-1">
          <div class="mx-3 my-3">
            <div class="relative text-gray-600">
              <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  viewBox="0 0 24 24" class="w-6 h-6 text-gray-300">
                  <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
              </span>
              <input type="search" class="block w-full py-2 pl-10 bg-gray-100 rounded outline-none" name="search"
                placeholder="Search" required />
            </div>
          </div>

          <ul class="overflow-auto h-[32rem]">
            <h2 class="my-2 mb-2 ml-2 text-lg text-gray-600">Chat</h2>
            <li>
              <a
                class="flex items-center px-3 py-2 text-sm transition duration-150 ease-in-out border-b border-gray-300 cursor-pointer hover:bg-gray-100 focus:outline-none">
                <img class="object-cover w-10 h-10 rounded-full"
                  src="https://cdn.pixabay.com/photo/2018/09/12/12/14/man-3672010__340.jpg" alt="username" />
                <div class="w-full pb-2">
                  <div class="flex justify-between">
                    <span class="block ml-2 font-semibold text-gray-600">room name</span>
                    <span class="block ml-2 text-sm text-gray-600">date</span>
                  </div>
                  <span class="block ml-2 text-sm text-gray-600">chat content</span>
                </div>
              </a>
            </li>
          </ul>
        </div>
        <div class="hidden lg:col-span-2 lg:block">
          <div class="w-full">
            <div class="relative flex items-center p-3 border-b border-gray-300">
              <img class="object-cover w-10 h-10 rounded-full"
                src="https://cdn.pixabay.com/photo/2018/01/15/07/51/woman-3083383__340.jpg" alt="username" />
              <span class="block ml-2 font-bold text-gray-600">User name</span>
              <span class="absolute w-3 h-3 bg-green-600 rounded-full left-10 top-3">
              </span>
            </div>
            <div @contextmenu.prevent @click="hideContextMenu()">
                <ul id="chatBody" class="space-y-2 flex flex-col-reverse w-full p-6 overflow-y-auto h-[38rem] scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch" >
                    <li class="flex"  v-for="(message, index) in messages.data" :key="index" :class="message.user.id == user.id ? 'justify-end' : 'justify-start'">
                        <span>{{message.user.name}}</span>
                        <div :id="'message-'+message.id" @contextmenu="showContextMenu($event, message)" class="message relative max-w-xl px-4 py-2 text-gray-700 rounded-lg shadow " :class="message.user.id == user.id ? 'bg-red-300' : 'bg-gray-100'">
                            {{ message.message }}
                        </div>
                    </li>
                        <ul v-show="false" id="message-set-menu" class="absolute list-unstyle bg-white border" >
                            <li @click="addNewItem()" class="border hover:bg-red-500">add</li>
                            <li @click="updateItem()" class="border hover:bg-red-500">update</li>
                            <li @click="removeItem()" class="border hover:bg-red-500">delete</li>
                        </ul>
                </ul>
                <div class="relative">
                    <button @click="onButtom()" id="newMsg" v-show="newMsg" class="absolute bottom-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-11/12 bg-gray-300 rounded-xl opacity-50">
                        {{ this.newMsg }}
                    </button>
                </div>
            </div>

            <div class="flex items-center justify-between w-full p-3 border-t border-gray-300">

              <button>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </button>
              <button>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                </svg>
              </button>

              <input v-model="newMessage" @keyup.enter="sendMessage"
                class="block w-full py-2 pl-4 mx-3 bg-gray-100 rounded-full outline-none focus:text-gray-700"
                name="message" required />
              <button>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                </svg>
              </button>
              <button type="submit" @click="sendMessage">
                <svg class="w-5 h-5 text-gray-500 origin-center transform rotate-90" xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 20 20" fill="currentColor">
                  <path
                    d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
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
                setMessage : null,
            }
        },
        methods : {
            showContextMenu(e, message) {
                console.log(message);
                if ( e.target.className.startsWith("message") ) {
                    e.preventDefault();
                    var menu = document.getElementById("message-set-menu");
                    menu.style.left = e.pageX + 'px'
                    menu.style.top = e.pageY + 'px'
                    menu.style.display = 'block'
                    // menu.cid = e.target.id.replace(/message-/,"")
                    // console.log ( "cid")
                    console.log ( message.id )
                    this.setMessage = message;
                }else{
                    this.hideContextMenu();
                }
            },
            hideContextMenu() {
                document.getElementById("message-set-menu").style.display = "none"
            },
            addNewItem() {
                console.log(this.setMessage);
            },
            updateItem() {
                console.log(this.setMessage);
            },
            removeItem() {
                console.log(this.setMessage);
            },
            fetchMessages() {  //메세지 가져오기
                axios.get('/chat/messages').then(response => {
                        this.messages = response.data;
                });
                // this.$inertia.get('/chat/messages');

            },
            sendMessage() { //메세지 보내기
                if(this.newMessage == '') {
                    return ;
                }else {
                    this.messages.data.unshift({
                        user:this.user,
                        message:this.newMessage
                    });

                    axios.post('/chat/send', {message: this.newMessage}).then(response => {
                        this.newMessage = '',
                        this.onButtom();
                    });


                }

            },
            onButtom() {  // 스크롤 맨 밑으로

                    console.log(1);
                    document.getElementById('chatBody').scrollTop = document.getElementById('chatBody').scrollHeight;

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
            .listen('MessageSent', (event) => {  //이벤트
                this.messages.data.unshift(event.message);
                if(document.getElementById('chatBody').scrollTop != 0) { //메세지 왔을 때 밑에 띄워주는 newMsg에 메세지 저장
                    this.newMsg = event.message.message;
                }else{
                    // setTimeout(()=> {
                        document.getElementById('chatBody').scrollTop = document.getElementById('chatBody').scrollHeight
                    // }, 0)
                }
            });
            const vm = this;
            let a = -document.getElementById('chatBody').scrollHeight*(0.3);
            document.getElementById('chatBody').addEventListener('scroll', function(){  //채팅창 스크롤 이벤트
                vm.hideContextMenu();
                console.log(document.getElementById('chatBody').scrollTop)
                console.log(document.getElementById('chatBody').scrollHeight)
                if(document.getElementById('chatBody').scrollTop == 0){ //스크롤 맨 밑으로 내리면 newMsg false로
                    // console.log(1)
                    vm.newMsg = ''
                }
                else if(document.getElementById('chatBody').scrollTop <= a){
                    console.log(1);
                    console.log(a);
                    if(vm.messages.current_page == vm.messages.last_page) {
                        // alert('No more message')
                        return;
                    }else{
                        axios.get(vm.messages.next_page_url).then(response => {
                            // this.messages = response.data;
                            // this.messages.data = [...this.messages.data, ...response.data.data]
                            vm.messages = {...response.data, 'data' : [...vm.messages.data, ...response.data.data]};
                            vm.messages.data = vm.messages.data;
                        }).catch(error => {
                            console.log(error);
                        });
                    }
                    a -= document.getElementById('chatBody').scrollHeight*(0.7);

                }

            });

        },
        created() {
            this.fetchMessages();


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
</style>



