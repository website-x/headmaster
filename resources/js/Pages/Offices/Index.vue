<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                List of Offices
            </h2>


            <a target="_new" :href="$route('exports.offices')"
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
                        :href="$route('offices.create')"
                        class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
                        Add new office
                    </inertia-link>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-3">

                    <base-table class="table-auto text-center"
                                :data="$page.offices.data"
                                :links="$page.offices.links">

                        <template slot="columns">
                            <th class="w-1/3 px-4 py-2">Name</th>
                            <th class="w-2/3 px-4 py-2">Address</th>
                            <th class="w-3/3 px-4 py-2">Contact</th>
                        </template>

                        <template slot-scope="{row}">
                            <td class="border px-4 py-2">
                                {{ row.name }}
                            </td>
                            <td class="border px-4 py-2">
                                <small>
                                    {{ row.address }},<br>
                                    {{ row.city }},<br>
                                    {{ row.state }}
                                </small>
                            </td>
                            <td class="border px-4 py-2">
                                {{ row.phone }}

                                <small v-if="row.email">
                                    <a :href="'mailto:'+row.email">{{ row.email }}</a>
                                </small>
                            </td>
                            <td class="px-4 py-2">
                                <inertia-link :href="$route('offices.edit',row.id)">
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
