<template>
    <div>
        <table class="table-auto text-center">
            <thead>
            <tr>
                <slot name="columns" :columns="columns">
                    <th v-for="column in columns" :key="column">{{ column }}</th>
                </slot>
            </tr>
            </thead>
            <tbody :class="tbodyClasses">
            <tr v-for="(item, index) in data" :key="index">
                <slot :row="item" :index="index">
                    <td
                        v-for="(column, index) in colsWithValue(item)"
                        :key="index">
                        {{ itemValue(item, column) }}
                    </td>
                </slot>
            </tr>
            </tbody>
        </table>

        <div class="bg-gray-100 self-center">
            <template v-for="link in links">
                <li v-if="link.url != null" :class="{ 'inline-block text-white bg-gray-500 text-center px-4 py-2 m-2': link.active, 'inline-block text-white bg-blue-500 text-center px-4 py-2 m-2': ! link.active  }">
                    <inertia-link :href="link.url">
                        {{ link.label }}
                    </inertia-link>
                </li>
            </template>
        </div>
    </div>
</template>

<script>

export default {
    name: 'base-table',
    props: {
        columns: {
            type: Array,
            default: () => [],
            description: 'Table columns'
        },
        data: {
            type: Array,
            default: () => [],
            description: 'Table data'
        },
        links: {
            type: Array,
            default: () => [],
            description: 'Pagination Links'
        },
        type: {
            type: String, // striped | hover
            default: '',
            description: 'Whether table is striped or hover type'
        },
        theadClasses: {
            type: String,
            default: '',
            description: '<thead> css classes'
        },
        tbodyClasses: {
            type: String,
            default: '',
            description: '<tbody> css classes'
        }
    },
    computed: {
        tableClass() {
            return this.type && `table-${this.type}`;
        },
        colsWithValue() {
            return (row) => {
                return this.columns.filter(column => this.hasValue(row, column))
            }
        }
    },
    methods: {
        hasValue(item, column) {
            return item[column.toLowerCase()] !== 'undefined';
        },
        itemValue(item, column) {
            return item[column.toLowerCase()];
        }
    }
}
</script>
