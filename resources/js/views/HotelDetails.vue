<template>
    <div>
        <h1 > Hotel details </h1>
        <hr/>
        <div v-if="hotel" class="hotel-details">

            <form method="PUT" v-bind:action="'api/v1/hotels/' + hotel.id" v-on:submit="updateHotel">
                <input type="hidden" name="id" v-model="hotel.id">
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <label for="hotel-name">Name</label>
                    <input name="name" type="text" class="form-control" id="hotel-name" placeholder="Hotel name" v-model="hotel.name">
                </div>

                <div class="form-group">
                    <label for="hotel-address"> Address</label>
                    <textarea name="address" class="form-control" rows="5" id="hotel-address" placeholder="Hotel adress" v-model="hotel.address"> </textarea>
                </div>

                <div class="form-group">
                    <label for="hotel-city"> City</label>
                    <input name="city" type="text" class="form-control" id="hotel-city" placeholder="Hotel city" v-model="hotel.city">
                </div>
                <div class="form-group">
                    <label for="hotel-state"> State</label>
                    <input name="state" type="text" class="form-control" id="hotel-state" placeholder="Hotel state" v-model="hotel.state">
                </div>
                <div class="form-group">
                    <label for="hotel-country"> Country</label>
                    <input name="country" type="text" class="form-control" id="hotel-country" placeholder="Hotel country" v-model="hotel.country">
                </div>
                <div class="form-group">
                    <label for="hotel-zip-code">Zip code</label>
                    <input name="zip_code" type="text" class="form-control" id="hotel-zip-code" placeholder="Hotel Zip code" v-model="hotel.zip_code">
                </div>
                <div class="form-group">
                    <label for="hotel-phone_number"></label>
                    <input name="phone_number" type="text" class="form-control" id="hotel-phone_number" placeholder="Hotel Phone number" v-model="hotel.phone_number">
                </div>
                <div class="form-group">
                    <label for="hotel-email"></label>
                    <input name="email" type="text" class="form-control" id="hotel-email" placeholder="Hotel email address" v-model="hotel.email">
                </div>
                <div class="form-group">
                    <label for="hotel-image"></label>
                    <input name="image" type="text" class="form-control" id="hotel-image" placeholder="Hotel " v-model="hotel.image">
                </div>

                <button type="submit" class="btn btn-primary">Update hotel details</button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            'hotel': Object
        },
        data() {
            return {

            }
        },
        mounted(){
            this.loadHotelIfEmpty();
        },
        methods: {
            loadHotelIfEmpty() {
                if(!this.hotel) {
                    axios.get(`/api/v1/hotels/${this.$route.params.id}`).then( res => this.hotel = res.data)
                }
            },
            updateHotel(event) {
                event.preventDefault();
                event.stopImmediatePropagation();

                let form = event.target;
                let formData = new FormData(form);

               axios.post(form.getAttribute('action'), formData).then( res => {
                   console.log('hotel updated')
               })
            }
        }
    }
</script>
