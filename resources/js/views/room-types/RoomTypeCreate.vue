<template>
    <div>
        <h1>Create Room Type </h1>
        <hr/>
        <div class="room-types">

            <form method="POST" v-bind:action="'/api/v1/room_types/'" v-on:submit="createRoomType">
                <div class="form-group">
                    <label for="room-type-name">Room Type Name</label>
                    <input name="name" required type="text" class="form-control" id="room-type-name" placeholder="Room Type name" v-model="roomType.name">
                </div>

                <button type="submit" class="btn btn-primary">Add Room Type</button>
            </form>
        </div>
    </div>
</template>

<script>

    export default {
        data(){
            return {
                roomType: {}
            }
        },
        mounted(){
        },
        methods: {
            createRoomType(event){
                event.preventDefault();
                event.stopImmediatePropagation();

                let form = event.target;
                let formData = new FormData(form);

                axios.post(form.getAttribute('action'), formData).then(res => {
                    this.$toasted.show('Room type created', {
                        duration: 5000,
                        type: 'success'
                    });
                    this.$router.push({ name:'roomTypeDetails', params: {id: res.data.id, roomType: res.data }});
                })
                    .catch((error) => {
                        this.$toasted.show('Error updating Room type' + error.message);
                    })
            }
        }
    }
</script>
