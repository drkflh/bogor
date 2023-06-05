<template>
  <div>
    <label>{{label}}</label>
    <div class="loyaltySelect" v-if="options" :class="optionsShown ? 'open' : ''">
      <div class="loyaltyFormGroup" :class="optionsShown ? 'open' : ''">
        <input
          type="search"
          class="formControl"
          :ref="refs"
          :defaultValue="defaultValue"
          :autocomplete="autocomplete"
          @focus="showOptions($event)"
          @blur="exit()"
          v-model="searchFilter"
          :disabled="disabled"
          :placeholder="placeholder"
          :name="name" />
        <span class="arrow" @click="toggleOptions"></span>
      </div>

      <div class="wrapper" v-show="optionsShown">
        <ul class="list">
          <li v-for="(option, index) in filteredOptions" :key="index" @mousedown="selectOption(option)" :class="option.value===(typeof selected.value !=='undefined'?selected.value:'') ? 'active' : ''"> {{ option.text || option.value || '-' }} </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AsyncSimpleSelect',
  model: {
    prop: 'value',
    event: 'input'
  },
  props: {
    name: {
      type: String,
      required: false,
      default: 'dropdown',
      note: 'Input name'
    },
      selector: {
          type: String,
          required: false,
          default: 'selector',
          note: 'Input name'
      },
    autocomplete: {
      type: String,
      required: false,
      default: 'off'
    },
    label: {
      type: String,
      required: false,
      default: '',
      note: 'Label of input'
    },
    placeholder: {
      type: String,
      required: false,
      default: 'Please select an option',
      note: 'Placeholder of dropdown'
    },
    disabled: {
      type: Boolean,
      required: false,
      default: false,
      note: 'Disable the dropdown'
    },
    searchVar: {
      type: String,
      required: false,
    },
    refs: {
      type: String,
      required: false,
      note: 'refs to default value'
    },
    defaultValue: {
      type: String,
      required: false,
      default: '',
      note: 'refs to default value'
    },
    defaultData: {
      required: false,
      note: 'refs to default value'
    },
    options: {
      required: true,
      type: Array,
      default: function() {
        return []
      }
    },
    outField: {
        type: String,
        default: 'value'
    },
  },
  data() {
    return {
      selected: {},
      optionsShown: false,
      searchFilter: ''
    }
  },
  created() {
    this.setDefault();
    window.bus.$on('onReset', (val) => {
      this.searchFilter = ''
      this.selected = {}
    })
  },
  methods: {
    setDefault() {
      this.$nextTick(() => {
        setTimeout(() => {
          if(typeof this.$refs[this.refs] !== 'undefined') {
            this.searchFilter = this.defaultValue ? this.defaultValue : ''
            console.log('this.searchFilter ', this.searchFilter )
            if(this.options.length) {
              const filtered = this.options.filter(item => item.text === this.defaultValue)
              // console.log('filtered', filtered)
              if(filtered.length>0) {
                this.selected = {
                  ...filtered[0],
                  text: filtered[0].text,
                  value: filtered[0].value
                }
              }
            }
          }
        }, 20)
      })
    },
    selectOption(option) {
      this.selected = option;
      this.searchFilter = this.selected.text ? this.selected.text : '';
      if (!this.selected.value) {
        this.setDefault();
        this.selected = {};
        this.searchFilter = '';
      }
      this.optionsShown = false
        this.$emit('selected', {
            value:this.selected,
            selector:this.selector
        });
    },
    showOptions(e){
      // e.target.autocomplete = 'off'
      if (!this.disabled) {
        this.searchFilter = '';
        this.optionsShown = true;
      }
      this.$emit('focus', true)
    },
    toggleOptions() {
      if (!this.disabled) {
        this.searchFilter = '';
        this.optionsShown = !this.optionsShown;
      }
      this.$emit('focus', true)
    },
    exit() {
      if (!this.selected.text) {
        this.searchFilter = this.defaultValue
        this.selected = {};
        console.log('set default')
      } else {
        this.searchFilter = this.selected.text;
        // this.$emit('onSelected', this.selected);
      }
      this.optionsShown = false
    },
    // Selecting when pressing Enter
    keyMonitor(event) {
      if (event.key === "Enter" && this.filteredOptions[0])
        this.selectOption(this.filteredOptions[0]);
    }
  },
  computed: {
    filteredOptions() {
      //const filtered = [];
      // const regOption = new RegExp(this.searchFilter, 'ig');
      // for (const option of this.options) {
      //   if (this.searchFilter.length < 1 || option.text.match(regOption)){
      //     if (filtered.length < this.maxItem) filtered.push(option);
      //   }
      // }
      if(this.options.length) {
        const filtered = this.options.filter(item => {
          return item.text.toLowerCase().indexOf(this.searchFilter.toLowerCase()) >= 0
        })
        return filtered;
      }
    }
  },
  watch: {
    selected(val) {
      // this.$emit('input', val)
      this.$emit('selected', {
          value:val,
          selector:this.selector
      });
    }
  }
}
</script>

