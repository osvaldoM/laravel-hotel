<template>
    <div>
        <h1> Bookings </h1>
        <hr/>
        <div class="bookings" >
            <div class="text-sm-right add-item">
                <router-link :to="{name:'bookingCreate'}" class="btn btn-primary"><span class="oi oi-plus"></span></router-link>
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
                <tr v-for="(booking, index) in bookings">
                    <th scope="row">{{booking.id}}</th>
                    <td>{{booking.customer_email}}</td>
                    <td class="text-sm-right">
                        <router-link :to="{name:'bookingDetails', params: {id: booking.id, booking: booking}}" class="btn btn-secondary"><span class="oi oi-pencil"></span></router-link>
                        <button class="btn btn-danger" v-on:click="confirmBookingDeletion(booking, index)"> <span class="oi oi-delete"></span> </button>
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
                bookings: []
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
            }
        }
    }
</script>
