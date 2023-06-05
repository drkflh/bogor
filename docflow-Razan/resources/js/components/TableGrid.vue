<template>
  <div class="card-columns" >
    <template v-for="row in rows">
      <div class="card">
        <div class="card-body">
          <div>
            <img src="https://www.nobleui.com/html/template/assets/images/placeholder.jpg" class="card-img-top" alt="" />
            <div v-for="column in columns">
                <slot :row="row" :column="column" name="column">
                  {{ column }}
                </slot>
                <slot :row="row" :column="column" name="row">
                  {{ row }}
                </slot>
            </div>
          </div>
          <!-- <h5 class="card-title">Card title</h5>
          <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p> -->
          <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
        </div>
      </div>
    </template>

  </div>
</template>

<script>
export default {
  name: 'TableGrid',
  props: {
    rows: {
      type: Array,
      default: function() {
        return []
      }
    },
    columns: {
      type: Array,
      default: function() {
        return []
      }
    },
    totalRecords: {
      type: Number
    },
    paginationOptions: {
      type: Object,
      default: function() {
        return {}
      }
    }
  },
  data() {
    return {
    }
  },
  created() {
    console.log('rows', this.rows)
    console.log('columns', this.columns)
    console.log('totalRecords', this.totalRecords)
    console.log('paginationOptions', this.paginationOptions)
  },
  computed: {},
  methods: {
    hasValue (row, column) {
      return row[column.field] !== 'undefined'
    },
    itemValue (row, column) {
      if(row[column.field] !== 'undefined' && !row[column._id]) {
        return row
      }
    }
  }
}
</script>

<style lang="scss">
.loyalty {
    position: relative;
}
</style>
