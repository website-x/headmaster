<template>
    <div>
        <jet-form-section @submitted="updateOfficeForm">
            <template #title>
                Edit Fees Information
            </template>

            <template #description>
                Edit payment information
            </template>

            <template #form>

                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="description" value="Description" />
                    <jet-input id="description" type="text" class="mt-1 block w-full" v-model="form.description" autocomplete="Description" placeholder="Admission Fees" />
                    <jet-input-error :message="form.error('description')" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="amount" value="Amount" />
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <span class="text-gray-500 sm:text-sm sm:leading-5">
                        ₹
                      </span>
                        </div>
                        <jet-input id="amount" type="number" class="form-input block w-full pl-7 pr-12 sm:text-sm sm:leading-5" v-model="form.amount" autocomplete="amount" placeholder="5000" />
                    </div>
                    <jet-input-error :message="form.error('amount')" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="method" value="Method" />
                    <jet-input id="method" type="text" class="mt-1 block w-full" v-model="form.method" autocomplete="method" placeholder="Cash / Bank Transfer" />
                    <jet-input-error :message="form.error('method')" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="client_id" value="Client" />
                    <div class="inline-block relative w-64">
                        <select
                            v-model="form.client_id"
                            class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                        >
                            <option :value="null" selected>Select Client</option>
                            <option v-for="(client,index) in $page.clients" :value="index">
                                {{ client }}
                            </option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                    <jet-input-error :message="form.error('client_id')" class="mt-2" />
                </div>

            </template>

            <template #actions>

                <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                    Updated
                </jet-action-message>

                <jet-button :class="[{ 'opacity-25': form.processing }, 'mr-3']" :disabled="form.processing">
                    Update
                </jet-button>

                <inertia-link :href="$route('fees.index')" class="mr-3 inline-flex items-center px-4 py-2 bg-white hover:bg-gray-100 text-gray-800 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out border border-gray-300 rounded">Cancel</inertia-link>

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
                Delete Payment
            </template>

            <template #content>
                Are you sure you would like to delete this payment?
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
import JetButton from '@/Jetstream/Button'
import JetFormSection from '@/Jetstream/FormSection'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'
import JetActionMessage from '@/Jetstream/ActionMessage'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
import JetConfirmationModal from '@/Jetstream/ConfirmationModal'
import JetDangerButton from '@/Jetstream/DangerButton'

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
    },

    data() {
        return {
            form: this.$inertia.form({
                '_method': 'PATCH',
                id: this.$page.fees.id,
                description: this.$page.fees.description,
                amount: this.$page.fees.amount,
                method: this.$page.fees.method,
                client_id: this.$page.fees.client_id,
            }, {
                bag: 'updateFees',
                resetOnSuccess: false,
            }),
            deleteApiTokenForm: this.$inertia.form(),
            apiTokenBeingDeleted: null,
        }
    },

    methods: {
        updateOfficeForm() {
            this.form.post('/fees/' + this.$page.fees.id, {
                preserveScroll: true
            })
        },

        confirmApiTokenDeletion() {
            this.apiTokenBeingDeleted = true
        },

        deleteApiToken() {
            this.$inertia.delete('/fees/' + this.$page.fees.id, {
                preserveScroll: true
            }).then(() => window.location = this.$route('fees.index'))
        }
    }
}
</script>
