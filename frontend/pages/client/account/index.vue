<template>
    <div>
        <!--===================================
            DASHBOARD PERSONAL INFO START
        ====================================-->
        <section class="dashboard pt_120 xs_pt_100" v-if="authUser">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-4 wow fadeInLeft">
                        <div class="dashboard_sidebar">
                            <div class="dashboard_sidebar_user">
                                <div class="img">
                                    <img
                                        :src="authUser.avatar"
                                        alt="dashboard"
                                        class="img-fluid w-100"
                                    />
                                </div>
                                <h3>
                                    {{
                                        `${authUser.first_name} ${authUser.last_name}`
                                    }}
                                </h3>
                                <p>Client</p>
                            </div>
                            <div class="dashboard_sidebar_menu">
                                <ul>
                                    <li>
                                        <a class="active" href="dashboard.html"
                                            ><i class="fas fa-user"></i>
                                            Personal Info</a
                                        >
                                    </li>
                                    <li>
                                        <a href="dashboard_order.html"
                                            ><i
                                                class="fas fa-shopping-basket"
                                            ></i>
                                            My Service Requests</a
                                        >
                                    </li>
                                    <li>
                                        <a href="dashboard_review.html"
                                            ><i class="fas fa-star"></i>
                                            Reviews</a
                                        >
                                    </li>
                                    <li>
                                        <a href="dashboard_wishlist.html"
                                            ><i class="fas fa-heart"></i>
                                            Bookmarks</a
                                        >
                                    </li>
                                    <li>
                                        <a href="dashboard_change_password.html"
                                            ><i class="fas fa-key"></i> Change
                                            Password</a
                                        >
                                    </li>
                                    <li>
                                        <a
                                            href="#"
                                            data-bs-toggle="modal"
                                            data-bs-target="#exampleModal"
                                            ><i class="fas fa-sign-out-alt"></i>
                                            Logout</a
                                        >
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-8 wow fadeInRight">
                        <div class="dashboard_content">
                            <p class="welcome">
                                Hello,
                                {{
                                    `${authUser.first_name} ${authUser.last_name}`
                                }}
                            </p>
                            <h2 class="title">Welcome To Your Profile</h2>

                            <div
                                class="dashboard_profile_info"
                                v-if="!editingProfile"
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
                                        Personal Information
                                        <a class="cursor-pointer" @click.prevent="editProfile()">Edit</a
                                        >
                                    </h2>
                                    <ul>
                                        <li>
                                            <span>Name:</span>
                                            {{
                                                `${authUser.first_name} ${authUser.last_name}`
                                            }}
                                        </li>
                                        <li>
                                            <span>Email:</span>
                                            {{ authUser.email }}
                                        </li>
                                        <li>
                                            <span>Phone:</span>
                                            {{ authUser.phone }}
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="dashboard_profile_info" v-else>
                                <div class="dashboard_profile_info_edit">
                                    <h2>
                                        Edit Information
                                        <a class="cursor-pointer" @click.prevent="editingProfile=false">Cancel</a>
                                    </h2>
                                    <form
                                        @submit.prevent="updateUser"
                                        class="info_edit_form booking_info_form"
                                    >
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <FormGroup
                                                    :validation-bag="[
                                                        {
                                                            condition: !$v.profile.first_name.required,
                                                            message: 'First name is required',
                                                        },
                                                    ]"
                                                >
                                                    <label>First name</label>
                                                    <FormInput
                                                        v-model="$v.profile.first_name.$model"
                                                        :has-error="$v.profile.first_name.$error"
                                                        type="text"
                                                        name="first_name"
                                                        placeholder="First name"
                                                        autocomplete="first_name"
                                                    />
                                                </FormGroup>
                                            </div>
                                            <div class="col-xl-6">
                                                <FormGroup
                                                    class="mb-3"
                                                    :validation-bag="[
                                                        {
                                                            condition: !$v.profile.last_name.required,
                                                            message: 'Last name is required',
                                                        },
                                                    ]"
                                                >
                                                    <label>Last name</label>
                                                    <FormInput
                                                        v-model="$v.profile.last_name.$model"
                                                        :has-error="$v.profile.last_name.$error"
                                                        type="text"
                                                        name="last_name"
                                                        placeholder="Last name"
                                                        autocomplete="last_name"
                                                    />
                                                </FormGroup>
                                            </div>
                                            <div class="col-xl-6">
                                                <FormGroup
                                                    class="mb-3"
                                                    :validation-bag="[
                                                    ]"
                                                >
                                                    <label>Phone Number</label>
                                                    <FormInput
                                                        v-model="profile.phone"
                                                        :has-error="false"
                                                        type="tel"
                                                        name="phone"
                                                        placeholder=""
                                                    />
                                                </FormGroup>
                                            </div>
                                            <div class="col-xl-12">
                                                <button
                                                    type="submit"
                                                    class="common_btn"
                                                >
                                                    Save Profile
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
import { required } from "vuelidate/lib/validators";

export default {
    data() {
        return {
            editingProfile: false,
            profile: {
                first_name: '',
                last_name: '',
                phone: ''
            },
            sendingRequest: false

        };
    },

    computed: {
        ...mapGetters({
            authUser: "auth/authUser",
        }),
    },

    methods: {
        ...mapMutations({
            setUser: "auth/setUser",
        }),

        async updateUser() {
            console.log("hit");
            
            if (!this.validateForm() || this.sendingRequest) return;

            this.sendingRequest = true;
            try {
                // const recaptchaToken = await this.recaptcha();
                const response = await this.$axios.put("/api/v1/onboarding/user", {...this.profile})

                const user = response.data.data;
                this.setUser(user)

                this.$message({
                    type: "success",
                    message: "Profile updated successfully",
                });

                this.editingProfile = false

            } catch (error) {
                this.toastError(error);
            }
            finally {
                this.sendingRequest = false
            }
        },

        editProfile(){
            this.profile = {
                first_name: this.authUser.first_name,
                last_name: this.authUser.last_name,
                phone: this.authUser.phone
            } 
            this.editingProfile = true
        },

        validateForm() {
            let isValid = false;
            this.$v.profile.$touch();
            isValid = !this.$v.profile.$invalid;
            if (isValid) {
                return true;
            }
            return false;
        }

    },

    validations() {
        return {
            profile: {
                first_name: {required},
                last_name: {required},
            }
        }
    },
};
</script>