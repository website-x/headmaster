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
                <jet-label for="client_id" value="Client" />
                <div class="inline-block relative w-64">
                    <model-select
                        :options="options"
                        v-model="form.client_id"
                        placeholder="Search Client">
                    </model-select>
                </div>
                <jet-input-error
                    :message="form.error('client_id')"
                    class="mt-2"
                />
            </div>
            <div class="col-span-6 sm:col-span-4" v-if="$page.user.role =='admin'">
                <jet-label for="office" value="Office" />
                <select
                    v-model="form.office_id"
                    class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                >
                    <option :value="null" selected>Select Office</option>
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
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="amount" value="Amount" />
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div
                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
                    >
                        <span class="text-gray-500 sm:text-sm sm:leading-5">
                            ₹
                        </span>
                    </div>
                    <jet-input
                        id="amount"
                        step="0.01"
                        type="number"
                        class="form-input block w-full pl-7 pr-12 sm:text-sm sm:leading-5"
                        v-model="form.amount"
                        autocomplete="amount"
                        placeholder="5000"
                    />
                </div>
                <jet-input-error :message="form.error('amount')" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="description" value="Description" />

                <multiselect
                    v-model="form.description"
                    :options="descriptions"
                    :searchable="true"
                    :close-on-select="true"
                    :show-labels="true"
                    :taggable="true"
                    @tag="createDescription"
                    :multiple="false"
                    track-by="value"
                    label="value" />

                <jet-input-error
                    :message="form.error('description')"
                    class="mt-2"
                />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="method" value="Method" />

                <multiselect
                    v-model="form.method"
                    :options="methods"
                    :searchable="true"
                    :close-on-select="true"
                    :show-labels="true"
                    :taggable="true"
                    @tag="createMethod"
                    :multiple="false"
                    track-by="value"
                    label="value"
                    placeholder="Payment method" />

                <jet-input
                    class="form-input block w-full pr-12 mt-2 sm:text-sm sm:leading-5"
                    v-model="form.method_remarks"
                    :placeholder="method_remark_helper"
                    v-if="method_remark_helper != null"
                />

                <jet-input-error :message="form.error('method')" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <inertia-link :href="$route('fees.index')" class="mr-4"
                >Cancel</inertia-link
            >

            <jet-button
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Save
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
import JetButton from "@/Jetstream/Button";
import JetFormSection from "@/Jetstream/FormSection";
import JetInput from "@/Jetstream/Input";
import JetDropdown from "@/Jetstream/Dropdown";
import JetInputError from "@/Jetstream/InputError";
import JetLabel from "@/Jetstream/Label";
import JetActionMessage from "@/Jetstream/ActionMessage";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
import { ModelSelect } from "vue-search-select";
import 'vue-multiselect/dist/vue-multiselect.min.css'
const axios = require('axios')

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
        ModelSelect
    },
    mounted() {
        this.filloptions();
    },

    data() {
        return {
            form: this.$inertia.form(
                {
                    _method: "POST",
                    description: null,
                    amount: null,
                    method: null,
                    method_remarks:null,
                    client_id: null,
                    office_id: null
                },
                {
                    bag: "createFees",
                    resetOnSuccess: false
                }
            ),
            options: [],
            methods: this.$page.methods,
            descriptions: this.$page.descriptions,
            method_remark_helper:null
        };
    },

    watch: {
        'form.method': function(newVAL, oldVAL) {
            if (newVAL.value === 'Cash' || newVAL.value === 'Other' ) {
                this.method_remark_helper = null
            } else {
                // to reset the visibilty
                this.method_remark_helper = newVAL.value + ' Reference Number'
            }
        }
    },

    methods: {
        filloptions: function() {
            let newOptionsArray = [];
            let objOptions = this.$page.clients;
            for (let optionItem in objOptions) {
                let new_obj = {};
                new_obj.value = optionItem;
                new_obj.text = objOptions[optionItem];
                newOptionsArray.push(new_obj);
            }
            this.options = newOptionsArray;
        },
        createFeesForm() {
            this.form.post("/fees", {
                preserveScroll: true
            });
        },
        createDescription(search) {
            let vm = this;
            axios.post('/configurations/create/paymentDescription', {
                value: search
            }).then((response) => {
                let desc = response.data
                this.descriptions.push(desc)
                this.form.description=desc
            })
        },
        createMethod(search) {
            let vm = this;
            axios.post('/configurations/create/paymentMethod', {
                value: search
            }).then((response) => {
                let methods = response.data
                this.methods.push(methods)
                this.form.method=methods
            })
        }
    }
};
</script>
