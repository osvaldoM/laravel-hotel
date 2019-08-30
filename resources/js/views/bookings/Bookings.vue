<template>
    <div>
        <h1> Bookings </h1>
        <hr/>
        <div class="bookings" >
            <div class="form-group col-6">
                <label for="end-date">Check-out date</label>
                <datepicker id="end-date" :highlighted="{customPredictor: isBookedDate(bookedDates)}" v-model="date_filter"
                            :inline=true  name="date_filter" format="yyyy/MM/dd"
                            :bootstrap-styling=true required calendar-button calendar-button-icon="material-icons"
                            calendar-button-icon-content="event"></datepicker>
            </div>
            <div class="text-sm-right add-item">
                <router-link :to="{name:'bookingCreate'}" class="btn btn-primary"><i class="material-icons">add</i></router-link>
            </div>
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th>Customer name</th>
                    <th>check in date</th>
                    <th>check out date</th>
                    <th class="text-sm-right">Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(booking, index) in bookings">
                    <th scope="row">{{booking.id}}</th>
                    <td>{{booking.customer_full_name}}</td>
                    <td>{{booking.start_date | formatDate}}</td>
                    <td>{{booking.end_date | formatDate}}</td>
                    <td class="text-sm-right">
                        <router-link :to="{name:'bookingDetails', params: {id: booking.id, booking: booking}}" class="btn btn-secondary"><i class="material-icons">edit</i></router-link>
                        <button class="btn btn-danger" v-on:click="confirmBookingDeletion(booking, index)"> <i class="material-icons">delete</i> </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import moment from 'moment'

    const getBookedDates = (bookings) => {
        return bookings.map((booking) => {
            return {
                from: new Date(booking.start_date),
                to: new Date(booking.end_date)
            };
        });
    };

    const isBookedDate = (bookedDates) => {
        return (date) => {
            return bookedDates.some((bookedDate) => {
                return moment(date).isBetween(bookedDate.from, bookedDate.to, null, '[]');
            });
        };
    };
    export default {
        components: {
            Datepicker
        },
        data() {
            return {
                bookings: [],
                bookedDates: [],
                date_filter: new Date()
            }
        },
        mounted() {
            this.loadBookingTypes();
        },
        methods: {
            loadBookingTypes: function(event) {
                axios.get('/api/v1/bookings')
                    .then( res => {
                        this.bookings = res.data;
                        this.bookedDates = getBookedDates(res.data);
                    })
            },
            confirmBookingDeletion: function (booking, index){
                this.$toasted.show(`Click here to confirm you want to delete booking: ${booking.name}`, {
                    duration: 3000,
                    type: 'info',
                    action : {
                        text : 'delete Booking',
                        onClick : (e, toastObject) => {
                            toastObject.goAway(0);
                            this.deleteBooking(booking, index);
                        }
                    }
                });
            },
            deleteBooking: function (booking, index){
                axios.delete(`api/v1/bookings/${booking.id}`).then( res => {
                    this.$toasted.show('Booking deleted', {
                        duration: 3000,
                        type: 'success'
                    });
                    this.$delete(this.bookings, index);
                }).
                    catch(err => {
                    this.$toasted.show('Failed to delete booking', {
                        duration: 3000,
                        type: 'error'
                    });
                })
            },
            isBookedDate
        }
    }
</script>
