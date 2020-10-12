<template>
    <div>
        <jet-form-section @submitted="updateClientForm">
            <template #title>
                Student Information
            </template>

            <template #description>
                Update student / client information
            </template>

            <template #form>
                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="first_name" value="First name" />
                    <jet-input
                        id="first_name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.first_name"
                        autocomplete="first_name"
                    />
                    <jet-input-error
                        :message="form.error('first_name')"
                        class="mt-2"
                    />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="last_name" value="Last name" />
                    <jet-input
                        id="last_name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.last_name"
                        autocomplete="last_name"
                    />
                    <jet-input-error
                        :message="form.error('last_name')"
                        class="mt-2"
                    />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <jet-label
                        for="father_first_name"
                        value="Father's first name"
                    />
                    <jet-input
                        id="father_first_name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.father_first_name"
                        autocomplete="father_first_name"
                    />
                    <jet-input-error
                        :message="form.error('father_first_name')"
                        class="mt-2"
                    />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <jet-label
                        for="father_last_name"
                        value="Father's last name"
                    />
                    <jet-input
                        id="father_last_name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.father_last_name"
                        autocomplete="father_last_name"
                    />
                    <jet-input-error
                        :message="form.error('father_last_name')"
                        class="mt-2"
                    />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="address" value="Address" />
                    <jet-input
                        id="address"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.address"
                        autocomplete="address"
                    />
                    <jet-input-error
                        :message="form.error('address')"
                        class="mt-2"
                    />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="Country" value="Country" />
                    <country-select
                        v-model="form.country"
                        className="form-input rounded-md shadow-sm mt-1 block w-full"
                        :country="form.country"
                        topCountry="IN"
                    />
                    <jet-input-error
                        :message="form.error('country')"
                        class="mt-2"
                    />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="State" value="State" />
                    <region-select v-model="form.state" className="form-input rounded-md shadow-sm mt-1 block w-full" :country="form.country" :region="form.state" />
                    <jet-input-error
                        :message="form.error('state')"
                        class="mt-2"
                    />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="city" value="City" />
                    <jet-input
                        id="city"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.city"
                        autocomplete="city"
                    />
                    <jet-input-error
                        :message="form.error('city')"
                        class="mt-2"
                    />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="phone" value="Phone" />
                    <vue-tel-input v-model="form.phone" />
                    <jet-input-error
                        :message="form.error('phone')"
                        class="mt-2"
                    />
                </div>

                <template
                    v-if="
                        $page.user.role == 'admin' ||
                            ($page.user.role == 'employee' &&
                                $page.user.office_id == null)
                    "
                >
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="office" value="Office" />
                        <select
                            v-model="form.office_id"
                            class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                        >
                            <option :value="null"
                                >Select Office</option
                            >
                            <option
                                v-for="(office, index) in $page.offices"
                                :value="office.id"
                                :key="index"
                            >
                                {{ office.name }}
                            </option>
                        </select>
                        <jet-input-error
                            :message="form.error('office_id')"
                            class="mt-2"
                        />
                    </div>
                </template>
            </template>

            <template #actions>
                <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                    Updated
                </jet-action-message>

                <jet-button
                    :class="[{ 'opacity-25': form.processing }, 'mr-3']"
                    :disabled="form.processing"
                >
                    Update
                </jet-button>

                <inertia-link
                    :href="$route('clients.index')"
                    class="mr-3 inline-flex items-center px-4 py-2 bg-white hover:bg-gray-100 text-gray-800 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out border border-gray-300 rounded"
                    >Cancel</inertia-link
                >

                <button
                    @click="confirmApiTokenDeletion"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 bg-red-500 self-start"
                    :disabled="form.processing"
                    type="button"
                >
                    Delete
                </button>
            </template>
        </jet-form-section>

        <div class="md:grid md:grid-cols-3 md:gap-6 mt-5">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium text-gray-900">
                        Payments
                    </h3>

                    <p class="mt-1 text-sm text-gray-600">
                        Payments history
                    </p>
                </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <table class="table-fixed">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Description</th>
                                    <th class="px-4 py-2">Amount</th>
                                    <th class="px-4 py-2">When</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="payment in $page.client.payments">
                                    <td class="border px-4 py-2">
                                        <p v-if="payment.description">
                                            {{ payment.description }}
                                        </p>
                                        <p v-else class="font-semibold">N/A</p>
                                        <small v-if="payment.method"
                                            ><br />({{ payment.method }})</small
                                        >
                                    </td>
                                    <td class="border px-4 py-2">
                                        ₹{{ payment.amount }}
                                    </td>
                                    <td class="border px-4 py-2">
                                        {{ payment.last_updated_at }}
                                    </td>
                                    <td
                                        class="border px-4 py-2 grid-cols-2 gap-x-4"
                                    >
                                        <inertia-link
                                            :href="
                                                $route('fees.edit', payment.id)
                                            "
                                        >
                                            <svg
                                                class="inline w-4 h-4"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                            >
                                                <path
                                                    d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"
                                                />
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        </inertia-link>

                                        <a
                                            :href="
                                                $route(
                                                    'invoice.show',
                                                    payment.id
                                                )
                                            "
                                            target="_new"
                                        >
                                            <svg
                                                class="inline w-4 h-4"
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"
                                                />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!--Action-->
                    <div
                        class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6"
                    >
                        <p class="mr-5">
                            <small>Total Payments: </small>
                            {{ $page.client.total_payments }}
                        </p>
                        <inertia-link
                            :href="$route('fees.create')"
                            class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow"
                        >
                            Add Payment
                        </inertia-link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <jet-confirmation-modal
            :show="apiTokenBeingDeleted"
            @close="apiTokenBeingDeleted = null"
        >
            <template #title>
                Delete Client
            </template>

            <template #content>
                Are you sure you would like to delete this client?
            </template>

            <template #footer>
                <jet-secondary-button
                    @click.native="apiTokenBeingDeleted = null"
                >
                    Nevermind
                </jet-secondary-button>

                <jet-danger-button
                    class="ml-2"
                    @click.native="deleteApiToken"
                    :class="{ 'opacity-25': deleteApiTokenForm.processing }"
                    :disabled="deleteApiTokenForm.processing"
                >
                    Delete
                </jet-danger-button>
            </template>
        </jet-confirmation-modal>
    </div>
