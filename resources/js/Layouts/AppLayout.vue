<template>
    <div class="font-sans antialiased h-screen">
        <div id="main" class="pt-0">
            <!-- Sidebar -->
            <div class="bg-green-700 h-full min-h-screen">
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
                            Dashboard
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
                            Clients
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
                            Fees
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
                            Offices
                        </jet-nav-link>
                    </div>
                </div>
                <div class="py-2 px-5" v-if="$page.user.role == 'admin'">
                    <div class="group relative sidebar-item with-children">
                        <jet-nav-link
                            href="/users"
                            class="block xl:flex xl:items-center text-center xl:text-left shadow-light xl:shadow-none py-6 xl:py-2 xl:px-4"
                            :active="$page.currentRouteName == 'users.index'">
                            Users
                        </jet-nav-link>
                    </div>
                </div>

                <div class="py-2 px-5" style="position:relative">
                    <div
                        class="hidden sm:flex sm:items-center sm:ml-3"
                        style="position:fixed; bottom:10px;"
                    >
                        <jet-dropdown align="left">
                            <template #trigger>
                                <button
                                    class="flex text-lg border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out"
                                >
                                    <img
                                        class="h-10 w-10 rounded-full object-cover "
                                        :src="$page.user.profile_photo_url"
                                        :alt="$page.user.name"
                                    />
                                </button>
                            </template>

                            <template #content>
                                <!-- Account Management -->
                                <div class="block px-4 py-2 bg-gray-200 text-xs text-gray-400">
                                    Manage Account
                                </div>

                                <jet-dropdown-link href="/user/profile">
                                    Profile
                                </jet-dropdown-link>

                                <div class="border-t border-gray-100"></div>

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
            <!-- Content -->
            <div class="h-full pt-8 bg-gray-100">
                <form class="w-full max-w-sm flex flex-wrap">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 border-b border-teal-500">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                            Search In
                        </label>
                        <select
                            class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                            v-model="searchForms.selectOption">
                            <option value="clients">Clients</option>
                            <option value="offices">Offices</option>
                            <option value="fees">Fees</option>
                            <option value="users">Users</option>
                        </select>
                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 border-b border-teal-500">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                            Search For
                        </label>
                        <input
                            @blur="hideSuggestions"
                            type="textbox"
                            class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                            placeholder="Search"
                            v-on:input="searchData"
                            v-model="searchForms.searchItem"
                        />
                    </div>
                </form>
                <div
                    class="autocomplete mt-2 text-gray-700"
                    v-if="LIST_TOGGLE == true"
                >
                    <ul class="border border-gray-200 rounded-lg p-4 text-center mt-1 ml-1 shadow-lg">
                        <li
                            v-for="(result, i) in LIST_DATA"
                            :key="i"
                            class="border-b border-gray-200">
                            <template v-if="searchForms.selectOption=='clients'">
                                <a :href="$route('clients.edit',result.id)">{{ result.first_name }}</a>
                            </template>
                            <template v-if="searchForms.selectOption=='offices'">
                                <a :href="$route('offices.edit',result.id)">{{ result.name }}</a>
                            </template>
                            <template v-if="searchForms.selectOption=='fees'">
                                <a :href="$route('fees.edit',result.id)">{{ result.description }}</a>
                            </template>
                            <template v-if="searchForms.selectOption=='users'">
                                <a :href="$route('users.edit',result.id)">{{ result.name }}</a>
                            </template>
                        </li>
                    </ul>
                </div>

                <header>
                    <div class="mx-auto py-6 px-4 sm:px-6 lg:px-6 mt-3">
                        Page: <slot name="header"></slot>
                    </div>
                </header>

                <main>
                    <slot></slot>
                </main>

                <portal-target name="modal" multiple> </portal-target>

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
                selectOption: 'clients',
                searchItem: null
            },
            LIST_TOGGLE: false,
            LIST_DATA: []
        };
    },

    methods: {
        hideSuggestions() {
            setTimeout(() => {
                this.LIST_TOGGLE = false;
            }, 500)
        },

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
    grid-template-columns: 14rem auto;
}

.autocomplete {
    position: absolute;
    width: 25%;
    margin: auto auto;
}

.autocomplete > ul {
    height: 120px;
    overflow: auto;
    background-color: #fcfcfc;
}

.autocomplete > ul > li {
    list-style: none;
    padding-top: 8px;
}
</style>
