<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Site configurations
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-3">
                    <base-table
                        class="table-auto text-center"
                        :data="$page.settings.data"
                        :links="$page.settings.links"
                    >
                        <template slot="columns">
                            <th class="px-4 py-2">Key</th>
                            <th class="px-4 py-2">Value</th>
                        </template>

                        <template slot-scope="{ row }">
                            <td class="border px-4 py-2">
                                {{ row.readable_key }}
                            </td>

                            <td class="border px-4 py-2">
                                {{ row.value }}
                            </td>

                            <td class="px-4 py-2 grid-cols-2 gap-x-4 inline-flex">
                                <div v-if="$page.user.is_admin">
                                    <inertia-link :href="$route('settings.edit', row.key)">
                                        <svg class="inline w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </inertia-link>
                                </div>
                            </td>
                        </template>
                    </base-table>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout";
import BaseTable from "../../Components/BaseTable";

export default {
    components: {
        "base-table": BaseTable,
        AppLayout
    }
};
</script>
