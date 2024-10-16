<template>
    <div class="form-group" >
        <label v-if="label" :for="labelFor">
            {{label}}
        </label>
        <slot>
            
        </slot>
        <slot name="validation" :errors="errors">
            <span 
             v-for="(error, i) in errors"
             :key="i"
             class="invalid-feedback"
             >
                {{error.message}}
            </span>
        </slot>
    </div>
</template>

<script>
export default {
    props:{
        label: String,
        labelFor: String,
        validationBag: Array
    },
    computed: {
        errors(){
            if(!this.validationBag) return []
            return this.validationBag.filter(({condition}) => condition)
        }
    }
}
</script>