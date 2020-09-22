<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                List of Offices
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-3">

                    <base-table class="table-auto text-center"
                                :data="$page.offices.data"
                                :links="$page.offices.links">

                        <template slot="columns">
                            <th class="w-1/3 px-4 py-2">Name</th>
                            <th class="w-2/3 px-4 py-2">City</th>
                            <th class="w-3/3 px-4 py-2">Contact</th>
                        </template>

                        <template slot-scope="{row}">
                            <td class="border px-4 py-2">
                                {{ row.name }}
                            </td>
                            <td class="border px-4 py-2">
                                {{ row.city }}
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
