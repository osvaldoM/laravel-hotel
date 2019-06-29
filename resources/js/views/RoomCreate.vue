<template>
    <div>
        <h1 > Room details </h1>
        <hr/>
        <div class="room-details">

            <form method="POST" v-bind:action="'/api/v1/rooms/'" v-on:submit="createRoom">
                <div class="form-group">
                    <label for="room-name">Name</label>
                    <input required name="name" type="text" class="form-control" id="room-name" placeholder="Room name" v-model="room.name">
                </div>
                <div class="form-group">
                    <label for="room-type">Room type</label>
                    <select required name="room_type_id" type="text" class="form-control" id="room-type" placeholder="room type" v-model="room.room_type_id">
                        <option v-for="roomType in roomTypes" v-bind:value="roomType.id">{{roomType.name}}</option>
                    </select>
                </div>
                <div class="form-group">
                    <div class="custom-file">
                        <input name="image" type="file" class="custom-file-input" id="room-image" accept="image/*" v-on:change="previewImage" >
                        <label class="custom-file-label" for="room-image">Change image</label>
                    </div>
                    <output class="image-preview-container col-4">
                        <img :src="previewUrl" v-if="previewUrl" class="image-preview">
                        <p v-else>No image...</p>
                    </output>
                </div>

                <button type="submit" class="btn btn-primary">Add room</button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                previewUrl: '',
                roomTypes: [],
                room: {
                    name: '',

                }
            }
        },
        mounted(){
            this.loadRoomTypes();
        },
        methods: {
            loadRoomTypes() {
                return axios.get(`/api/v1/room_types/`).then( res => this.roomTypes = res.data)
            },
            createRoom(event) {
                event.preventDefault();
                event.stopImmediatePropagation();

                let form = event.target;
                let formData = new FormData(form);

               axios.post(form.getAttribute('action'), formData).then( res => {
                   this.$toasted.show('Room created', {
                       duration: 5000,
                       type: 'success'
                   });
                   this.$router.push({ name:'roomDetails', params: {id: res.data.id, room: res.data }});
               })
                   .catch((error) => {
                       this.$toasted.show('Error adding Room');
                   })
            },
            previewImage: function (event) {
                const file = event.target.files[0];
                if (!file) {
                    return false
                }
                if (!file.type.match('image.*')) {
                    return false
                }
                const reader = new FileReader();
                const that = this;
                reader.onload = function (e) {
                    that.previewUrl = e.target.result
                };
                reader.readAsDataURL(file)
            }
        }
    }
</script>
