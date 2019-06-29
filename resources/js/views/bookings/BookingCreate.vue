<template>
    <div>
        <h1> New Booking </h1>
        <hr/>
        <div class="booking-details">

            <form method="POST" v-bind:action="'/api/v1/bookings/'" v-on:submit="createBooking">
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
                    <datepicker id="start-date" name="start_date" format="yyyy/MM/dd" bootstrap-styling=true required calendar-button calendar-button-icon="oi oi-calendar"></datepicker>
                </div>
                <div class="form-group">
                    <label for="end-date">Check Out date</label>
                    <datepicker id="end-date" name="end_date"  format="yyyy/MM/dd" bootstrap-styling=true required calendar-button calendar-button-icon="oi oi-calendar"></datepicker>
                </div>


                <button type="submit" class="btn btn-primary">Add booking</button>
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
        data() {
            return {
                rooms: [],
                booking: {}
            }
        },
        mounted(){
            this.loadRooms();
        },
        methods: {
            loadRooms(){
                return axios.get(`/api/v1/rooms/`).then(res => this.rooms = res.data)
            },
            createBooking(event){
                event.preventDefault();
                event.stopImmediatePropagation();

                let form = event.target;
                let formData = new FormData(form);

                axios.post(form.getAttribute('action'), formData).then(res => {

                    if(res.id){
                        this.$toasted.show('Booking created', {
                            duration: 3000,
                            type: 'success'
                        });
                        this.$router.push({ name:'bookingDetails', params: {id: res.data.id, booking: res.data }});
                    }
                    else
                        throw new Error('invalid response');
                })
                    .catch((error) => {
                        this.$toasted.show('Error updating Booking' + error.message);
                    })
            }
        }
    }
</script>
