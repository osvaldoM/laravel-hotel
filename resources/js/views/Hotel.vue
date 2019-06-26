<template>
    <div>
        <div class="hotels" v-for="hotel in hotels">
            {{hotel.name}}
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
