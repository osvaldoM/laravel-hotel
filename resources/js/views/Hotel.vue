<template>
    <div>
        <h1> Hotels </h1>
        <hr/>
        <div class="hotels" v-for="hotel in hotels">
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Hotel Name</th>
                    <th scope="col">City</th>
                    <th scope="col">State</th>
                    <th scope="col">Country</th>
                    <th scope="col">Zip code</th>
                    <th scope="col">Email address</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">{{hotel.id}}</th>
                    <td>{{hotel.name}}</td>
                    <td>{{hotel.city}}</td>
                    <td>{{hotel.state}}</td>
                    <td>{{hotel.country}}</td>
                    <td>{{hotel.zip_code}}</td>
                    <td>{{hotel.email}}</td>
                    <td>
                        <router-link :to="{name:'hotelDetails', params: {id: hotel.id, hotel: hotel}}" class="btn btn-secondary"><span class="oi oi-pencil"></span></router-link>
                        <button class="btn btn-danger"> <span class="oi oi-delete"></span> </button>
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
                hotels: []
            }
        },
        mounted() {
            this.loadHotels();
        },
        methods: {
            loadHotels: function(event) {
                axios.get('/api/v1/hotels')
                    .then( res => {
                        this.hotels = res.data;
                })
            }
        }
    }
</script>
