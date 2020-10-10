<template>
    <div class="font-sans antialiased h-screen">
        <div id="main" class="pt-0">
            <!-- Sidebar -->
            <div
                class="bg-gray-500 relative h-full min-h-screen border-r border-grey-dark "
            >
                <div class="py-2 px-5 mt-2">
                    <div class="flex items-center text-center h-full w-48 pl-6">
                        <a href="/dashboard">
                            <jet-application-mark class="block h-9 w-auto" />
                        </a>
                    </div>
                </div>
                <div class="py-2 px-5 ">
                    <div class="group relative sidebar-item with-children">
                        <jet-nav-link
                            href="/dashboard"
                            :active="$page.currentRouteName == 'dashboard'"
                            class="block xl:flex xl:items-center text-center xl:text-left shadow-light xl:shadow-none py-6 xl:py-2 xl:px-4 "
                        >
                            <div class="text-white text-lg ">
                                Dashboard
                            </div>
                        </jet-nav-link>
                    </div>
                </div>
                <div class="py-2 px-5 ">
                    <div class="group relative sidebar-item with-children">
                        <jet-nav-link
                            href="/clients"
                            class="block xl:flex xl:items-center text-center xl:text-left shadow-light xl:shadow-none py-6 xl:py-2 xl:px-4"
                            :active="$page.currentRouteName == 'clients.index'"
                        >
                            <div class="text-white text-lg">
                                Clients
                            </div>
                        </jet-nav-link>
                    </div>
                </div>
                <div class="py-2 px-5 ">
                    <div class="group relative sidebar-item with-children">
                        <jet-nav-link
                            href="/fees"
                            class="block xl:flex xl:items-center text-center xl:text-left shadow-light xl:shadow-none py-6 xl:py-2 xl:px-4"
                            :active="$page.currentRouteName == 'fees.index'"
                        >
                            <div class="text-white text-lg">
                                Fees
                            </div>
                        </jet-nav-link>
                    </div>
                </div>
                <div class="py-2 px-5 ">
                    <div class="group relative sidebar-item with-children">
                        <jet-nav-link
                            href="/offices"
                            class="block xl:flex xl:items-center text-center xl:text-left shadow-light xl:shadow-none py-6 xl:py-2 xl:px-4"
                            :active="$page.currentRouteName == 'offices.index'"
                        >
                            <div class="text-white text-lg">
                                Offices
                            </div>
                        </jet-nav-link>
                    </div>
                </div>
                <div class="py-2 px-5" v-if="$page.user.role == 'admin'">
                    <div class="group relative sidebar-item with-children">
                        <jet-nav-link
                            href="/users"
                            class="block xl:flex xl:items-center text-center xl:text-left shadow-light xl:shadow-none py-6 xl:py-2 xl:px-4"
                            :active="$page.currentRouteName == 'users.index'"
                        >
                            <div class="text-white text-lg">
                                Users
                            </div>
                        </jet-nav-link>
                    </div>
                </div>

                <div class="py-2 px-5" style="position:relative">
                    <div
                        class="hidden sm:flex sm:items-center sm:ml-3"
                        style="position:fixed; bottom:10px;"
                    >
                   
                        <div>
                            <jet-dropdown align="" width="48">
                                <template #trigger>
                                    <button
                                        class="flex text-lg border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out"
                                    >
                                        <img
                                            class="h-8 w-8 rounded-full object-cover "
                                            :src="$page.user.profile_photo_url"
                                            :alt="$page.user.name"
                                        />
                                    </button>
                                </template>

                                <template #content>
                                    <!-- Account Management -->
                                    <div
                                        class="block px-4 py-2 bg-gray-200 text-xs text-gray-400"
                                    >
                                        Manage Account
                                    </div>

                                    <jet-dropdown-link href="/user/profile">
                                        Profile
                                    </jet-dropdown-link>

                                    <jet-dropdown-link
                                        href="/user/api-tokens"
                                        v-if="$page.jetstream.hasApiFeatures"
                                    >
                                        API Tokens
                                    </jet-dropdown-link>

                                    <div class="border-t border-gray-100"></div>

                                    <!-- Team Management -->
                                    <template
                                        v-if="$page.jetstream.hasTeamFeatures"
                                    >
                                        <div
                                            class="block px-4 py-2 text-xs text-gray-400"
                                        >
                                            Manage Team
                                        </div>

                                        <!-- Team Settings -->
                                        <jet-dropdown-link
                                            :href="
                                                '/teams/' +
                                                    $page.user.current_team.id
                                            "
                                        >
                                            Team Settings
                                        </jet-dropdown-link>

                                        <jet-dropdown-link
                                            href="/teams/create"
                                            v-if="
                                                $page.jetstream.canCreateTeams
                                            "
                                        >
                                            Create New Team
                                        </jet-dropdown-link>

                                        <div
                                            class="border-t border-gray-100"
                                        ></div>

                                        <!-- Team Switcher -->
                                        <div
                                            class="block px-4 py-2 text-xs text-gray-400"
                                        >
                                            Switch Teams
                                        </div>

                                        <template
                                            v-for="team in $page.user.all_teams"
                                        >
                                            <form
                                                @submit.prevent="
                                                    switchToTeam(team)
                                                "
                                            >
                                                <jet-dropdown-link as="button">
                                                    <div
                                                        class="flex items-center"
                                                    >
                                                        <svg
                                                            v-if="
                                                                team.id ==
                                                                    $page.user
                                                                        .current_team_id
                                                            "
                                                            class="mr-2 h-5 w-5 text-green-400"
                                                            fill="none"
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            stroke="currentColor"
                                                            viewBox="0 0 24 24"
                                                        >
                                                            <path
                                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                                            ></path>
                                                        </svg>
                                                        <div>
                                                            {{ team.name }}
                                                        </div>
                                                    </div>
                                                </jet-dropdown-link>
                                            </form>
                                        </template>

                                        <div
                                            class="border-t border-gray-100"
                                        ></div>
                                    </template>

                                    <!-- Authentication -->
                                    <form @submit.prevent="logout">
                                        <jet-dropdown-link as="button">
                                            Logout
                                        </jet-dropdown-link>
                                    </form>
                                </template>
                            </jet-dropdown>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Content -->
            <div class="bg-white h-full pt-8">
                <div class="text-center w-full text-grey-darkest">
                    <div class="inline relative">
                        <div id="select-box" class="inline-block">
                            <select
                                class="bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                v-model="searchForms.selectOption"
                            >
                                <option :value="null">-Select-</option>
                                <option value="clients">Clients</option>
                                <option value="offices">Offices</option>
                                <option value="fees">Fees</option>
                                 <option value="users">Users</option>
                            </select>
                        </div>
                        <div id="text-box" class="inline-block">
                            <input
                                type="textbox"
                                class=" border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                placeholder="Search here"
                                v-on:input="searchData"
                                v-model="searchForms.searchItem"
                            />
                            <div
                                class="autocomplete"
                                v-if="LIST_TOGGLE == true"
                            >
                                <ul class="autocomplete-results">
                                    <li
                                        v-for="(result, i) in LIST_DATA"
                                        :key="i"
                                        class="autocomplete-result "
                                    >
                                    <template v-if="searchForms.selectOption=='clients'">
                                       <a :href="$route('clients.edit',result.id)" class="cursor-pointer">{{ result.first_name }}</a>
                                    </template>
                                    <template v-if="searchForms.selectOption=='offices'">
                                         <a :href="$route('offices.edit',result.id)" class="cursor-pointer">{{ result.name }}</a>
                                    </template>
                                    <template v-if="searchForms.selectOption=='fees'">
                                         <a :href="$route('fees.edit',result.id)" class="cursor-pointer">{{ result.description }}</a>
                                    </template>
                                     <template v-if="searchForms.selectOption=='users'">
                                         <a :href="$route('users.edit',result.id)" class="cursor-pointer">{{ result.name }}</a>
                                    </template>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <header class="bg-white shadow">
                        <div
                            class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8"
                        >
                            <slot name="header"></slot>
                        </div>
                    </header>
                    <!-- Page Content -->
                    <main>
                        <slot></slot>
                    </main>

                    <!-- Modal Portal -->
                    <portal-target name="modal" multiple> </portal-target>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import JetApplicationLogo from "./../Jetstream/ApplicationLogo";
