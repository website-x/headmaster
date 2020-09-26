<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Fees
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <edit-form />
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '../../Layouts/AppLayout'
import EditForm from "./Forms/EditForm";

export default {
    components: {
        AppLayout,
        'edit-form': EditForm
    }
}
</script>
