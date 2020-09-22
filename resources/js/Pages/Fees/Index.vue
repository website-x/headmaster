<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                List of Fees collections
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-3">

                    <base-table class="table-auto text-center"
                                :data="$page.fees.data"
                                :links="$page.fees.links">

                        <template slot="columns">
                            <th class="w-1/5 px-4 py-2">
                                Description
                            </th>
                            <th class="w-2/5 px-4 py-2">
                                Amount
                                <br>
                                <small>Payment Method</small>
                            </th>
                            <th class="w-3/5 px-4 py-2">Client</th>
                            <th class="w-4/5 px-4 py-2">Collected By</th>
                            <th class="w-5/5 px-4 py-2">When</th>
                        </template>

                        <template slot-scope="{row}">
                            <td class="border px-4 py-2">
                                {{ row.description }}
                            </td>
                            <td class="border px-4 py-2">
                                ₹{{ row.amount }}
                                <br>
                                <small>
                                    {{ row.method }}
                                </small>
                            </td>

                            <td class="border px-4 py-2">
                                {{ row.client.full_name }}
                            </td>
                            <td class="border px-4 py-2">
                                {{ row.collected_by.name }}
                            </td>
                            <td class="border px-4 py-2">
                                {{ row.created_at }}
                            </td>
                        </template>
                    </base-table>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '../../Layouts/AppLayout'
    import BaseTable from "../../Components/BaseTable";

    export default {
        components: {
           'base-table': BaseTable, AppLayout
        }
    }
</script>
