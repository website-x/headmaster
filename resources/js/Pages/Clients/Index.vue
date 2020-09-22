<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                List of Clients
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-3">

                    <base-table class="table-auto text-center"
                                :data="$page.clients.data"
                                :links="$page.clients.links">

                        <template slot="columns">
                            <th class="w-1/6 px-4 py-2">
                                Student Name
                                <br>
                                <small class="font-weight-300">Parent Name</small>
                            </th>
                            <th class="w-2/6 px-4 py-2">Payments</th>
                            <th class="w-3/6 px-4 py-2">City</th>
                            <th class="w-4/6 px-4 py-2">Office</th>
                            <th class="w-5/6 px-4 py-2">Added By</th>
                            <th class="w-6/6 px-4 py-2">Contact</th>
                        </template>

                        <template slot-scope="{row}">
                            <td class="border px-4 py-2">
                                {{ row.full_name }}
                                <br>
                                <small>
                                    {{ row.father_full_name }}
                                </small>
                            </td>
                            <td class="border px-4 py-2">
                                {{ row.total_payments }}
                            </td>
                            <td class="border px-4 py-2">
                                {{ row.city }}
                            </td>
                            <td class="border px-4 py-2">
                                {{ row.office.name }}
                            </td>
                            <td class="border px-4 py-2">
                                {{ row.created_by.name }}
                            </td>
                            <td class="border px-4 py-2">
                                {{ row.phone }}
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
