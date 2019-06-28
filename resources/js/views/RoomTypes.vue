<template>
    <div>
        <h1> Room Types </h1>
        <hr/>
        <div class="hotels" >
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th>Name</th>
                    <th class="text-sm-right">Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="roomType in roomTypes">
                    <th scope="row">{{roomType.id}}</th>
                    <td>{{roomType.name}}</td>
                    <td class="text-sm-right">
                        <router-link :to="{name:'roomTypeDetails', params: {id: roomType.id, roomType: roomType}}" class="btn btn-secondary"><span class="oi oi-pencil"></span></router-link>
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
                roomTypes: []
            }
        },
        mounted() {
            this.loadRoomTypes();
        },
        methods: {
            loadRoomTypes: function(event) {
                axios.get('/api/v1/room_types')
                    .then( res => {
                        this.roomTypes = res.data;
                    })
            }
        }
    }
</script>
