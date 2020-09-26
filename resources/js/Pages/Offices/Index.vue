<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                List of Offices
            </h2>
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
                            <td class="border px-4 py-2">
                                <inertia-link :href="$route('offices.edit',row.id)">
                                    <svg class="inline w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                        <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
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