</template>

<script>
import JetButton from "./../../../Jetstream/Button";
import JetFormSection from "./../../../Jetstream/FormSection";
import JetInput from "./../../../Jetstream/Input";
import JetInputError from "./../../../Jetstream/InputError";
import JetLabel from "./../../../Jetstream/Label";
import JetActionMessage from "./../../../Jetstream/ActionMessage";
import JetSecondaryButton from "./../../../Jetstream/SecondaryButton";
import JetConfirmationModal from "@/Jetstream/ConfirmationModal";
import JetDangerButton from "@/Jetstream/DangerButton";
import { VueTelInput } from "vue-tel-input";

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
        "vue-tel-input": VueTelInput
    },

    data() {
        return {
            form: this.$inertia.form(
                {
                    _method: "PATCH",
                    first_name: this.$page.client.first_name,
                    last_name: this.$page.client.last_name,
                    father_first_name: this.$page.client.father_first_name,
                    father_last_name: this.$page.client.father_last_name,
                    address: this.$page.client.address,
                    city: this.$page.client.city,
                    state: this.$page.client.state,
                    country: this.$page.client.country,
                    phone: this.$page.client.phone,
                    office_id:this.$page.client.office_id
                },
                {
                    bag: "updateClient",
                    resetOnSuccess: false
                }
            ),
            deleteApiTokenForm: this.$inertia.form(),
            apiTokenBeingDeleted: null
        };
    },

    methods: {
        updateClientForm() {
            this.form.post("/clients/" + this.$page.client.id, {
                preserveScroll: true
            });
        },

        confirmApiTokenDeletion() {
            this.apiTokenBeingDeleted = true;
        },

        deleteApiToken() {
            this.deleteApiTokenForm
                .delete("/clients/" + this.$page.client.id, {
                    preserveScroll: true
                })
                .then(() => (window.location = this.$route("clients.index")));
        }
    }
};
</script>
