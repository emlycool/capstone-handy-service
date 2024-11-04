<template>
    <div>
        <LayoutMiniBanner breadcrumb="Forgot Password">
            <ul class="d-flex flex-wrap">
                <li><nuxt-link to="/">Home</nuxt-link></li>
                <li>
                    <nuxt-link to="/auth/forgot-password"
                        >Forgot Password</nuxt-link
                    >
                </li>
            </ul>
        </LayoutMiniBanner>

        <!--=============================
        FORGOT PASSWORD START
        ==============================-->
        <section class="login_area pt_120 xs_pt_100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <form id="login-form" @submit.prevent="forgotPassword">
                            <p>Enter email password to receive reset password code</p>
                            <div class="row mt-3">
                                <FormGroup
                                    class="form-group mb-3"
                                    :validation-bag="[
                                        {
                                            condition: !$v.forgot_password.email.required,
                                            message: 'Email is required',
                                        },
                                    ]"
                                >
                                    <FormInput
                                        v-model="$v.forgot_password.email.$model"
                                        :has-error="$v.forgot_password.email.$error"
                                        type="email"
                                        name="email"
                                        placeholder="Email"
                                        autocomplete="email"
                                    />
                                </FormGroup>
                            </div>
                            <button
                                class="common_btn form-control mb-3"
                                type="submit"
                            >
                                Forgot Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!--=============================
        FORGOT PASSWORD END
        ==============================-->
    </div>
</template>


<script>
import { email, required } from "vuelidate/lib/validators";
import { load } from "recaptcha-v3";

export default {
    data() {
        return {
            sendingRequest: false,
            forgot_password: {
                email: ''
            }
        }
    },

    methods: {
        async recaptcha() {
            const recaptcha = await load(process.env.recaptchaKeys);
            const token = await recaptcha.execute("login");
            return token;
        },

        resetForm() {
            this.forgot_password = {
                email: ''
            }
            this.$v.$reset();
        },

        async forgotPassword() {
            if (!this.validateForm() || this.sendingRequest) return;
            this.sendingRequest = true;

            try {
                // const recaptchaToken = await this.recaptcha();

                const response = await this.$axios.post('/api/v1/auth/forgot-password', {
                    ...this.forgot_password,
                });                

                this.$router.push(`/auth/${encodeURIComponent(this.forgot_password.email)}/reset-password`);

                this.$message({
                    type: "success",
                    message: "Reset password code successfully",
                });
            } catch (error) {
                console.log(error);
            } finally {
                this.sendingRequest = false;
            }
        },

        validateForm() {
            let isValid = false;
            this.$v.forgot_password.$touch();
            isValid = !this.$v.forgot_password.$invalid;
            if (isValid) {
                return true;
            }
            return false;
        },
    },

    validations(){
        return {
            forgot_password: {
                email: { required, email }
            }
        }
    }
};
</script>