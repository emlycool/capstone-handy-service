<template>
    <nav class="navbar navbar-expand-lg main_menu">
        <div class="container">
            <nuxt-link class="navbar-brand" to="/">
                <img src="/assets/images/custom/logo.jpeg" alt="Handy Service" class="img-fluid w-100">
            </nuxt-link>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="far fa-stream menu_icon_bar"></i>
                <i class="far fa-times close_icon_close"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav m-auto">
                    <li class="nav-item">
                        <nuxt-link to="/" class="nav-link">Home</nuxt-link>
                    </li>
                    <li class="nav-item">
                        <nuxt-link to="/about-us" class="nav-link">About</nuxt-link>
                    </li>
                    <li class="nav-item">
                        <nuxt-link to="/services" class="nav-link">Services</nuxt-link>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact_us.html">contact</a>
                    </li>
                </ul>
                <ul class="right_menu d-flex flex-wrap">
                    <!-- <li>
                        <span class="search">
                            <img src="assets/images/search_icon_white.svg" alt="search" class="img-fluid">
                        </span>
                    </li> -->
                    <li>
                        <nuxt-link to="/auth/login" class="hire_btn common_btn_2" v-if="!isLoggedIn">Login</nuxt-link>
                        <nuxt-link to="/client/account" class="hire_btn common_btn_2" v-else>My Account</nuxt-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

export default {
    data() {
        return {
            
        }
    },

    methods: {
        ...mapActions({})
    },

    computed: {
        ...mapGetters({
            isLoggedIn: 'auth/isLoggedIn'
        })
    }
}
</script>