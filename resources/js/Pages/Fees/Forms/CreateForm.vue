<template>
    <jet-form-section @submitted="createFeesForm">
        <template #title>
            Fees Information
        </template>

        <template #description>
            Record new payment of fees
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
                    <jet-input id="amount" step="0.01" type="number" class="form-input block w-full pl-7 pr-12 sm:text-sm sm:leading-5" v-model="form.amount" autocomplete="amount" placeholder="5000" />
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
                Saved.
            </jet-action-message>

            <inertia-link :href="$route('fees.index')" class="mr-4">Cancel</inertia-link>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
import JetButton from '@/Jetstream/Button'
import JetFormSection from '@/Jetstream/FormSection'
import JetInput from '@/Jetstream/Input'
import JetDropdown from '@/Jetstream/Dropdown'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'
import JetActionMessage from '@/Jetstream/ActionMessage'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'

export default {
    components: {
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        JetSecondaryButton,
        JetDropdown,
    },

    data() {
        return {
            form: this.$inertia.form({
                '_method': 'POST',
                description: null,
                amount: null,
                method: null,
                client_id: null,
            }, {
                bag: 'createFees',
                resetOnSuccess: false,
            })
        }
    },

    methods: {
        createFeesForm() {
            this.form.post('/fees', {
                preserveScroll: true
            });
        }
    },
}
</script>
