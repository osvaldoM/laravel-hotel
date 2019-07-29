<template>
    <div>
        <h1> Pricing </h1>
        <hr/>
        <div v-if="pricing" class="room-type-details">

            <form v-bind:method="pricing.id ? 'PUT' : 'POST'" v-bind:action="'/api/v1/pricings/' + (pricing.id || '')" v-on:submit="updatePricing">
                <input v-if="pricing.id" type="hidden" name="id" v-model="pricing.id">
                <input v-if="!pricing.id" type="hidden" name="room_type_id" v-model="room_type_id">
                <input v-if="pricing.id" type="hidden" name="_method" value="PUT">

                <div class="form-group">
                    <label for="rack-rate">Rack rate</label>
                    <input name="rack_rate" required type="number" class="form-control" id="rack-rate" placeholder="Rack rate" v-model="pricing.rack_rate">
                </div>
                <div class="form-group">
                    <label for="min-stay-length">Mininum Length of Stay</label>
                    <input type="number" v-bind:min="1" required name="min_stay_length" class="form-control" id="min-stay-length" placeholder="Mininum Length of Stay"
                           v-model="pricing.min_stay_length">
                </div>
                <div class="form-group">
                    <label for="max-stay-length">Maximum Length of Stay</label>
                    <input type="number"  v-bind:min="1" required name="max_stay_length" class="form-control" id="max-stay-length" placeholder="Maximum Length of Stay"
                           v-model="pricing.max_stay_length">
                </div>
                <div class="form-group">
                    <label for="services">Services</label>
                    <textarea type="text" class="form-control" id="services" placeholder="Services" v-model="pricing.services_included"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Update hotel pricing</button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            'room_type_id': Number
        },
        data(){
            return {
                pricing: {
                }
            }
        },
        mounted(){
            this.loadPricing();
        },
        methods: {
            loadPricing(){
                axios.get(`/api/v1/room_types/${this.room_type_id}/pricing`).then(res => this.pricing = res.data)
            },
            updatePricing(event){
                event.preventDefault();
                event.stopImmediatePropagation();

                let form = event.target;
                let formData = new FormData(form);

                axios.post(form.getAttribute('action'), formData).then(res => {
                    this.$toasted.global.save_success({entity: 'Pricing'});
                })
                    .catch((error) => {
                        this.$toasted.global.save_error({entity: 'Pricing'});
                    })
            }
        }
    }
</script>
