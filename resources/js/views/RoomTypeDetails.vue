<template>
    <div>
        <h1 > Room type details </h1>
        <hr/>
        <div v-if="roomType" class="room-type-details">

            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">General</a>
                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Pricing</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <form method="PUT" v-bind:action="'/api/v1/room_types/' + roomType.id" v-on:submit="updateRoomType">
                        <input type="hidden" name="id" v-model="roomType.id">
                        <input type="hidden" name="_method" value="PUT">
                        <div class="form-group">
                            <label for="room-type-name">Room Type Name</label>
                            <input name="name" type="text" class="form-control" id="room-type-name" placeholder="Room Type name" v-model="roomType.name">
                        </div>

                        <button type="submit" class="btn btn-primary">Update Room Type details</button>
                    </form>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <!--<form method="PUT" v-bind:action="'/api/v1/roomTypes/' + hotel.id" v-on:submit="updatePricing">-->

                <!--<div class="form-group">-->
                <!--<label for="rack-rate">Rack rate</label>-->
                <!--<input name="rack_rate" type="text" class="form-control" id="rack-rate" placeholder="Rack rate" v-model="pricing.rack_rate">-->
                <!--</div>-->
                <!--<div class="form-group">-->
                <!--<label for="min-stay-length">Mininum Length of Stay</label>-->
                <!--<input name="min_stay_length" type="text" class="form-control" id="min-stay-length" placeholder="Mininum Length of Stay" v-model="pricing.min_stay_length">-->
                <!--</div>-->
                <!--<div class="form-group">-->
                <!--<label for="max-stay-length">Maximum Length of Stay</label>-->
                <!--<input name="max_stay_length" type="text" class="form-control" id="max-stay-length" placeholder="Maximum Length of Stay" v-model="pricing.max_stay_length">-->
                <!--</div>-->
                <!--<div class="form-group">-->
                <!--<label for="services">Services</label>-->
                <!--<input name="services" type="text" class="form-control" id="services" placeholder="Services" v-model="pricing.services">-->

                <!--<button type="submit" class="btn btn-primary">Update hotel pricing</button>-->
                <!--</div>-->
                <!--</form>-->
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            'roomType': Object
        },
        data() {
            return {

            }
        },
        mounted(){
            this.loadRoomTypeIfEmpty();
        },
        methods: {
            loadRoomTypeIfEmpty() {
                if(!this.roomType) {
                    axios.get(`/api/v1/room_types/${this.$route.params.id}`).then( res => this.roomType = res.data)
                }
            },
            updateRoomType(event) {
                event.preventDefault();
                event.stopImmediatePropagation();

                let form = event.target;
                let formData = new FormData(form);

                axios.post(form.getAttribute('action'), formData).then( res => {
                    this.$toasted.show('Room type details updated', {
                        duration: 5000,
                        type: 'success'
                    });
                })
                    .catch((error) => {
                        this.toasted.show('Error updating Room type');
                    })
            }
        }
    }
</script>