<style lang="scss">
.loyalty {
  &Select {
    position: relative;
    .formControl {
      width: 100%;
      min-height: 40px;
      text-align: left;
      color: #35495e;
      padding: 0 10px;
      border-radius: 5px;
      border: 1px solid #e8e8e8;
    }
    .arrow {
      position: absolute;
      top: 30px;
    }
    .arrow::after {
      background-image: url("data:image/svg+xml,%3Csvg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M16.5 10H7.5L12 15L16.5 10Z' fill='%236D757E' stroke='%236D757E' stroke-width='2' stroke-linejoin='round'/%3E%3C/svg%3E%0A");
      content: '';
      background-size: contain;
      background-repeat: no-repeat;
      width: 22px;
      height: 22px;
      position: absolute;
      top: -20px;
      right: 5px;
    }
    &.open .arrow::after {
      background-image: url("data:image/svg+xml,%3Csvg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M16.5 10H7.5L12 15L16.5 10Z' fill='%236D757E' stroke='%236D757E' stroke-width='2' stroke-linejoin='round'/%3E%3C/svg%3E%0A");
      content: '';
      background-size: contain;
      background-repeat: no-repeat;
      width: 22px;
      height: 22px;
      position: absolute;
      top: -20px;
      right: 5px;
      transform: rotate(180deg);
    }
    &.open .loader_ {
      position: absolute;
      width: 40px;
      height: 40px;
      top: 5px;
      right: 20px;
      z-index: 2;
    }
    // &.open .close_ {
    //   background-image: url("https://image.flaticon.com/icons/svg/748/748122.svg");
    //   cursor: pointer;
    //   background-size: 15px;
    //   background-position: 10px;
    //   background-repeat: no-repeat;
    //   position: absolute;
    //   width: 40px;
    //   height: 40px;
    //   top: 35px;
    //   right: 25px;
    //   z-index: 2;
    // }
    .wrapper {
      position: absolute;
      top: 40px;
      right: 0;
      left: 0;
      z-index: 3;
      width: 100%;
      background-color: #f2f2f2;
      ul {
        position: relative;
        list-style: none;
        padding: 0;
        margin: 0;
        max-height: 250px;
        overflow: auto;
        li {
          line-height: 2;
          padding: 10px 20px;
          cursor: pointer;
          border-bottom: 1px solid #e5eff7;
          &:hover {
            background-color: #ccc;
          }
          &.active {
            background-color: #e6eff7;
          }
        }
        &.open::after {
          content: '';
          overflow: hidden;
          position: absolute;
          top: 0;
          bottom: 0;
          right: 0;
          left: 0;
          z-index: 3;
          background-color: rgba(255, 255, 255, 0.6);
        }
      }
    }
    .alert {
      position: absolute;
      background-color: #9e4d5c;
      font-size: 12px;
      background: #ffeef1;
      border-left: 3px solid #9e4d5c;
      color: #9e4d5c;
      padding: 5px;
      z-index: 1;
    }
  }
}
</style>
