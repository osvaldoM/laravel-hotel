<template>
    <div>
        <h1> Booking details </h1>
        <hr/>
        <div v-if="booking" class="booking-details">

            <form method="PUT" v-bind:action="'/api/v1/bookings/' + booking.id" v-on:submit="updateBooking">
                <input type="hidden" name="id" v-model="booking.id">
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <label for="customer-full-name">Customer full name</label>
                    <input required name="customer_full_name" type="text" class="form-control" id="customer-full-name" placeholder="Customer's full name" v-model="booking.customer_full_name">
                </div>
                <div class="form-group">
                    <label for="customer-email">Customer email</label>
                    <input required name="customer_email" type="text" class="form-control" id="customer-email" placeholder="Customer's email" v-model="booking.customer_email">
                </div>

                <div class="form-group">
                    <label for="room"> Room</label>
                    <select required name="room_id" type="text" class="form-control" id="room" placeholder="Room" v-model="booking.room_id">
                        <option v-for="room in rooms" v-bind:value="room.id" v-bind:selected='room.id == booking.room_id'>{{room.name}}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="start-date">Check In date</label>
                    <datepicker :value="(booking.start_date)" id="start-date" name="start_date" :disabled-dates = "{ranges: booked_dates}"
                                format="yyyy/MM/dd" bootstrap-styling=true required calendar-button calendar-button-icon="oi oi-calendar"></datepicker>
                </div>
                <div class="form-group">
                    <label for="end-date">Check Out date</label>
                    <datepicker :value="(booking.end_date)" id="end-date" name="end_date" :disabled-dates = "{ranges: booked_dates}"
                                format="yyyy/MM/dd" bootstrap-styling=true required calendar-button calendar-button-icon="oi oi-calendar"></datepicker>
                </div>


                <button type="submit" class="btn btn-primary">Update booking details</button>
            </form>
        </div>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    export default {
        components: {
            Datepicker
        },
        props: {
            'booking': Object
        },
        data() {
            return {
                rooms: [],
                booked_dates: []
            }
        },
        mounted(){
            this.loadBookingIfEmpty();
            this.loadRooms();
        },
        methods: {
            loadBookingIfEmpty(){
                if(!this.booking)
                    return axios.get(`/api/v1/bookings/${this.$route.params.id}`).then(res => this.booking = res.data)
            },
            loadRooms(){
                return axios.get(`/api/v1/rooms/`).then(res => this.rooms = res.data)
            },
            updateBooking(event){
                event.preventDefault();
                event.stopImmediatePropagation();

                let form = event.target;
                let formData = new FormData(form);

                axios.post(form.getAttribute('action'), formData).then(res => {
                    this.$toasted.show('Booking details updated', {
                        duration: 5000,
                        type: 'success'
                    });
                })
                    .catch((error) => {
                        this.$toasted.show('Error updating Booking');
                    });
            }
        },
        watch: {
            'booking.room_id': function (roomId){
                return axios.get(`/api/v1/rooms/${roomId}/booked_dates`).then(res => {
                    let bookedDates = res.data.map((val) => {
                        return {
                            from : new Date(val.start_date),
                            to: new Date(val.end_date)
                        };
                    });
                    this.booked_dates = bookedDates;
                    console.log(bookedDates);
                })
            }
        }
    }
</script>
