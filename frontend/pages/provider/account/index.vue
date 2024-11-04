<template>
    <div>
        <section class="dashboard pt_120 xs_pt_100" v-if="authUser">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-4 wow fadeInLeft">
                        <DashboardProviderMenu />
                    </div>
                    <div class="col-xl-9 col-lg-8 wow fadeInRight">
                        <div class="dashboard_content">
                            <p class="welcome">
                                Hello,
                                {{
                                    `${authUser.first_name}`
                                }}
                            </p>
                            <h2 class="title">Welcome</h2>

                            <div
                                class="dashboard_profile_info"
                                v-if="!editingBusinessProfile"
                            >
                                <div class="row">
                                    <div class="col-xl-4 col-md-6">
                                        <div
                                            class="profile_overview_item green"
                                        >
                                            <span
                                                ><i
                                                    class="fas fa-shopping-basket"
                                                ></i
                                            ></span>
                                            <h3>2</h3>
                                            <p>Pending Service Booked</p>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-md-6">
                                        <div class="profile_overview_item blue">
                                            <span
                                                ><i class="fas fa-box-check"></i
                                            ></span>
                                            <h3>5</h3>
                                            <p>Upcoming Service appointments</p>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-md-6">
                                        <div class="profile_overview_item red">
                                            <span
                                                ><i
                                                    class="fas fa-clipboard-list-check"
                                                ></i
                                            ></span>
                                            <h3>4</h3>
                                            <p>
                                                Completed Service appointments
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="dashboard_profile_info_list mt_25">
                                    <h2>
                                        Business Information
                                        <a class="cursor-pointer" @click.prevent="editBusinessProfile()">Edit</a
                                        >
                                    </h2>
                                    <ul>
                                        <li>
                                            <span>Business Name:</span>
                                            {{
                                                `${authUser.provider.business_name}`
                                            }}
                                        </li>
                                        <li>
                                            <span>Business Contact Email:</span>
                                            {{ authUser.provider.business_email }}
                                        </li>
                                        <li>
                                            <span>Phone:</span>
                                            {{ authUser.provider.business_phone }}
                                        </li>
                                        <li>
                                            <span>City:</span>
                                            {{ authUser.provider.city }}
                                        </li>
                                        <li>
                                            <span>Province:</span>
                                            {{ authUser.provider.province.name }}
                                        </li>
                                        <li>
                                            <span>Address:</span>
                                            {{ authUser.provider.address }}
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="dashboard_profile_info" v-else>
                                <div class="dashboard_profile_info_edit">
                                    <h2>
                                        Edit Information
                                        <a class="cursor-pointer" @click.prevent="editingBusinessProfile=false">Cancel</a>
                                    </h2>
                                    <form
                                        @submit.prevent="updateBusinessProfile"
                                        class="info_edit_form booking_info_form"
                                    >
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <FormGroup
                                                    :validation-bag="[
                                                        {
                                                            condition: !$v.provider.business_name.required,
                                                            message: 'Business name is required',
                                                        },
                                                    ]"
                                                >
                                                    <label>Business name</label>
                                                    <FormInput
                                                        v-model="$v.provider.business_name.$model"
                                                        :has-error="$v.provider.business_name.$error"
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
                                                            condition: !$v.provider.business_email.required,
                                                            message: 'Business Contact Email is required',
                                                        },
                                                        {
                                                            condition: !$v.provider.business_email.email,
                                                            message: 'Business Contact Email is invalid',
                                                        },
                                                    ]"
                                                >
                                                    <label>Business Contact Email</label>
                                                    <FormInput
                                                        v-model="$v.provider.business_email.$model"
                                                        :has-error="$v.provider.business_email.$error"
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
                                                            condition: !$v.provider.business_phone.required,
                                                            message: 'Business Contact Phone is required',
                                                        },
                                                    ]"
                                                >
                                                    <label>Business Phone Number</label>
                                                    <FormInput
                                                        v-model="$v.provider.business_phone.$model"
                                                        :has-error="$v.provider.business_phone.$error"
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
                                                            condition: !$v.provider.province_id.required,
                                                            message: 'Province is required',
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
                                                        v-model="$v.provider.province_id.$model"
                                                        :has-error="$v.provider.province_id.$error"
                                                        @change="setCities($v.provider.province_id.$model)"
                                                    >
                                                        <option value="">Select..</option>
                                                        <option
                                                            v-for="province in provinces"
                                                            :key="province.id"
                                                            :value="province.id"
                                                        >
                                                            {{ province.name }}
                                                        </option>
                                                    </select>
                                                </FormGroup>
                                            </div>
                                            <div class="col-xl-6">
                                                <FormGroup
                                                    class="mb-3"
                                                    :validation-bag="[
                                                        {
                                                            condition: !$v.provider.city.required,
                                                            message: 'City is required',
                                                        },
                                                    ]"
                                                >
                                                    <label>City</label>
                                                    <select
                                                        :class="
                                                                !$v.provider
                                                                    .city
                                                                    .$error
                                                                    ? 'select_2 form-control'
                                                                    : 'select_2 form-control is-invalid'
                                                            "
                                                        v-model="$v.provider.city.$model"
                                                        :has-error="$v.provider.city.$error"
                                                    >
                                                        <option value="">Select..</option>
                                                        <option
                                                            v-for="city in cities"
                                                            :key="city.name"
                                                            :value="city.name"
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
                                                            condition: !$v.provider.address.required,
                                                            message: 'Address is required',
                                                        },
                                                    ]"
                                                >
                                                    <label>Business Address</label>
                                                    <FormInput
                                                        v-model="$v.provider.address.$model"
                                                        :has-error="$v.provider.address.$error"
                                                        type="text"
                                                        name="address"
                                                        placeholder="Business Address"
                                                    />
                                                </FormGroup>
                                            </div>
                                            <div class="col-xl-12">
                                                <button
                                                    type="submit"
                                                    class="common_btn"
                                                >
                                                    Save Business Profile
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import { mapGetters, mapMutations } from "vuex";
import { required, email } from "vuelidate/lib/validators";


