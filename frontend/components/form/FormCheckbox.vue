<template>
        <div class="custom-control custom-checkbox small">
            <input :id="id ? id : randomId" type="checkbox"  :class="{'is-invalid': hasError}" class="custom-control-input" v-bind="$attrs"  v-on="listeners">

            <label class="custom-control-label" :for="id ? id : randomId">
                <slot></slot>
            </label>
        </div>
</template>

<script>
export default {
    model: {
        prop: 'checked',
        event: 'change'
    },

    props:{
        hasError: Boolean,
        checked: Boolean,
        id: {type: String, default: Math.floor((Math.random() * 99) + 1) + 'rand'} 
    },
    data() {
        return {
            randomId: Math.floor((Math.random() * 99) + 1) + 'rand',       
        }
    },

    computed:{
        listeners(){
            return {
                ...this.$listeners,
                change: event => {
                    this.$emit('change', event.target.checked)
                }
            }
        }
    }
}
</script>