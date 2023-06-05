<template>
  <div>
    <label> {{label}}</label>
    <div class="loyaltySelect" v-if="options" :class="optionsShown ? 'open' : ''">
      <div class="loyaltyFormGroup" :class="optionsShown ? 'open' : ''">
        <input
          type="search"
          class="formControl"
          :ref="refs"
          :defaultValue="defaultValue"
          :autocomplete="autocomplete"
          @input="getOptions($event)"
          @focus="showOptions($event)"
          @blur="exit()"
          @keydown.up.prevent="onKeyUp"
          @keydown.down.prevent="onKeyDown" @keydown.enter.prevent="onKeyEnter"
          v-model="searchFilter"
          :disabled="disabled"
          :placeholder="placeholder"
          :name="name" />
        <span class="arrow" @click="toggleOptions"></span>
        <!-- <span class="close_" @click="onClose"></span> -->
        <span class="loader_" v-if="isLoading">
          <span class="spinner-border"></span>
        </span>
      </div>

      <div class="wrapper" v-show="optionsShown">
        <ul class="list" :class="isLoading ? 'open' : ''">
          <li v-if="options.length>0" @mousedown="selectOption(option)" v-for="(option, index) in options" :key="index">
            {{option[labelField]}}
          </li>
          <li v-if="options.length===0"> Tidak ditemukan</li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AsyncSelect',
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
    autocomplete: {
      type: String,
      required: false,
      default: 'off'
    },
    multiple: {
      type: String,
      required: false,
      default: false
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
    searchUrl: {
      type: String,
      required: true,
      note: 'Rest API'
    },
    searchVar: {
      type: String,
      required: false,
      default: ''
    },
    refs: {
      type: String,
      required: false,
      note: 'refs to default value'
    },
    defaultValue: {
      type: String,
      required: false,
      note: 'refs to default value'
    },
    defaultData: {
      required: false,
      note: 'refs to default value'
    },
    valueField: {
      type: String,
      required: false,
      default: 'value'
    },
    labelField: {
      type: String,
      required: false,
      default: 'text'
    },
    modelField: {
      type: String,
      required: false
    },
    selectedType: {
      type: String,
      required: false
    }
  },
  data() {
    return {
      selected: null,
      optionsShown: false,
      isLoading: false,
      searchFilter: '',
      isSelected: false,
      isFreeText: true,
      options: []
    }
  },
  computed: {
    _selected() {
      if(this.selected) {

      }
      return {

      }
    }
  },
  created() {
    this.setDefault();
    window.bus.$on('onReset', (val) => {
      this.searchFilter = ''
      this.selected = null
      this.isFreeText = true
    })
  },
  methods: {
    setDefault() {
      this.$nextTick(() => {
        if(!this.isSelected) {
          setTimeout(() => {
            if(typeof this.$refs[this.refs] !== 'undefined') {
              this.searchFilter = this.defaultValue ? this.defaultValue : ''
              this.setSearchFilter();
              console.log('this.$refs[this.refs]', this.searchFilter)
              // console.log('this.defaultData', this.defaultData)
            }
          }, 20)
        }
      })
    },
    onClose(e) {
      e.preventDefault()
      e.stopPropagation()
      console.log(e)
      this.searchFilter = ''
      this.selected = null
      this.isFreeText = true
    },
    setEmit() {
      this.$emit('selected', {
        value: this.selected,
        isfreetext: this.isFreeText,
        model: this.modelField ? this.modelField : null
      });
      this.optionsShown = false
    },
    setSearchFilter() {
      this.selected = this.searchFilter
      this.isSelected = true
      this.isFreeText = true
      this.setEmit();
    },
    selectOption(option) {
      if(this.selectedType==='object') {
        this.selected = option;

      } else {
        this.selected = option[this.valueField];
      }
      this.searchFilter = this.multiple ==='multiple' ? '' : option[this.labelField]
      this.isFreeText = false
      this.setEmit();
      console.log('multiple', this.selected)
    },
    getOptions(e) {
      this.optionsShown = true
      this.isLoading = true
      if(e.target.value) {
        this.isFreeText = true
      }
      axios.post(this.searchUrl,  {
          [this.searchVar]: e.target.value
        })
        .then( response => {
          // this.isSearching = false;
          if(response.data.result == 'OK'){
            console.log('res', response.data.data);
            this.options = response.data.data;
            this.isLoading = false
          }
        })
        .catch( error=> {
          console.log(error);
          this.isLoading = false
        });
    },
    showOptions(e) {
      // e.target.autocomplete = 'off'
      if (!this.disabled) {
        if(this.searchFilter!=='') {
          if(this.isFreeText) {
            this.setSearchFilter();
          }
        } else {
          this.searchFilter = '';
        }
        this.optionsShown = !this.optionsShown;
      }
    },
    toggleOptions() {
      if (!this.disabled) {
        if(this.searchFilter!=='') {
          if(this.isFreeText) {
            this.setSearchFilter();
          }
        } else {
          this.searchFilter = '';
        }
        this.optionsShown = !this.optionsShown;
      }
    },
    exit() {
      if(!this.isLoading) {
        if(this.searchFilter!=='') {
          if(this.isFreeText) {
            this.setSearchFilter();
          }
        } else if (this.selected) {
          if(this.searchFilter===''&&!this.multiple==='multiple') {
            this.selected = null
          }
          this.setDefault();
          // this.searchFilter = '';
        } else {
          this.setDefault();
          this.isSelected = true
        }
        this.optionsShown = false;
        this.setEmit();
        console.log('select', this.selected)
        console.log('free', this.isFreeText)
      }
    }
  },
  watch: {
    selected(val){
      this.setEmit();
    }
  },
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
    &.open .close_ {
      background-image: url("https://image.flaticon.com/icons/svg/748/748122.svg");
      cursor: pointer;
      background-size: 15px;
      background-position: 10px;
      background-repeat: no-repeat;
      position: absolute;
      width: 40px;
      height: 40px;
      top: 0;
      right: 25px;
      z-index: 2;
    }
    .wrapper {
      position: absolute;
      top: 40px;
      right: 0;
      left: 0;
      z-index: 2;
      width: 100%;
      background-color: #f2f2f2;
      border: 1px solid #f2f2f2;
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
