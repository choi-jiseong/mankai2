<template>
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
                    <div @click="clickRoom(room.id, chatUsers[index])" v-for="(room, index) in rooms"
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
</template>

<script>
    import JetDialogModal from '@/JetStream/DialogModal.vue'
    import axios from 'axios'
export default {
    props : ['rooms', 'chatUsers', 'users'],
    components : {
        JetDialogModal
    },
    data() {
        return {
            checkUser: null,
            openRoomInvite: false,
        }
    },
    methods: {
        clickRoom(roomid, toUser) {
            console.log(toUser);
            this.$emit('roomList', roomid, toUser);
        },
        createRoom(id) {
            axios.post('/chat/create/room', {
                id: id
            }).then(response => {
                console.log('success');
            })
        },
    },
}
</script>

