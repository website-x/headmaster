<template>
    <div>
        <div
            class="shadow-xl gap-5 p-6 sm:px-20 px-4 py-2 bg-white border border-gray-200 "
        >
            <!--<div>
                <jet-application-logo class="block h-12 w-auto" />
            </div>-->

            <div class="mt-8 text-2xl">
                Welcome
            </div>

            <!-- <div class="mt-6 text-gray-500">
                If you're an employee with us, Please abide by all the rules
                that set out in the onboarding form.
            </div> -->
            <br />
        </div>

        <div
            class="p-6 shadow-xl gap-5  sm:px-20 px-4 py-2 bg-white border-b border-gray-200 mt-2 "
        >
            <p class="text-2xl text-center">Offices</p>

            <base-table
                class="table-auto text-center"
                :data="$page.office_data.data"
                :links="$page.office_data.links"
                :filters="dateFilter"
            >
                <template slot="columns">
                    <th class="w-1/3 px-4 py-2">Office Name</th>
                    <th class="w-2/3 px-4 py-2">Today</th>
                    <th class="w-3/3 px-4 py-2">Total</th>
                </template>

                <template slot-scope="{ row }">
                    <td class="border px-4 py-2">
                        {{ row.name }}
                    </td>
                    <td class="border px-4 py-2">
                        &#8377;{{ row.today_amount }}
                    </td>
                    <td class="border px-4 py-2">
                        &#8377;{{ row.total_amount }}
                    </td>
                </template>
            </base-table>
        </div>
        <div
            class="p-6 shadow-xl sm:px-20 bg-white border-b border-gray-200  px-4 py-2 mt-2"
        >
            <a v-on:click="calenderOpen"><svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    class="inline w-4 h-4 float-left"
                   
                >
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

            <h1 class="text-2xl text-center">
                Invoices

                <a
                    target="_new"
                    :href="$route('generate.invoice', 'pdf')"
                    class=" float-right "
                >
                    <svg
                        class="inline w-4 h-4"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"
                        />
                    </svg>
                </a>
                <a
                    target="_new"
                    :href="$route('generate.invoice', 'csv')"
                    class=" float-right "
                >
                    <svg
                        class="inline mr-5 w-4 h-4"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"
                        />
                    </svg>
                </a>
            </h1>

            <base-table
                class="table-auto text-center"
                :data="rowfilter"
                :links="$page.fees_data.links"
            >
                <template slot="columns">
                    <th class="w-1/3 px-4 py-2">Number</th>
                    <th class="w-2/3 px-4 py-2">Date</th>
                    <th class="w-3/3 px-4 py-2">Name</th>
                    <th class="w-3/3 px-4 py-2">Amount</th>
                </template>

                <template slot-scope="{ row }">
                    <td class="border px-4 py-2">
                        {{ row.id }}
                    </td>
                    <td class="border px-4 py-2">
                        {{ row.last_created_at }}
                    </td>
                    <td class="border px-4 py-2">
                        {{ row.client.full_name }}
                    </td>
                    <td class="border px-4 py-2">&#8377;{{ row.amount }}</td>
                    <td class="border px-4 py-2 grid-cols-2 gap-x-4">
                        <a :href="$route('invoice.show', row.id)" target="_new">
                            <svg
                                class="inline w-4 h-4"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"
                                />
                            </svg>
                        </a>
                    </td>
                </template>
            </base-table>
        </div>
        <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-1">
            <div class="p-6">
                <div class="flex items-center">
                    <svg
                        fill="none"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                        class="w-8 h-8 text-gray-400"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                        />
                    </svg>
                    <div
                        class="ml-4 text-lg text-gray-600 leading-7 font-semibold"
                    >
                        ({{ $page.clients_count }}) Clients
                    </div>
                </div>

                <div class="ml-12">
                    <inertia-link :href="$route('clients.index')">
                        <div
                            class="mt-3 flex items-center text-sm font-semibold text-indigo-700"
                        >
                            <div>View more details</div>

                            <div class="ml-1 text-indigo-500">
                                <svg
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    class="arrow-right w-4 h-4"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    ></path>
                                </svg>
                            </div>
                        </div>
                    </inertia-link>
                </div>
            </div>

            <div class="p-6 border-t border-gray-200">
                <div class="flex items-center">
                    <svg
                        fill="none"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                        class="w-8 h-8 text-gray-400"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                            />
                        </svg>
                    </svg>
                    <div
                        class="ml-4 text-lg text-gray-600 leading-7 font-semibold"
                    >
                        ({{ $page.offices_count }}) Offices
                    </div>
                </div>

                <div class="ml-12">
                    <inertia-link :href="$route('offices.index')">
                        <div
                            class="mt-3 flex items-center text-sm font-semibold text-indigo-700"
                        >
                            <div>View more details</div>

                            <div class="ml-1 text-indigo-500">
                                <svg
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    class="arrow-right w-4 h-4"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    ></path>
                                </svg>
                            </div>
                        </div>
                    </inertia-link>
                </div>
            </div>

            <div class="p-6 border-t border-gray-200">
                <div class="flex items-center">
                    <svg
                        fill="none"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                        class="w-8 h-8 text-gray-400"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"
                        />
                    </svg>
                    <div
                        class="ml-4 text-lg text-gray-600 leading-7 font-semibold"
                    >
                        ({{ $page.employees_count }}) Employees
                    </div>
                </div>

                <div class="ml-12">
                    <inertia-link :href="$route('users.index')">
                        <div
                            class="mt-3 flex items-center text-sm font-semibold text-indigo-700"
                        >
                            <div>View more details</div>

                            <div class="ml-1 text-indigo-500">
                                <svg
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    class="arrow-right w-4 h-4"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    ></path>
                                </svg>
                            </div>
                        </div>
                    </inertia-link>
                </div>
            </div>

            <!--<div class="p-6 border-t border-gray-200 md:border-l">
                <div class="flex items-center">
                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                        (45) Clients
                    </div>
                </div>

                <div class="ml-12">
                    <inertia-link :href="$route('clients.index')">
                        <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                            <div>View more details</div>

                            <div class="ml-1 text-indigo-500">
                                <svg viewBox="0 0 20 20" fill="currentColor" class="arrow-right w-4 h-4">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    </inertia-link>
                </div>
            </div>-->
        </div>
    </div>
</template>
<script>
import JetApplicationLogo from "./../Jetstream/ApplicationLogo";
import AppLayout from "../Layouts/AppLayout";
import BaseTable from "../Components/BaseTable";

export default {
    data() {
        return {
            dateFilterShow: "",
            dateFilter: ""
        };
    },
    components: {
        JetApplicationLogo,
        "base-table": BaseTable,
        AppLayout
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
