<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                List of Users
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="mb-4">
                    <inertia-link
                        :href="$route('users.create')"
                        class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
                        Add new user
                    </inertia-link>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-3">

                    <base-table class="table-auto text-center"
                                :data="$page.users.data"
                                :links="$page.users.links">

                        <template slot="columns">
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Office</th>
                            <th class="px-4 py-2">Role</th>
                        </template>

                        <template slot-scope="{row}">
                            <td class="border px-4 py-2">
                                {{ row.name }} <br>
                                <small class="small">({{ row.email }})</small>
                            </td>
                            <td class="border px-4 py-2">
                                {{ row.office_name }}
                            </td>
                            <td class="border px-4 py-2">
                                <svg class="inline w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                {{ row.role }}
                            </td>
                            <td class="px-4 py-2">
                                <inertia-link :href="$route('users.edit',row.id)">
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
