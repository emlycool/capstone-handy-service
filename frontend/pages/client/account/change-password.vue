<template>
    <div>
        <!--===================================
            DASHBOARD PERSONAL INFO START
        ====================================-->
        <section class="dashboard pt_120 xs_pt_100">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-4 wow fadeInLeft">
                        <DashboardClientMenu />
                    </div>
                    <div class="col-xl-9 col-lg-8 wow fadeInRight">
                        <div class="dashboard_content">
                            <div class="dashboard_profile_info">
                                <div class="dashboard_profile_info_edit">
                                    <h2>
                                        Change Password
                                    </h2>
                                    <form
                                        @submit.prevent="changePassword"
                                        class="info_edit_form booking_info_form"
                                    >
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <FormGroup
                                                    :validation-bag="[
                                                        {
                                                            condition: !$v.password.current_password.required,
                                                            message: 'Current password is required',
                                                        },
                                                    ]"
                                                >
                                                    <label>Current password</label>
                                                    <FormInput
                                                        v-model="$v.password.current_password.$model"
                                                        :has-error="$v.password.current_password.$error"
                                                        type="password"
                                                        name="password"
                                                        placeholder="Current password"
                                                    />
                                                </FormGroup>
                                            </div>
                                            <div class="col-xl-6">
                                                <FormGroup
                                                    class="mb-3"
                                                    :validation-bag="[
                                                        {
                                                            condition: !$v.password.new_password.required,
                                                            message: 'New password is required',
                                                        },
                                                    ]"
                                                >
                                                    <label>New password</label>
                                                    <FormInput
                                                        v-model="$v.password.new_password.$model"
                                                        :has-error="$v.password.new_password.$error"
                                                        type="password"
                                                        name="new_password"
                                                        placeholder="New password"
                                                    />
                                                </FormGroup>
                                            </div>
                                            <div class="col-xl-12">
                                                <button
                                                    type="submit"
                                                    class="common_btn"
                                                >
                                                    Change Password
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
            password: {
                current_password: "",
                new_password: ""
            },
            sendingRequest: false
        }
    },

    methods: {
        async changePassword() {
             if (!this.validateForm() || this.sendingRequest) return;

            this.sendingRequest = true;
            try {
                const response = await this.$axios.put("/api/v1/onboarding/user/change-password", {...this.password})

                this.$message({
                    type: "success",
                    message: "Password changed successfully",
                });

            } catch (error) {

            }
            finally {
                this.sendingRequest = false
            }
        },

        validateForm() {
            let isValid = false;
            this.$v.password.$touch();
            isValid = !this.$v.password.$invalid;
            if (isValid) {
                return true;
            }
            return false;
        },
    },

    validations() {
        return {
            password: {
                current_password: {required},
                new_password: {required}
            }
        }
    },


};
</script>