export default {
    data() {
        return {
            provider: {
                province_id: null,
                business_name: null,
                city: null,
                business_phone: null,
                business_email: null,
                address: null,
            },
            editingBusinessProfile: false,
            provinces: [],
            cities: [],
            sendingRequest: false
        };
    },

    created() {
        this.getProvinces()
    },

    computed: {
        ...mapGetters({
            authUser: "auth/authUser",
        })
    },

    methods: {
        ...mapMutations({
            setUser: "auth/setUser"
        }),
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
            if(province){
                this.cities = province.cities
            }
        },

        validateForm() {
            let isValid = false;
            this.$v.provider.$touch();
            isValid = !this.$v.provider.$invalid;
            console.log({isValid});
            
            if (isValid) {
                return true;
            }
            return false;
        },

        async updateBusinessProfile() {
            
            if (!this.validateForm() || this.sendingRequest) return;

            this.sendingRequest = true;
            try {
                let formData = new FormData();
                const { business_logo, ...providerData } = { ...this.provider };

                for (const key in providerData) {
                    formData.append(key, providerData[key]);
                }
                // formData.set("business_logo", this.businessLogoFile); 

                const response = await this.$axios.post("/api/v1/onboarding/provider", formData)

                const provider = response.data.data;
                let user = structuredClone(this.authUser)
                user.provider = provider
                this.setUser(user)

                this.$message({
                    type: "success",
                    message: "Business profile updated successfully",
                });

                this.editingBusinessProfile = false

            } catch (error) {
                console.log(error);
                
            }
            finally {
                this.sendingRequest = false
            }
        },

        editBusinessProfile(){
            this.setCities(this.authUser.provider.province_id)
            this.provider = {
                province_id: this.authUser.provider.province_id,
                business_name: this.authUser.provider.business_name,
                city: this.authUser.provider.city,
                business_phone: this.authUser.provider.business_phone,
                business_email: this.authUser.provider.business_email,
                address: this.authUser.provider.address,
            },
            this.editingBusinessProfile = true
        }
        
    },

    validations() {
        return {
            provider: {
                province_id: {required},
                business_name: {required},
                city: {required},
                business_phone: {required},
                business_email: {required, email},
                address: {required}
            },
        }
    }
};
</script>