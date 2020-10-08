<template>
    <jet-form-section @submitted="createNewClientForm">
        <template #title>
            Student Information
        </template>

        <template #description>
            Create student / client information
        </template>

        <template #form>
           <div class="col-span-6 sm:col-span-4">
                <jet-label for="first_name" value="First name" />
                <jet-input id="first_name" type="text" class="mt-1 block w-full" v-model="form.first_name" autocomplete="first_name" />
                <jet-input-error :message="form.error('first_name')" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="last_name" value="Last name" />
                <jet-input id="last_name" type="text" class="mt-1 block w-full" v-model="form.last_name" autocomplete="last_name" />
                <jet-input-error :message="form.error('last_name')" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="father_first_name" value="Father's first name" />
                <jet-input id="father_first_name" type="text" class="mt-1 block w-full" v-model="form.father_first_name" autocomplete="father_first_name" />
                <jet-input-error :message="form.error('father_first_name')" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="father_last_name" value="Father's last name" />
                <jet-input id="father_last_name" type="text" class="mt-1 block w-full" v-model="form.father_last_name" autocomplete="father_last_name" />
                <jet-input-error :message="form.error('father_last_name')" class="mt-2" />
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
            
            <template v-if="$page.user.role=='admin' || ($page.user.role=='employee' && $page.user.office_id==null)">
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="office" value="Office" />
                <select
                        v-model="form.office_id"
                        class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                    >
                        <option :value="null" selected>Select Office</option>
                        <option
                            v-for="(office, index) in $page.offices"
                            :value="office.id" :key="index"
                        >
                            {{ office.name }}
                        </option>
                    </select> 
                    <jet-input-error :message="form.error('office_id')" class="mt-2" />
            </div>
            </template>
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <inertia-link :href="$route('clients.index')" class="mr-4">Cancel</inertia-link>

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
                    first_name: null,
                    last_name: null,
                    father_first_name: null,
                    father_last_name: null,
                    address: null,
                    city: null,
                    state: null,
                    country: null,
                    phone: null,
                    office_id: null,
                }, {
                    bag: 'createClient',
                    resetOnSuccess: false,
                })
            }
        },

        methods: {
            createNewClientForm() {
                this.form.post('/clients', {
                    preserveScroll: true
                });
            }
        },
    }
</script>
