<template>
    <div>

        <inertia-link
            :href="$route('fees.create')"
            class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow"
        >
            Add Payment
        </inertia-link>

        <br>

        <div class="mt-5 p-6 shadow-xl gap-5 sm:px-20 px-4 py-2 bg-white border-b border-gray-200 rounded-lg">
            <p class="text-2xl text-center">Offices</p>
            <br>
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

        <!-- Invoices Card-->
        <div class="p-6 shadow-xl sm:px-20 bg-white border-b border-gray-200 px-4 py-2 mt-5 rounded-lg">
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

            <h1 class="text-2xl text-center">
                Invoices
                <a
                    target="_new"
                    :href="$route('generate.invoice', 'pdf')"
                    class=" float-right "
                >
                    <svg
                        class="inline w-5 h-5"
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
                        class="inline mr-5 w-5 h-5"
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
                    <th class="w-1/5 px-4 py-2">#</th>
                    <th class="w-2/5 px-4 py-2">Date</th>
                    <th class="w-3/5 px-4 py-2">Name</th>
                    <th class="w-4/5 px-4 py-2">Amount</th>
                    <th class="w-5/5 px-4 py-2">Collected By</th>
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
                        {{ row.collected_by.name }}
                        <br>
                        <small v-if="row.collected_by.office_name != null"> ({{ row.collected_by.office_name }})</small>
                    </td>
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
