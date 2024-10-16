<template>
    <div>
        <LayoutMiniBanner breadcrumb="Service Booking">
            <ul class="d-flex flex-wrap">
                <li><nuxt-link to="/">Home</nuxt-link></li>
                <li><nuxt-link to="/services">Service Booking</nuxt-link></li>
                <li v-if="service">
                    <nuxt-link :to="`/services/${service.id}`"
                        >{{ service.name }}
                    </nuxt-link>
                </li>
            </ul>
        </LayoutMiniBanner>
        <section class="booking_services pt_120 xs_pt_100">
            <div class="container">
                <div class="row" v-if="service && !bookSuccessfully">
                    <div class="col-lg-8 wow fadeInLeft">
                        <form class="booking_info_form">
                            <div class="booking_details_img">
                                <img
                                    :src="service.images[0]"
                                    :alt="service.name"
                                    class="img-fluid w-100"
                                    v-if="service.images.length"
                                />
                                <img
                                    src="https://placehold.co/1000x600"
                                    :alt="service.name"
                                    class="img-fluid w-100"
                                />
                            </div>
                            <h2>Booking Information</h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Province</label>
                                    <select class="select_2 form-control">
                                        <option value="">Select..</option>
                                        <option
                                            v-for="province in provinces"
                                            :key="province.id"
                                            :value="province.id"
                                        >
                                            {{ province.name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Zip Code</label>
                                    <FormGroup
                                        class="form-group mb-3"
                                        :validation-bag="[
                                            {
                                                condition:
                                                    !$v.booking.zip_code
                                                        .required,
                                                message: 'Zip code is required',
                                            },
                                        ]"
                                    >
                                        <FormInput
                                            v-model="$v.booking.zip_code.$model"
                                            :has-error="
                                                $v.booking.zip_code.$error
                                            "
                                            type="text"
                                            name="address"
                                            placeholder="M9M2N4"
                                            autocomplete="zip_code"
                                        />
                                    </FormGroup>
                                </div>
                                <div class="col-md-12">
                                    <label>Address</label>
                                    <FormGroup
                                        class="form-group mb-3"
                                        :validation-bag="[
                                            {
                                                condition:
                                                    !$v.booking.address
                                                        .required,
                                                message: 'Address is required',
                                            },
                                        ]"
                                    >
                                        <FormInput
                                            v-model="$v.booking.address.$model"
                                            :has-error="
                                                $v.booking.address.$error
                                            "
                                            type="text"
                                            name="address"
                                            placeholder="Street address"
                                            autocomplete="address"
                                        />
                                    </FormGroup>
                                </div>
                                <div class="col-md-12">
                                    <label>Note</label>
                                    <FormGroup class="form-group mb-3">
                                        <FormTextarea
                                            v-model="booking.notes"
                                            name="notes"
                                            rows="7"
                                            placeholder="Your note here"
                                        />
                                    </FormGroup>
                                </div>
                                <div class="col-md-12">
                                    <div>
                                        <el-form>
                                            <div class="row">
                                                <div
                                                    class="col-md-6 d-flex align-items-center"
                                                >
                                                    <!-- Date Picker -->
                                                    <el-form-item
                                                        label="Select Date"
                                                    >
                                                        <el-date-picker
                                                            v-model="
                                                                selectedDate
                                                            "
                                                            type="date"
                                                            placeholder="Pick a date"
                                                            format="yyyy-MM-dd"
                                                            :picker-options="
                                                                pickerOptions
                                                            "
                                                            @change="
                                                                onDateChange
                                                            "
                                                        >
                                                        </el-date-picker>
                                                    </el-form-item>
                                                </div>

                                                <div
                                                    class="col-md-6 d-flex align-items-center"
                                                >
                                                    <!-- Time Picker with Custom Time Slots -->
                                                    <el-form-item
                                                        v-if="selectedDate"
                                                        label="Select Time"
                                                    >
                                                        <el-select
                                                            v-model="
                                                                selectedTime
                                                            "
                                                            placeholder="Select"
                                                        >
                                                            <el-option
                                                                v-for="(
                                                                    item, index
                                                                ) in filteredTimeSlots"
                                                                :key="index"
                                                                :label="
                                                                    item.label
                                                                "
                                                                :value="
                                                                    item.value
                                                                "
                                                            >
                                                            </el-option>
                                                        </el-select>
                                                    </el-form-item>
                                                </div>
                                            </div>
                                        </el-form>

                                        <!-- Display Selected Date and Time -->
                                        <div
                                            v-if="selectedDate && selectedTime"
                                        >
                                            <p>
                                                Selected Date:
                                                {{
                                                    selectedDate.toLocaleDateString(
                                                        "en-CA"
                                                    )
                                                }}
                                            </p>
                                            <p>
                                                Selected Time:
                                                {{
                                                    selectedTime.start +
                                                    "-" +
                                                    selectedTime.end
                                                }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button
                                        type="submit"
                                        class="common_btn_2"
                                        @click.prevent="handleBooking()"
                                    >
                                        Book
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4 col-md-9 wow fadeInRight">
                        <div class="booking_sidebar sticky_sidebar">
                            <div class="">
                                <h3>Service Provider</h3>
                                <div class="sidebar_provider mt_30">
                                    <div class="img">
                                        <img
                                            :src="
                                                service.provider?.business_logo
                                                    .url
                                            "
                                            :alt="
                                                service.provider?.business_name
                                            "
                                            class="img-fluid w-100"
                                        />
                                    </div>
                                    <h2>
                                        {{ service.provider?.business_name }}
                                    </h2>
                                    <p>
                                        Member Since
                                        {{
                                            new Date(
                                                service.created_at
                                            ).toDateString()
                                        }}
                                    </p>
                                    <ul>
                                        <li>
                                            <b>
                                                <i class="fas fa-map"></i>
                                                Address
                                            </b>
                                            <span>{{
                                                service.provider?.address
                                            }}</span>
                                        </li>
                                        <li>
                                            <b>
                                                <i class="fas fa-star"></i>
                                                City
                                            </b>
                                            <span>{{
                                                service.provider?.city
                                            }}</span>
                                        </li>
                                    </ul>
                                    <a
                                        :href="`mailto:${service.provider?.business_email}`"
                                        ><i class="fas fa-envelope"></i>
                                        {{
                                            service.provider?.business_email
                                        }}</a
                                    >
                                    <a
                                        :href="`callto:${service.provider?.business_phone}`"
                                        ><i class="fas fa-phone-alt"></i>
                                        {{
                                            service.provider?.business_phone
                                        }}</a
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <el-alert
                    v-if="bookSuccessfully"
                    title="Service booked successfully"
                    type="success"
                    description="You will get an email notification once the service provider confirms booking."
                    show-icon
                >
                </el-alert>
            </div>
        </section>
    </div>
</template>

<script>
import { mapActions } from "vuex";
import ValidationMixinVue from "@/mixins/ValidationMixin.vue";
import UtilMixin from "@/mixins/UtilMixin.vue";
import { email, required, nullable } from "vuelidate/lib/validators";
import { load } from "recaptcha-v3";

export default {
    mixins: [ValidationMixinVue, UtilMixin],

    data() {
        return {
            service: null,
            selectedDate: null,
            selectedTime: null,
            pickerOptions: {
                disabledDate: (date) => {
                    // Convert the given date to just the date part (without time)
                    const selectedDate = date.toISOString().split("T")[0];

                    // Check if there are time slots for the selected date
                    const hasTimeSlot = this.availableSlots.some((slot) => {
                        const slotDate = slot.start.split("T")[0]; // Extract the date part from the time slot
                        return selectedDate === slotDate; // Enable the date only if it matches a time slot date
                    });

                    // Disable if no time slot is available
                    return !hasTimeSlot;
                },
            },
            availableSlots: [],
            provinces: [],
            booking: {
                notes: "",
                address: "",
                zip_code: "",
            },
            sendingRequest: false,
            bookSuccessfully: false,
        };
    },

    computed: {
        filteredTimeSlots() {
            const selectedDateString = this.selectedDate
                .toISOString()
                .split("T")[0]; // Convert selectedDate to 'YYYY-MM-DD'

            return this.availableSlots
                .filter((slot) => {
                    const slotDate = new Date(slot.start)
                        .toISOString()
                        .split("T")[0]; // Extract date part
                    return slotDate === selectedDateString; // Compare only the dates
                })
                .map((slot) => {
                    const start = new Date(slot.start).toLocaleTimeString(
                        "en-GB",
                        { hour12: false }
                    );
                    const end = new Date(slot.end).toLocaleTimeString("en-GB", {
                        hour12: false,
                    });

                    return {
                        label: `${start} - ${end}`,
                        value: {
                            start: start,
                            end: end,
                        },
                    };
                });
        },
    },

    created() {
        this.getService();
        this.getAvailableSlots();
        this.getProvinces();
    },

    methods: {
        async getService() {
            try {
                let id = this.$route.params.id;
                const response = await this.$axios.get(
                    `/api/v1/services/${id}`
                );

                this.service = response.data.data;
            } catch (error) {
                this.toastError(error);
            }
        },

        onDateChange(value) {
            console.log("Selected Date:", value);
        },
        onTimeChange(value) {
            console.log("Selected Time:", value);
        },

        async getAvailableSlots() {
            try {
                let id = this.$route.params.id;
                const response = await this.$axios.post(
                    "api/v1/appointment/available-slots",
                    {
                        id: id,
                    }
                );

                this.availableSlots = response.data.data;
            } catch (error) {
                this.toastError(error);
            }
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

        validateForm() {
            let isValid = false;
            this.$v.booking.$touch();
            isValid = !this.$v.booking.$invalid;
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

        async handleBooking() {
            if (!this.validateForm() || this.sendingRequest) return;

            this.sendingRequest = true;

            try {
                // const recaptchaToken = await this.recaptcha();
                let id = this.$route.params.id;

                const response = await this.$axios.post(
                    "/api/v1/appointment/book",
                    {
                        provider_service_id: id,
                        date: this.selectedDate.toLocaleDateString("en-CA"),
                        start_time: this.selectedTime.start,
                        end_time: this.selectedTime.end,
                        notes: this.booking.notes,
                        address: this.booking.address,
                    }
                );
                console.log(response);

                this.$message({
                    type: "success",
                    message: "Appointment booked successfully",
                });

                this.resetForm();
                this.bookSuccessfully = true
            } catch (error) {
                // eslint-disable-next-line no-console
                this.toastError(error);
            } finally {
                this.sendingRequest = false;
            }
        },

        resetForm() {
            this.booking = {
                notes: "",
                address: "",
                zip_code: "",
            };
            // this.selectedDate = null;
            // this.selectedTime = null;
            this.$v.$reset();
        },
    },

    validations: {
        booking: {
            address: { required },
            zip_code: { required },
        },
    },
};
</script>