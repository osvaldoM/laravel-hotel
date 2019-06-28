<template>
    <div>
        <h1> Rooms </h1>
        <hr/>
        <div class="rooms" >
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th>Name</th>
                    <th class="text-sm-right">Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="room in rooms">
                    <th scope="row">{{room.id}}</th>
                    <td>{{room.name}}</td>
                    <td class="text-sm-right">
                        <router-link :to="{name:'roomTypeDetails', params: {id: room.id, roomType: room}}" class="btn btn-secondary"><span class="oi oi-pencil"></span></router-link>
                        <button class="btn btn-danger"> <span class="oi oi-delete"></span> </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                rooms: []
            }
        },
        mounted() {
            this.loadRoomTypes();
        },
        methods: {
            loadRoomTypes: function(event) {
                axios.get('/api/v1/rooms')
                    .then( res => {
                        this.rooms = res.data;
                    })
            }
        }
    }
</script>
