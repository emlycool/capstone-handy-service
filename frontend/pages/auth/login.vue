<template>
    <div>
        <LayoutMiniBanner breadcrumb="Login">
            <ul class="d-flex flex-wrap">
                <li><nuxt-link to="/">Home</nuxt-link></li>
                <li><nuxt-link to="/auth/login">Login</nuxt-link></li>
            </ul>
        </LayoutMiniBanner>

        <!--=============================
        SIGN IN START
        ==============================-->
        <section class="login_area pt_120 xs_pt_100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <form id="login-form" @submit.prevent="loginSubmit">
                            <div class="row">
                                <FormGroup
                                    class="form-group mb-3"
                                    :validation-bag="[
                                        {
                                            condition: !$v.login.email.required,
                                            message: 'Email is required',
                                        },
                                    ]"
                                >
                                    <FormInput
                                        v-model="$v.login.email.$model"
                                        :has-error="$v.login.email.$error"
                                        type="email"
                                        name="email"
                                        placeholder="Email"
                                        autocomplete="email"
                                    />
                                </FormGroup>

                                <FormGroup
                                    class="form-group mb-3"
                                    :validation-bag="[
                                        {
                                            condition:
                                                !$v.login.password.required,
                                            message: 'Password is required',
                                        },
                                    ]"
                                >
                                    <FormInput
                                        v-model="$v.login.password.$model"
                                        :has-error="$v.login.password.$error"
                                        type="password"
                                        name="password"
                                        placeholder="Password"
                                        autocomplete="password"
                                    />
                                </FormGroup>
                            </div>

                            <div
                                class="single_input d-flex flex-wrap align-items-center justify-content-end"
                            >
                                <nuxt-link to="/auth/forgot-password" class="forget_password mb-2">
                                    Forgot password
                                </nuxt-link>
                            </div>
                            <button class="common_btn form-control mb-3" type="submit">
                                Login
                            </button>
                            <p>Don’t you have an account? <nuxt-link to="/auth/register">Register</nuxt-link></p>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>


<script>
import { email, required } from "vuelidate/lib/validators";
import { load } from "recaptcha-v3";
import { mapActions } from "vuex";
import ValidationMixinVue from '@/mixins/ValidationMixin.vue';

export default {
    mixins: [ValidationMixinVue],

    data() {
        return {
            login: {
                email: "",
                password: "",
            },
            sendingRequest: false
        };
    },

    methods: {
        ...mapActions({
            handleLogin: "auth/login",
        }),

        validateForm() {
            let isValid = false;
            this.$v.login.$touch();
            isValid = !this.$v.login.$invalid;
            if (isValid) {
                return true;
            }
            return false;
        },

        async recaptcha() {
            const recaptcha = await load(process.env.recaptchaKeys);
            const token = await recaptcha.execute("login");
            return token;
        },

        async loginSubmit() {
            if (!this.validateForm() || this.sendingRequest) return;

            this.sendingRequest = true;

            try {
                // const recaptchaToken = await this.recaptcha();

                const response = await this.handleLogin({
                    ...this.login,
                });
                console.log(response);
                

                if (response.data.data.auth.token) {
                    this.$message({
                        type: "success",
                        message: "Login successfully",
                    });

                    this.resetForm();

                    // this.$router.push(
                    //     this.$route.query.redirect || { name: "account" }
                    // );
                    let redirectUrl = this.$route.query.redirect;
                    const user = response.data.data.user
                    let dashboad = user.roles.includes("service_provider") && !user.roles.includes("admin") ? 
                    "/provider/account": "/client/account"
                    // After login, check if there is a redirect URL in the query
                    const redirect = redirectUrl || dashboad;
                    
                    // Redirect the user to the provided URL or default to home
                    this.$router.push(redirect);
                }
            } catch (error) {
                // eslint-disable-next-line no-console
                // this.toastError(error);
                
            } finally {
                this.sendingRequest = false;
            }
        },

        resetForm() {
            this.login = {
                email: "",
                password: "",
            };
            this.$v.$reset();
        },
    },

    validations: {
        login: {
            email: { required, email },
            password: { required },
        },
    },
};
</script>