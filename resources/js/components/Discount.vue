<template>
  <div>
    <input
      type="text"
      id="discountCode" 
      class="form-control px-1" 
      placeholder="Enter Discount Code"
      :value="modelValue"
      @input="emitValue"
    >
  </div>    
</template>

<script>
    export default {        
        props: {
          modelValue: String, 
        },
        emits: ['update:modelValue'],        

        methods: {
            emitValue (e) {
              let value = e.target.value
              this.$emit('update:modelValue', value)
            },
        }
    }
</script>
