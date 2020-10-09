<template>
    <div class="font-sans antialiased h-screen">
        <!-- Top Navigation -->
        <header
            class="h-16 w-full bg-grey-darker shadow flex items-center justify-between"
        >
            <div class="flex items-center h-full">
                <div class="flex items-center text-center h-full w-48 pl-6">
                    <a href="/dashboard">
                        <jet-application-mark class="block h-9 w-auto" />
                    </a>
                </div>
            </div>
            <div class="flex items-center h-full text-sm ">
                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <div class="mr-3 relative">
                        <jet-dropdown align="right" width="48">
                            <template #trigger>
                                <button
                                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out"
                                >
                                    <img
                                        class="h-8 w-8 rounded-full object-cover"
                                        :src="$page.user.profile_photo_url"
                                        :alt="$page.user.name"
                                    />
                                </button>
                            </template>

                            <template #content>
                                <!-- Account Management -->
                                <div
                                    class="block px-4 py-2 text-xs text-gray-400"
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
                                        v-if="$page.jetstream.canCreateTeams"
                                    >
                                        Create New Team
                                    </jet-dropdown-link>

                                    <div class="border-t border-gray-100"></div>

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
                                            @submit.prevent="switchToTeam(team)"
                                        >
                                            <jet-dropdown-link as="button">
                                                <div class="flex items-center">
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
                                                    <div>{{ team.name }}</div>
                                                </div>
                                            </jet-dropdown-link>
                                        </form>
                                    </template>

                                    <div class="border-t border-gray-100"></div>
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
        </header>

        <div id="main" class="pt-1">
            <!-- Sidebar -->
            <div
                class="bg-grey-darkest relative h-full min-h-screen border-r border-grey-dark"
            >
            
                <div class="py-2 px-5 ">
                    <div class="group relative sidebar-item with-children">
                        <jet-nav-link
                            href="/dashboard"
                            :active="$page.currentRouteName == 'dashboard'"
                            class="block xl:flex xl:items-center text-center xl:text-left shadow-light xl:shadow-none py-6 xl:py-2 xl:px-4"
                        >
                            <div class="text-black text-sm">
                                Dashboard
                            </div>
                        </jet-nav-link>
                    </div>
                </div>
                <div class="py-2 px-5 ">
                    <div class="group relative sidebar-item with-children">
                        <jet-nav-link href="/clients" class="block xl:flex xl:items-center text-center xl:text-left shadow-light xl:shadow-none py-6 xl:py-2 xl:px-4" :active="$page.currentRouteName == 'clients.index'">
                            <div class="text-black text-sm">
                                Clients
                            </div>
                        </jet-nav-link>
                    </div>
                </div>
                <div class="py-2 px-5 ">
                    <div class="group relative sidebar-item with-children">
                        <jet-nav-link href="/fees" class="block xl:flex xl:items-center text-center xl:text-left shadow-light xl:shadow-none py-6 xl:py-2 xl:px-4" :active="$page.currentRouteName == 'fees.index'">
                            <div class="text-black text-sm">
                                Fees
                            </div>
                        </jet-nav-link>
                    </div>
                </div>
                <div class="py-2 px-5 ">
                    <div class="group relative sidebar-item with-children">
                        <jet-nav-link href="/offices" class="block xl:flex xl:items-center text-center xl:text-left shadow-light xl:shadow-none py-6 xl:py-2 xl:px-4" :active="$page.currentRouteName == 'offices.index'">
                            <div class="text-black text-sm">
                                Offices
                            </div>
                        </jet-nav-link>
                    </div>
                </div>
                <div class="py-2 px-5"  v-if="$page.user.role=='admin'">
                    <div class="group relative sidebar-item with-children">
                        <jet-nav-link href="/users" class="block xl:flex xl:items-center text-center xl:text-left shadow-light xl:shadow-none py-6 xl:py-2 xl:px-4" :active="$page.currentRouteName == 'users.index'">
                            <div class="text-black text-sm">
                                Users
                            </div>
                        </jet-nav-link>
                    </div>
                </div>
            </div>
            <!-- Content -->
            <div class="bg-white h-full pt-8">
                <div class="text-center w-full text-grey-darkest">
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
            showingNavigationDropdown: false
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
</style>
