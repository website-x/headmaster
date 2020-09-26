<template>
    <jet-form-section @submitted="createOfficeForm">
        <template #title>
            Office Information
        </template>

        <template #description>
            Create new office
        </template>

        <template #form>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Name" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="office name" />
                <jet-input-error :message="form.error('name')" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="address" value="Address" />
                <jet-input id="address" type="text" class="mt-1 block w-full" v-model="form.address" autocomplete="address" />
                <jet-input-error :message="form.error('address')" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="Country" value="Country" />
                <country-select v-model="form.country" className="form-input rounded-md shadow-sm mt-1 block w-full" :country="form.country" topCountry="IN" />
                <jet-input-error :message="form.error('country')" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="State" value="State" />
                <region-select v-model="form.state" className="form-input rounded-md shadow-sm mt-1 block w-full" :country="form.country" :region="form.state" />
                <jet-input-error :message="form.error('state')" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="city" value="City" />
                <jet-input id="city" type="text" class="mt-1 block w-full" v-model="form.city" autocomplete="city" />
                <jet-input-error :message="form.error('city')" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="phone" value="Phone" />
                <vue-tel-input v-model="form.phone" />
                <jet-input-error :message="form.error('phone')" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" autocomplete="email" />
                <jet-input-error :message="form.error('email')" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <inertia-link :href="$route('offices.index')" class="mr-4">Cancel</inertia-link>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
    import JetButton from './../../../Jetstream/Button'
    import JetFormSection from './../../../Jetstream/FormSection'
    import JetInput from './../../../Jetstream/Input'
    import JetInputError from './../../../Jetstream/InputError'
    import JetLabel from './../../../Jetstream/Label'
    import JetActionMessage from './../../../Jetstream/ActionMessage'
    import JetSecondaryButton from './../../../Jetstream/SecondaryButton'
    import { VueTelInput } from 'vue-tel-input'

    export default {
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
            'vue-tel-input': VueTelInput
        },

        data() {
            return {
                form: this.$inertia.form({
                    '_method': 'POST',
                    name: null,
                    address: null,
                    city: null,
                    state: null,
                    country: null,
                    phone: null,
                    email: null,
                }, {
                    bag: 'createOffice',
                    resetOnSuccess: false,
                })
            }
        },

        methods: {
            createOfficeForm() {
                this.form.post('/offices', {
                    preserveScroll: true
                });
            }
        },
    }
</script>
