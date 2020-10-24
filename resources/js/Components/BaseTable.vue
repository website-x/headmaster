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

    <div class="self-center mt-3">
      <template v-for="link in links">
        <li v-if="link.url != null" :class="['ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150', {'bg-gray-100': link.active }]">
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
