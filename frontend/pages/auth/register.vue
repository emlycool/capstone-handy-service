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
                                <div class="col-xl-12">
                                    <div class="login_text">
                                        <h4>Registration</h4>
                                        <form @submit.prevent="registerSubmit">
                                            <div class="form-group mb-5">
                                                <template>
                                                    <el-switch
                                                        v-model="
                                                            register.is_client
                                                        "
                                                        active-color="#FFC700"
                                                        inactive-color="#06AE59"
                                                        active-text="Seeking home services"
                                                        inactive-text="Rendering home services"
                                                    >
                                                    </el-switch>
                                                </template>
                                            </div>

                                            <div
                                                class="row"
                                                v-if="!registration_status"
                                            >
                                                <FormGroup
                                                    class="mb-3 col-lg-6"
                                                    :validation-bag="[
                                                        {
                                                            condition:
                                                                !$v.register
                                                                    .first_name
                                                                    .required,
                                                            message:
                                                                'First name is required',
                                                        },
                                                    ]"
                                                >
                                                    <label>First name</label>
                                                    <FormInput
                                                        v-model="
                                                            $v.register
                                                                .first_name
                                                                .$model
                                                        "
                                                        :has-error="
                                                            $v.register
                                                                .first_name
                                                                .$error
                                                        "
                                                        type="text"
                                                        name="first_name"
                                                        placeholder="First name"
                                                        autocomplete="first_name"
                                                    />
                                                </FormGroup>

                                                <FormGroup
                                                    class="mb-3 col-lg-6"
                                                    :validation-bag="[
                                                        {
                                                            condition:
                                                                !$v.register
                                                                    .last_name
                                                                    .required,
                                                            message:
                                                                'Last name is required',
                                                        },
                                                    ]"
                                                >
                                                    <label>Last name</label>
                                                    <FormInput
                                                        v-model="
                                                            $v.register
                                                                .last_name
                                                                .$model
                                                        "
                                                        :has-error="
                                                            $v.register
                                                                .last_name
                                                                .$error
                                                        "
                                                        type="text"
                                                        name="last_name"
                                                        placeholder="Last name"
                                                        autocomplete="last_name"
                                                    />
                                                </FormGroup>

                                                <FormGroup
                                                    class="mb-3 col-lg-6"
                                                    :validation-bag="[
                                                        {
                                                            condition:
                                                                !$v.register
                                                                    .email
                                                                    .required,
                                                            message:
                                                                'Email is required',
                                                        },
                                                        {
                                                            condition:
                                                                !$v.register
                                                                    .email
                                                                    .email,
                                                            message:
                                                                'Email is invalid',
                                                        },
                                                    ]"
                                                >
                                                    <label>Email</label>
                                                    <FormInput
                                                        v-model="
                                                            $v.register.email
                                                                .$model
                                                        "
                                                        :has-error="
                                                            $v.register.email
                                                                .$error
                                                        "
                                                        type="email"
                                                        name="email"
                                                        placeholder="Email"
                                                        autocomplete="email"
                                                    />
                                                </FormGroup>
                                                <FormGroup
                                                    class="mb-3 col-lg-6"
                                                    :validation-bag="[]"
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

                                                <FormGroup
                                                    class="mb-3 col-lg-6"
                                                    :validation-bag="[
                                                        {
                                                            condition:
                                                                !$v.register
                                                                    .password
                                                                    .required,
                                                            message:
                                                                'Password is required',
                                                        },
                                                    ]"
                                                >
                                                    <label>Password</label>
                                                    <FormInput
                                                        v-model="
                                                            $v.register.password
                                                                .$model
                                                        "
                                                        :has-error="
                                                            $v.register.password
                                                                .$error
                                                        "
                                                        type="password"
                                                        name="password"
                                                        placeholder="password"
                                                    />
                                                </FormGroup>

                                                <FormGroup
                                                    class="mb-3 col-lg-6"
                                                    :validation-bag="[
                                                        {
                                                            condition:
                                                                register.password !=
                                                                register.password_confirmation,
                                                            message:
                                                                'Password does not match',
                                                        },
                                                    ]"
                                                >
                                                    <label
                                                        >Password
                                                        Confirmation</label
                                                    >
                                                    <FormInput
                                                        v-model="
                                                            register.password_confirmation
                                                        "
                                                        :has-error="
                                                            register.password !=
                                                            register.password_confirmation
                                                        "
                                                        type="password"
                                                        name="password_confirmation"
                                                        placeholder=""
                                                    />
                                                </FormGroup>
                                            </div>

                                            <div
                                                class="row"
                                                v-if="!register.is_client"
                                            >
                                                <h5 class="mt-5">
                                                    Fill business information
                                                </h5>
                                                <div
                                                    class="border border-bottom mb-3"
                                                ></div>
                                                <div class="col-xl-6">
                                                    <FormGroup
                                                        :validation-bag="[
                                                            {
                                                                condition:
                                                                    !$v.provider
                                                                        .business_name
                                                                        .required,
                                                                message:
                                                                    'Business name is required',
                                                            },
                                                        ]"
                                                    >
                                                        <label
                                                            >Business
                                                            name</label
                                                        >
                                                        <FormInput
                                                            v-model="
                                                                $v.provider
                                                                    .business_name
                                                                    .$model
                                                            "
                                                            :has-error="
                                                                $v.provider
                                                                    .business_name
                                                                    .$error
                                                            "
                                                            type="text"
                                                            name="business_name"
                                                            placeholder="Business name"
                                                            autocomplete="business_name"
                                                        />
                                                    </FormGroup>
                                                </div>
                                                <div class="col-xl-6">
                                                    <FormGroup
                                                        class="mb-3"
                                                        :validation-bag="[
                                                            {
                                                                condition:
                                                                    !$v.provider
                                                                        .business_email
                                                                        .required,
                                                                message:
                                                                    'Business Contact Email is required',
                                                            },
                                                            {
                                                                condition:
                                                                    !$v.provider
                                                                        .business_email
                                                                        .email,
                                                                message:
                                                                    'Business Contact Email is invalid',
                                                            },
                                                        ]"
                                                    >
                                                        <label
                                                            >Business Contact
                                                            Email</label
                                                        >
                                                        <FormInput
                                                            v-model="
                                                                $v.provider
                                                                    .business_email
                                                                    .$model
                                                            "
                                                            :has-error="
                                                                $v.provider
                                                                    .business_email
                                                                    .$error
                                                            "
                                                            type="email"
                                                            name="business_email"
                                                            placeholder="Business contact email"
                                                        />
                                                    </FormGroup>
                                                </div>
                                                <div class="col-xl-6">
                                                    <FormGroup
                                                        class="mb-3"
                                                        :validation-bag="[
                                                            {
                                                                condition:
                                                                    !$v.provider
                                                                        .business_phone
                                                                        .required,
                                                                message:
                                                                    'Business Contact Phone is required',
                                                            },
                                                        ]"
                                                    >
                                                        <label
                                                            >Business Phone
                                                            Number</label
                                                        >
                                                        <FormInput
                                                            v-model="
                                                                $v.provider
                                                                    .business_phone
                                                                    .$model
                                                            "
                                                            :has-error="
                                                                $v.provider
                                                                    .business_phone
                                                                    .$error
                                                            "
                                                            type="tel"
                                                            name="phone"
                                                            placeholder="Phone number"
                                                        />
                                                    </FormGroup>
                                                </div>
                                                <div class="col-xl-6">
                                                    <FormGroup
                                                        class="mb-3"
                                                        :validation-bag="[
                                                            {
                                                                condition:
                                                                    !$v.provider
                                                                        .province_id
                                                                        .required,
                                                                message:
                                                                    'Province is required',
                                                            },
                                                        ]"
                                                    >
                                                        <label>Province</label>
                                                        <select
                                                            :class="
                                                                !$v.provider
                                                                    .province_id
                                                                    .$error
                                                                    ? 'select_2 form-control'
                                                                    : 'select_2 form-control is-invalid'
                                                            "
                                                            v-model="
                                                                $v.provider
                                                                    .province_id
                                                                    .$model
                                                            "
                                                            :has-error="
                                                                $v.provider
                                                                    .province_id
                                                                    .$error
                                                            "
                                                            @change="
                                                                setCities(
                                                                    $v.provider
                                                                        .province_id
                                                                        .$model
                                                                )
                                                            "
                                                        >
                                                            <option value="">
                                                                Select..
                                                            </option>
                                                            <option
                                                                v-for="province in provinces"
                                                                :key="
                                                                    province.id
                                                                "
                                                                :value="
                                                                    province.id
                                                                "
                                                            >
                                                                {{
                                                                    province.name
                                                                }}
                                                            </option>
                                                        </select>
                                                    </FormGroup>
                                                </div>
                                                <div class="col-xl-6">
                                                    <FormGroup
                                                        class="mb-3"
                                                        :validation-bag="[
                                                            {
                                                                condition:
                                                                    !$v.provider
                                                                        .city
                                                                        .required,
                                                                message:
                                                                    'City is required',
                                                            },
                                                        ]"
                                                    >
                                                        <label>City</label>
                                                        <select
                                                            :class="
                                                                !$v.provider
                                                                    .city.$error
                                                                    ? 'select_2 form-control'
                                                                    : 'select_2 form-control is-invalid'
                                                            "
                                                            v-model="
                                                                $v.provider.city
                                                                    .$model
                                                            "
                                                            :has-error="
                                                                $v.provider.city
                                                                    .$error
                                                            "
                                                        >
                                                            <option value="">
                                                                Select..
                                                            </option>
                                                            <option
                                                                v-for="city in cities"
                                                                :key="city.name"
                                                                :value="
                                                                    city.name
                                                                "
                                                            >
                                                                {{ city.name }}
                                                            </option>
                                                        </select>
                                                    </FormGroup>
                                                </div>
                                                <div class="col-xl-6">
                                                    <FormGroup
                                                        class="mb-3"
                                                        :validation-bag="[
                                                            {
                                                                condition:
                                                                    !$v.provider
                                                                        .address
                                                                        .required,
                                                                message:
                                                                    'Address is required',
                                                            },
                                                        ]"
                                                    >
                                                        <label
                                                            >Business
                                                            Address</label
                                                        >
                                                        <FormInput
                                                            v-model="
                                                                $v.provider
                                                                    .address
                                                                    .$model
                                                            "
                                                            :has-error="
                                                                $v.provider
                                                                    .address
                                                                    .$error
                                                            "
                                                            type="text"
                                                            name="address"
                                                            placeholder="Business Address"
                                                        />
                                                    </FormGroup>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <button
                                                    class="common_btn"
                                                    type="submit"
                                                >
                                                    Register
                                                </button>
                                            </div>
                                        </form>
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
                first_name: "",
                last_name: "",
                email: "",
                password: "",
                password_confirmation: "",
                phone: "",
            },
            provider: {
                province_id: null,
                business_name: null,
                city: null,
                business_phone: null,
                business_email: null,
                address: null,
            },
            provinces: [],
            cities: [],
            sendingRequest: false,
            registration_status: false,
        };
    },

    created() {
        this.getProvinces();
    },

    methods: {
        ...mapMutations({
            setBearerToken: "auth/setBearerToken",
            setUser: "auth/setUser",
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
                const user = response.data.data.user;
                this.setBearerToken(token);
                this.setUser(user);
                this.registration_status = true;
                if (!this.register.is_client) {
                    await this.storeBusinessProfile(user);
                }
                this.$message({
                    type: "success",
                    message: "Registered successfully",
                });


                let redirectUrl = this.$route.query.redirect;
                if (redirectUrl) {
                    this.$router.push(redirectUrl);
                    return;
                }
                this.$router.push(
                    this.register.is_client
                        ? "/client/account"
                        : "/provider/account"
                );
                this.resetForm();

            } catch (error) {
                // this.toastError(error);
                console.log(error);
            } finally {
                this.sendingRequest = false;
            }
        },

        async handleRegister() {
            return await this.$axios.post("/api/v1/onboarding/register", {
                ...this.register,
            });
        },

        validateForm() {
            let isValid = false;
            this.$v.register.$touch();
            isValid = !this.$v.register.$invalid;
            isValid = isValid && this.password == this.password_confirmation;
            if (!isValid) {
                return false;
            }

            if (!this.register.is_client) {
                this.$v.provider.$touch();
                isValid = !this.$v.provider.$invalid;
            }
            return isValid;
        },

        resetForm() {
            this.register = {
                is_client: true,
                first_name: "",
                last_name: "",
                email: "",
                password: "",
                password_confirmation: "",
                phone: "",
            };

            this.provider = {
                province_id: null,
                business_name: null,
                city: null,
                business_phone: null,
                business_email: null,
                address: null,
            };
        },

        async getProvinces() {
            try {
                const response = await this.$axios.get(
                    "/api/v1/onboarding/provinces"
                );

                this.provinces = response.data.data;
            } catch (error) {
                this.toastError(error);
            }
        },

        setCities(province_id) {
            let province = this.provinces.find(({ id }) => id === province_id);
            if (province) {
                this.cities = province.cities;
            }
        },

        async storeBusinessProfile(user) {
            this.sendingRequest = true;
            try {
                let formData = new FormData();
                const providerData = { ...this.provider };

                for (const key in providerData) {
                    formData.append(key, providerData[key]);
                }
                // formData.set("business_logo", this.businessLogoFile);

                const response = await this.$axios.post(
                    "/api/v1/onboarding/provider",
                    formData
                );

                const provider = response.data.data;
                user = structuredClone(user);
                user.provider = provider;
                this.setUser(user);
            } catch (error) {
                console.log(error);
            } finally {
                this.sendingRequest = false;
            }
        },
    },

    validations() {
        return {
            register: {
                is_client: { required },
                first_name: { required },
                last_name: { required },
                email: { required, email },
                password: { required },
            },
            provider: {
                province_id: { required },
                business_name: { required },
                city: { required },
                business_phone: { required },
                business_email: { required, email },
                address: { required },
            },
        };
    },
};
</script>