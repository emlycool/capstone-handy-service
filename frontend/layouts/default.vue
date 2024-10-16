<template>
    <main>
        <LayoutHeader />
        
        <nuxt />

        <LayoutFooter />


        <LayoutScrollTop />
    </main>
</template>

<script>
import { mapActions } from "vuex";

export default {
    data() {
        return {
            
        }
    },

    async created() {
        await this.initializeAuth()
    },

    methods: {
        ...mapActions({
            initializeAuth: "auth/initializeAuth",
        })
    },

}
</script>