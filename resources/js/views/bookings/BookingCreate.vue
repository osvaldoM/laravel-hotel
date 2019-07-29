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
                <div class="row">
                    <div class="form-group col-6">
                        <label for="start-date">Check-in date</label>
                        <datepicker id="start-date" :disabled-dates = "{ranges: booked_dates}" v-model="booking.start_date" :inline="true"
                                    :highlighted="{from:booking.start_date, to: booking.end_date}" name="start_date" format="yyyy/MM/dd"
                                    :bootstrap-styling=true required calendar-button calendar-button-icon="material-icons"
                                    calendar-button-icon-content="event"></datepicker>
                    </div>
                    <div class="form-group col-6">
                        <label for="end-date">Check-out date</label>
                        <datepicker id="end-date" :disabled-dates = "{ranges: booked_dates, to: minDate, from: maxDate}" v-model="booking.end_date"
                                    :inline =true :highlighted="{from:booking.start_date, to: booking.end_date}" name="end_date"  format="yyyy/MM/dd"
                                    :bootstrap-styling=true required calendar-button calendar-button-icon="material-icons"
                                    calendar-button-icon-content="event"></datepicker>
                    </div>
                </div>

                <p>Number of nights: {{numberOfNights}}</p>
                <p>Total: {{getTotal}} $</p>
                <button type="submit" class="btn btn-primary">Add booking</button>
            </form>
        </div>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import moment from 'moment'
    export default {
        components: {
            Datepicker
        },
        data() {
            return {
                rooms: [],
                room: undefined,
                booking: {},
                booked_dates: []
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

                    if(res.data.id){
                        this.$toasted.global.save_success({entity: 'Booking'});
                        this.$router.push({ name:'bookingDetails', params: {id: res.data.id, booking: res.data }});
                    }
                    else
                        throw new Error('invalid response');
                })
                    .catch((error) => {
                        this.$toasted.global.save_error({entity: 'Booking'});
                    })
            },
            daysBetween: function (start_date, end_date){
                return  Math.abs(moment(start_date).diff(moment(end_date), 'days'));
            },
        },
        watch: {
            'booking.room_id': function (roomId){
                return axios.get(`/api/v1/rooms/${roomId}/room_info`).then(res => {
                    let bookedDates = res.data.booked_dates.map((val) => {
                        return {
                            from : new Date(val.start_date),
                            to: new Date(val.end_date)
                        };
                    });
                    this.booked_dates = bookedDates;
                    this.room = res.data.room_info
                })
            },
            'booking.start_date': function ( start_date){
                if(this.booking.end_date && this.room && this.room.room_type && this.room.room_type.pricing){
                    const minDate =  moment(start_date).add(this.room.room_type.pricing.min_stay_length, 'days');
                    const endDate = moment(this.booking.end_date);
                    const isValidDate = endDate.isAfter(minDate);

                    if(!isValidDate) {
                        this.booking.end_date = minDate.toDate();
                    }
                }
            }
        },
        computed: {
            minDate : function (){
                if(this.booking.start_date && this.room && this.room.room_type && this.room.room_type.pricing){
                    const minDate =  moment(this.booking.start_date).add(this.room.room_type.pricing.min_stay_length, 'days').toDate();
                    return minDate;
                }
            },
            maxDate : function (){
                if(this.booking.start_date && this.room && this.room.room_type && this.room.room_type.pricing){
                    const maxDate =  moment(this.booking.start_date).add(this.room.room_type.pricing.max_stay_length, 'days').toDate();
                    return maxDate;
                }
            },
            numberOfNights: function(){
                if(this.booking.start_date && this.booking.end_date){
                    const diff = this.daysBetween(this.booking.start_date, this.booking.end_date);
                        if(!diff) {
                            return 'same day checkout';
                        }
                    return `${diff} nights`;
                }
            },
            getTotal: function (){
                if(this.room && this.room.room_type && this.room.room_type.pricing){
                    const diff = this.daysBetween(this.booking.start_date, this.booking.end_date);
                    return this.room.room_type.pricing.rack_rate * diff;
                }
            }
        }
    }
</script>
