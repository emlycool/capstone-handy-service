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
                        <form id="login-form" @submit.prevent="resetPassword">
                            <p>Enter new password and OTP sent to {{reset_password.email}}</p>
                            <div class="row mt-3">
                                <FormGroup
                                    class="form-group mb-3"
                                    :validation-bag="[
                                        {
                                            condition: !$v.reset_password.email.required,
                                            message: 'Email is required',
                                        },
                                    ]"
                                >
                                    <FormInput
                                        v-model="$v.reset_password.email.$model"
                                        :has-error="$v.reset_password.email.$error"
                                        type="email"
                                        name="email"
                                        placeholder="Email"
                                        autocomplete="email"
                                    />
                                </FormGroup>
                            </div>

                            <div class="row mt-3">
                                <FormGroup
                                    class="form-group mb-3"
                                    :validation-bag="[
                                        {
                                            condition: !$v.reset_password.password.required,
                                            message: 'Password is required',
                                        },
                                    ]"
                                >
                                    <FormInput
                                        v-model="$v.reset_password.password.$model"
                                        :has-error="$v.reset_password.password.$error"
                                        type="password"
                                        name="password"
                                        placeholder="password"
                                        autocomplete="password"
                                    />
                                </FormGroup>
                            </div>

                            <div class="row mt-3">
                                <FormGroup
                                    class="form-group mb-3"
                                    :validation-bag="[
                                        {
                                            condition: !$v.reset_password.otp.required,
                                            message: 'OTP is required',
                                        },
                                    ]"
                                >
                                    <FormInput
                                        v-model="$v.reset_password.otp.$model"
                                        :has-error="$v.reset_password.otp.$error"
                                        type="number"
                                        name="otp"
                                        placeholder="otp"
                                        autocomplete="otp"
                                    />
                                </FormGroup>
                            </div>
                            <button
                                class="common_btn form-control mb-3"
                                type="submit"
                            >
                                Reset Password
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
            reset_password: {
                email: '',
                password: '',
                otp: ''
            }
        }
    },
    
    mounted() {
        this.reset_password.email = decodeURIComponent(this.$route.params.email)
    },

    methods: {
        async recaptcha() {
            const recaptcha = await load(process.env.recaptchaKeys);
            const token = await recaptcha.execute("login");
            return token;
        },

        resetForm() {
            this.reset_password = {
                email: '',
                password: '',
                otp: ''
            }
            this.$v.$reset();
        },

        async resetPassword() {
            if (!this.validateForm() || this.sendingRequest) return;
            this.sendingRequest = true;

            try {
                // const recaptchaToken = await this.recaptcha();

                const response = await this.$axios.post('/api/v1/auth/reset-password', {
                    ...this.reset_password,
                    password_confirmation: this.reset_password.password
                });                

                this.$message({
                    type: "success",
                    message: "Reset password successfully",
                });

                this.resetForm()
                this.$router.push('/auth/login');
            } catch (error) {
                console.log(error);
            } finally {
                this.sendingRequest = false;
            }
        },

        validateForm() {
            let isValid = false;
            this.$v.reset_password.$touch();
            isValid = !this.$v.reset_password.$invalid;
            if (isValid) {
                return true;
            }
            return false;
        },
    },

    validations(){
        return {
            reset_password: {
                email: {required, email},
                password: {required},
                otp: {required}
            }
        }
    }
}
</script>