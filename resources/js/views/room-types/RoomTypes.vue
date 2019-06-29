<template>
    <div>
        <h1> Room Types </h1>
        <hr/>
        <div class="hotels" >
            <div class="text-sm-right add-item">
                <router-link :to="{name:'roomTypeCreate'}" class="btn btn-primary"><span class="oi oi-plus"></span></router-link>
            </div>
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th>Name</th>
                    <th class="text-sm-right">Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(roomType, index) in roomTypes">
                    <th scope="row">{{roomType.id}}</th>
                    <td>{{roomType.name}}</td>
                    <td class="text-sm-right">
                        <router-link :to="{name:'roomTypeDetails', params: {id: roomType.id, roomType: roomType}}" class="btn btn-secondary"><span class="oi oi-pencil"></span></router-link>
                        <button class="btn btn-danger" v-on:click="confirmRoomTypeDeletion(roomType, index)"> <span class="oi oi-delete"></span> </button>
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
            },
            confirmRoomTypeDeletion: function (roomType, index){
                this.$toasted.show(`Click here to confirm you want to delete room type: ${roomType.name}`, {
                    duration: 3000,
                    type: 'info',
                    action : {
                        text : 'delete Room Type',
                        onClick : (e, toastObject) => {
                            toastObject.goAway(0);
                            this.deleteRoomType(roomType, index);
                        }
                    }
                });
            },
            deleteRoomType: function (roomType, index){
                axios.delete(`api/v1/room_types/${roomType.id}`).then( res => {
                    this.$toasted.show('Room type deleted', {
                        duration: 3000,
                        type: 'success'
                    });
                    this.$delete(this.roomTypes, index);
                }).
                catch(err => {
                    this.$toasted.show('Failed to delete room type', {
                        duration: 3000,
                        type: 'error'
                    });
                })
            }
        }
    }
</script>
