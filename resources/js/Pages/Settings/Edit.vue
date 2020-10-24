<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Update Site Configuration
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div>
                    <jet-form-section @submitted="update">
                        <template #title>
                            Update
                        </template>

                        <template #description>
                            Update configuration
                        </template>

                        <template #form>
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="key" value="Key" />
                                <jet-input
                                    id="key"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.key"
                                    autocomplete="Key" readonly="true" />

                                <jet-input-error
                                    :message="form.error('key')"
                                    class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="value" value="value" />
                                <jet-input
                                    id="value"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.value"
                                    autocomplete="Value" />

                                <jet-input-error
                                    :message="form.error('key')"
                                    class="mt-2" />
                            </div>

                        </template>

                        <template #actions>


                            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                                Updated
                            </jet-action-message>

                            <jet-button
                                :class="[{ 'opacity-25': form.processing }, 'mr-3']"
                                :disabled="form.processing">
                                Update
                            </jet-button>

                            <inertia-link
                                :href="$route('settings.index')"
                                class="mr-3 inline-flex items-center px-4 py-2 bg-white hover:bg-gray-100 text-gray-800 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out border border-gray-300 rounded">
                                Cancel
                            </inertia-link>

                        </template>
                    </jet-form-section>

                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '../../Layouts/AppLayout'
import JetButton from "@/Jetstream/Button";
import JetFormSection from "@/Jetstream/FormSection";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetLabel from "@/Jetstream/Label";
import JetActionMessage from "@/Jetstream/ActionMessage";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";

export default {
    components: {
        AppLayout,
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        JetSecondaryButton
    },
    data() {
        return {
            form: this.$inertia.form(
                {
                    _method: "PATCH",
                    key: this.$page.setting.key,
                    value: this.$page.setting.value,
                },
                {
                    bag: "updateSettings",
                    resetOnSuccess: false
                }
            )
        };
    },
    methods: {
        update() {
            this.form.post(route('settings.update',this.$page.setting.key) , {
                preserveScroll: true
            });
        },
    }
}
</script>