import JetApplicationMark from "./../Jetstream/ApplicationMark";
import JetDropdown from "./../Jetstream/Dropdown";
import JetDropdownLink from "./../Jetstream/DropdownLink";
import JetNavLink from "./../Jetstream/NavLink";
import JetResponsiveNavLink from "./../Jetstream/ResponsiveNavLink";

export default {
    components: {
        JetApplicationLogo,
        JetApplicationMark,
        JetDropdown,
        JetDropdownLink,
        JetNavLink,
        JetResponsiveNavLink
    },

    data() {
        return {
            showingNavigationDropdown: false,
            searchForms: {
                selectOption: null,
                searchItem: null
            },
            LIST_TOGGLE: false,
            LIST_DATA: []
        };
    },

    methods: {
        switchToTeam(team) {
            this.$inertia.put(
                "/current-team",
                {
                    team_id: team.id
                },
                {
                    preserveState: false
                }
            );
        },
        logout() {
            axios.post("/logout").then(response => {
                window.location = "/";
            });
        },
        searchData() {
            if (this.searchForms.selectOption === null) {
                alert("please select option");
            } else {
                this.LIST_TOGGLE=false;
                axios.post("/searchdata", this.searchForms).then(response => {
                    this.LIST_DATA = response.data;
                    if (response.data.length > 0) {
                        this.LIST_TOGGLE = true;
                    }
                });
            }
        }
    },

    computed: {
        path() {
            return window.location.pathname;
        }
    }
};
</script>
<style scoped>
#main {
    display: grid;
    grid-template-columns: 10rem auto;
}
.autocomplete {
    position: absolute;
    width: 80%;
}

.autocomplete-results {
    padding: 0;
    margin: 0;
    border: 1px solid #eeeeee;
    height: 120px;
    overflow: auto;
    background-color: #E5E7EB;
}

.autocomplete-result {
    list-style: none;
    text-align: left;
    padding: 4px 2px;
    border-bottom: 1px solid black;
   
}

.autocomplete-result:hover {
    color: black;
}
</style>
