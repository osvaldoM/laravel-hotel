<template>
    <div>
        <h1 > Room details </h1>
        <hr/>
        <div v-if="room" class="room-details">

            <form method="PUT" v-bind:action="'/api/v1/rooms/' + room.id" v-on:submit="updateRoom">
                <input type="hidden" name="id" v-model="room.id">
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <label for="room-name">Name</label>
                    <input required name="name" type="text" class="form-control" id="room-name" placeholder="Room name" v-model="room.name">
                </div>
                <div class="form-group">
                    <label for="room-type"></label>
                    <select required name="room_type_id" type="text" class="form-control" id="room-type" placeholder="Room type" v-model="room.room_type_id">
                        <option v-for="roomType in roomTypes" v-bind:value="roomType.id" v-bind:selected='roomType.id == room.room_type_id'>{{roomType.name}}</option>
                    </select>
                </div>
                <div class="form-group">
                    <div class="custom-file">
                        <input required name="image" type="file" class="custom-file-input" id="room-image" accept="image/*" v-on:change="previewImage" >
                        <label class="custom-file-label" for="room-image">Change image</label>
                    </div>
                    <output class="image-preview-container col-4">
                        <img :src="previewUrl" v-if="previewUrl" class="image-preview">
                        <p v-else>No image...</p>
                    </output>
                </div>

                <button type="submit" class="btn btn-primary">Update room details</button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            'roomProp': {
                type: Object,
                default: undefined
            }
        },
        data() {
            return {
                room: this.roomProp,
                uploadedImageUrl: undefined,
                roomTypes: []
            }
        },
        mounted(){
            this.loadRoom();
            this.loadRoomTypes();
        },
        methods: {
            loadRoom() {
                return axios.get(`/api/v1/rooms/${this.$route.params.id}`).then( res => this.room = res.data)
            },
            loadRoomTypes() {
                return axios.get(`/api/v1/room_types/`).then( res => this.roomTypes = res.data)
            },
            updateRoom(event) {
                event.preventDefault();
                event.stopImmediatePropagation();

                let form = event.target;
                let formData = new FormData(form);

               axios.post(form.getAttribute('action'), formData).then( res => {
                   this.$toasted.show('Room details updated', {
                       duration: 5000,
                       type: 'success'
                   });
               })
                   .catch((error) => {
                       this.$toasted.show('Error updating Room');
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
                    that.uploadedImageUrl = e.target.result
                };
                reader.readAsDataURL(file)
            }
        },
        computed: {
            previewUrl() {
                return this.uploadedImageUrl || this.room.image_url;
            }
        }
    }
</script>
