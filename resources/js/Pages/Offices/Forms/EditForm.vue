<template>
    <div>
        <jet-form-section @submitted="updateOfficeForm">
            <template #title>
                Office Information
            </template>

            <template #description>
                Update office information
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
                    Updated
                </jet-action-message>

                <jet-button :class="[{ 'opacity-25': form.processing }, 'mr-3']" :disabled="form.processing">
                    Update
                </jet-button>

                <inertia-link :href="$route('offices.index')" class="mr-3 inline-flex items-center px-4 py-2 bg-white hover:bg-gray-100 text-gray-800 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out border border-gray-300 rounded">Cancel</inertia-link>

                <button
                        @click="confirmApiTokenDeletion"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 bg-red-500 self-start"
                        :disabled="form.processing"
                        type="button">
                    Delete
                </button>
            </template>
        </jet-form-section>


        <!-- Delete Token Confirmation Modal -->
        <jet-confirmation-modal :show="apiTokenBeingDeleted" @close="apiTokenBeingDeleted = null">
            <template #title>
                Delete Office
            </template>

            <template #content>
                Are you sure you would like to delete this office?
            </template>

            <template #footer>
                <jet-secondary-button @click.native="apiTokenBeingDeleted = null">
                    Nevermind
                </jet-secondary-button>

                <jet-danger-button class="ml-2" @click.native="deleteApiToken" :class="{ 'opacity-25': deleteApiTokenForm.processing }" :disabled="deleteApiTokenForm.processing">
                    Delete
                </jet-danger-button>
            </template>
        </jet-confirmation-modal>
    </div>
</template>

<script>
import JetButton from './../../../Jetstream/Button'
import JetFormSection from './../../../Jetstream/FormSection'
import JetInput from './../../../Jetstream/Input'
import JetInputError from './../../../Jetstream/InputError'
import JetLabel from './../../../Jetstream/Label'
import JetActionMessage from './../../../Jetstream/ActionMessage'
import JetSecondaryButton from './../../../Jetstream/SecondaryButton'
import JetConfirmationModal from '@/Jetstream/ConfirmationModal'
import JetDangerButton from '@/Jetstream/DangerButton'
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
        JetDangerButton,
        JetConfirmationModal,
        'vue-tel-input': VueTelInput
    },

    data() {
        return {
            form: this.$inertia.form({
                '_method': 'PATCH',
                id: this.$page.office.id,
                name: this.$page.office.name,
                address: this.$page.office.address,
                city: this.$page.office.city,
                state: this.$page.office.state,
                country: this.$page.office.country,
                phone: this.$page.office.phone,
                email: this.$page.office.email,
            }, {
                bag: 'updateOffice',
                resetOnSuccess: false,
            }),
            deleteApiTokenForm: this.$inertia.form(),
            apiTokenBeingDeleted: null,
        }
    },

    methods: {
        updateOfficeForm() {
            this.form.post('/offices/' + this.$page.office.id, {
                preserveScroll: true
            })
        },

        confirmApiTokenDeletion() {
            this.apiTokenBeingDeleted = true
        },

        deleteApiToken() {
            this.$inertia.delete('/offices/' + this.$page.office.id, {
                preserveScroll: true
            }).then(() => window.location = this.$route('offices.index'))
        }
    }
}
</script>
