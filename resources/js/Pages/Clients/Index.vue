<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                List of Clients
            </h2>

            <a target="_new" :href="$route('exports.clients')"
               v-if="$page.user.is_admin"
               class="float-right bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 border border-blue-700 rounded">
                <svg class="inline w-5 h-5"
                     xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Export
            </a>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="mb-4">
                    <inertia-link
                        :href="$route('clients.create')"
                        class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
                        Add new client
                    </inertia-link>
                </div>

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
                                <small v-if="row.state"><br>{{ row.state }}</small>
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
                            <td class="px-4 py-2">
                                <inertia-link :href="$route('clients.edit',row.id)">
                                    <svg class="inline w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </inertia-link>
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
