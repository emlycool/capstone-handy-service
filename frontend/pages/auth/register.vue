<template>
    <div>
        <LayoutMiniBanner breadcrumb="Login">
            <ul class="d-flex flex-wrap">
                <li><nuxt-link to="/">Home</nuxt-link></li>
                <li><nuxt-link to="/auth/register">Register</nuxt-link></li>
            </ul>
        </LayoutMiniBanner>

        <!--=============================
            SIGN UP  START
        ==============================-->
        <section class="login_area registration pt_120 xs_pt_100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-10 col-lg-8 col-xl-11">
                        <div class="main_login_area">
                            <div class="row">
                                <div class="col-xl-6 wow fadeInLeft">
                                    <div class="login_text">
                                        <h4>Registration</h4>
                                        <form @submit.prevent="registerSubmit">
                                            <div class="form-group mb-5">
                                                <template>
                                                    <el-switch
                                                        v-model="register.is_client"
                                                        active-color="#FFC700"
                                                        inactive-color="#06AE59"
                                                        active-text="Seeking home services"
                                                        inactive-text="Rendering home services">
                                                    </el-switch>
                                                </template>
                                            </div>

                                            <FormGroup
                                                class="mb-3"
                                                :validation-bag="[
                                                    {
                                                        condition: !$v.register.first_name.required,
                                                        message: 'First name is required',
                                                    },
                                                ]"
                                            >
                                                <label>First name</label>
                                                <FormInput
                                                    v-model="$v.register.first_name.$model"
                                                    :has-error="$v.register.first_name.$error"
                                                    type="text"
                                                    name="first_name"
                                                    placeholder="First name"
                                                    autocomplete="first_name"
                                                />
                                            </FormGroup>

                                            <FormGroup
                                                class="mb-3"
                                                :validation-bag="[
                                                    {
                                                        condition: !$v.register.last_name.required,
                                                        message: 'Last name is required',
                                                    },
                                                ]"
                                            >
                                                <label>Last name</label>
                                                <FormInput
                                                    v-model="$v.register.last_name.$model"
                                                    :has-error="$v.register.last_name.$error"
                                                    type="text"
                                                    name="last_name"
                                                    placeholder="Last name"
                                                    autocomplete="last_name"
                                                />
                                            </FormGroup>

                                            <FormGroup
                                                class="mb-3"
                                                :validation-bag="[
                                                    {
                                                        condition: !$v.register.email.required,
                                                        message: 'Email is required',
                                                    },
                                                    {
                                                        condition: !$v.register.email.email,
                                                        message: 'Email is invalid',
                                                    },
                                                ]"
                                            >
                                                <label>Email</label>
                                                <FormInput
                                                    v-model="$v.register.email.$model"
                                                    :has-error="$v.register.email.$error"
                                                    type="email"
                                                    name="email"
                                                    placeholder="Email"
                                                    autocomplete="email"
                                                />
                                            </FormGroup>


                                            <FormGroup
                                                class="mb-3"
                                                :validation-bag="[
                                                    {
                                                        condition: !$v.register.password.required,
                                                        message: 'Password is required',
                                                    },
                                                ]"
                                            >
                                                <label>Password</label>
                                                <FormInput
                                                    v-model="$v.register.password.$model"
                                                    :has-error="$v.register.password.$error"
                                                    type="password"
                                                    name="password"
                                                    placeholder="password"
                                                />
                                            </FormGroup>

                                            <FormGroup
                                                class="mb-3"
                                                :validation-bag="[
                                                    {
                                                        condition: register.password != register.password_confirmation,
                                                        message: 'Password does not match',
                                                    },
                                                ]"
                                            >
                                                <label>Password Confirmation</label>
                                                <FormInput
                                                    v-model="register.password_confirmation"
                                                    :has-error="register.password != register.password_confirmation"
                                                    type="password"
                                                    name="password_confirmation"
                                                    placeholder=""
                                                />
                                            </FormGroup>

                                            <FormGroup
                                                class="mb-3"
                                                :validation-bag="[
                                                ]"
                                            >
                                                <label>Phone number</label>
                                                <FormInput
                                                    v-model="register.phone"
                                                    :has-error="false"
                                                    type="tel"
                                                    name="phone"
                                                    placeholder=""
                                                />
                                            </FormGroup>
                                            
                                            <button class="common_btn" type="submit">Register</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-xl-6 d-none d-xl-block wow fadeInRight">
                                    <div class="login_img">
                                        <img src="assets/images/login_bg.jpg" alt="img" class="img-fluid w-100">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--=============================
            SIGN UP END
        ==============================-->
    </div>
</template>
<script>
import { email, required, sameAs } from "vuelidate/lib/validators";
import { load } from "recaptcha-v3";
import { mapMutations } from "vuex";

export default {
    data() {
        return {
            register: {
                is_client: true,
                first_name: '',
                last_name: '',
                email: '',
                password: '',
                password_confirmation: '',
                phone: '',
            },
            sendingRequest: false

        }
    },
    
    methods: {
        ...mapMutations({
            setBearerToken: "auth/setBearerToken",
        }),

        async recaptcha() {
            const recaptcha = await load(process.env.recaptchaKeys);
            const token = await recaptcha.execute("register");
            return token;
        },

        async registerSubmit() {
            if (!this.validateForm() || this.sendingRequest) return;

            this.sendingRequest = true;
            try {
                // const recaptchaToken = await this.recaptcha();
                const response = await this.handleRegister();
                const token = response.data.data.auth.token;
                this.setBearerToken(token)

                this.$message({
                    type: "success",
                    message: "Registered successfully",
                });

                this.resetForm();

                // TODO: Redirect to dashboard, or provider registration, or redirect url

            } catch (error) {
                this.toastError(error);
            }
            finally {
                this.sendingRequest = false
            }
        },

        async handleRegister(){
            return await this.$axios.post('/api/v1/onboarding/register', { ...this.register});
        },

        validateForm() {
            let isValid = false;
            this.$v.register.$touch();
            isValid = !this.$v.register.$invalid;
            isValid = isValid && this.password == this.password_confirmation
            if (isValid) {
                return true;
            }
            return false;
        },

        resetForm() {
            this.register = {
                is_client: true,
                first_name: '',
                last_name: '',
                email: '',
                password: '',
                password_confirmation: '',
                phone: '',
            }
        },
    },

    validations() {
        return {
            register: {
                is_client: {required},
                first_name: {required},
                last_name: {required},
                email: {required, email},
                password: {required}
            }
        }
    },
}
</script>