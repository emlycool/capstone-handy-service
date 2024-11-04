<template>
    <div class="dashboard_sidebar">
        <div class="dashboard_sidebar_user">
            <div class="img">
                <img
                    :src="authUser.provider.business_logo.url"
                    alt="dashboard"
                    class="img-fluid w-100"
                />
            </div>
            <h3>
                {{ `${authUser.provider.business_name}` }}
            </h3>
            <p>Provider</p>
        </div>
        <div class="dashboard_sidebar_menu">
            <ul>
                <li>
                    <nuxt-link to="/provider/account/">
                        <i class="fas fa-user"></i>
                        Business Info
                    </nuxt-link>
                </li>
                <li>
                    <nuxt-link to="/client/account/my-service-requests">
                        <i class="fas fa-shopping-basket"></i> Client
                        Requests
                    </nuxt-link>
                </li>
                <li>
                    <nuxt-link to="/client/account/reviews">
                        <i class="fas fa-star"></i> Services
                    </nuxt-link>
                </li>
                <li>
                    <nuxt-link to="/client/account/change-password">
                        <i class="fas fa-user"></i> Personal Info
                    </nuxt-link>
                </li>

                <li>
                    <nuxt-link to="/client/account/change-password">
                        <i class="fas fa-key"></i> Change Password
                    </nuxt-link>
                </li>
                <li>
                    <a class="cursor-pointer" @click.prevent="logout"
                        ><i class="fas fa-sign-out-alt"></i> Logout</a
                    >
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
    data() {
        return {};
    },

    computed: {
        ...mapGetters({
            authUser: "auth/authUser",
        }),
    },

    methods: {
        ...mapActions({
            authLogout: "auth/logout",
        }),

        async logout() {
            try {
                await this.authLogout();
                this.$message({
                    type: "success",
                    message: "Logged out successfully",
                });
                this.$router.push("/");
            } catch (e) {
                console.log(e);
            }
        },
    },
};
</script>