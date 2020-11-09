<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                List of Fees collections
            </h2>

            <a target="_new" :href="$route('exports.fees')"
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
                        :href="$route('fees.create')"
                        class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
                        Add Payment
                    </inertia-link>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-3">
                    <a v-on:click="calenderOpen">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            class="inline w-8 h-8 float-left">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                            />
                        </svg>
                    </a>
                    <datetime
                        v-model="dateFilter"
                        type="date"
                        input-style="width:1px;"
                        format="dd-LLL-yyyy"
                        input-id="calender_date"
                    ></datetime>


                    <base-table
                        class="table-auto text-center"
                        :data="rowfilter"
                        :links="$page.fees_data.links"
                    >
                        <template slot="columns">
                            <th class="px-4 py-2">Id</th>
                            <th class="px-4 py-2">Date</th>
                            <th class="px-4 py-2">Client name</th>
                            <th class="px-4 py-2">
                                Amount
                                <br />
                                <small>Payment Method</small>
                            </th>
                            <th class="px-4 py-2">Description</th>
                            <th class="px-4 py-2">Collected By</th>
                            <th class="px-4 py-2">Office name</th>
                        </template>

                        <template slot-scope="{ row, user }">
                            <td class="border px-4 py-2">
                                {{ row.id }}
                            </td>

                            <td class="border px-4 py-2">
                                {{ row.last_updated_at }}
                            </td>

                            <td class="border px-4 py-2">
                                <inertia-link :href="$route('clients.edit', row.client.id)" class="text-blue-700">
                                    {{ row.client.full_name }}
                                </inertia-link>
                            </td>

                            <td class="border px-4 py-2">
                                ₹{{ row.amount }}
                                <br />
                                <small>
                                    {{ row.method }}
                                </small>
                                <small v-if="row.method_remarks != null">
                                    {{ row.method_remarks }}
                                </small>
                            </td>

                            <td class="border px-4 py-2">
                                <p v-if="row.description">
                                    {{ row.description }}
                                </p>
                                <p v-else class="font-semibold">N/A</p>
                            </td>

                            <td class="border px-4 py-2">
                                {{ row.collected_by.name }}
                            </td>

                            <td class="border px-4 py-2">
                                <p v-if="row.office">
                                    {{ row.office.name }}
                                </p>
                                <p v-else class="font-semibold">N/A</p>
                            </td>

                            <td class="px-4 py-2 grid-cols-2 gap-x-4 inline-flex">
                                <div v-if="$page.user.is_admin">
                                    <inertia-link :href="$route('fees.edit', row.id)">
                                        <svg class="inline w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </inertia-link>
                                </div>

                                <a :href="$route('invoice.show', row.id)" target="_new">
                                    <svg class="inline w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                    </svg>
                                </a>
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
    },

    data() {
        return {
            dateFilterShow: "",
            dateFilter: ""
        };
    },
    computed: {
        rowfilter: function() {
            //console.log(this.dateFilter)
            return this.$page.fees_data.data.filter(row => {
                return row.last_created_at.match(this.dateFilter);
            });
        }
    },
    methods:{
        calenderOpen(){
            document.getElementById('calender_date').focus();
        }
    },
    watch: {
        dateFilter: function() {
            if (this.dateFilter != "") {
                var d = new Date(this.dateFilter);
                let month = d.toLocaleString("default", { month: "short" });
                let year = d.toLocaleString("default", { year: "numeric" });
                let day = d.toLocaleString("default", { day: "numeric" });
                if (day.length < 2) {
                    day = "0" + day;
                }
                let final_date = day + "-" + month + "-" + year;
                this.dateFilter = final_date;
            }
        }
    }
};
</script>
