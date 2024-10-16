<template>
    <div>
        <LayoutMiniBanner breadcrumb="Services">
            <ul class="d-flex flex-wrap">
                <li><nuxt-link to="/">Home</nuxt-link></li>
                <li><nuxt-link to="/services">Services</nuxt-link></li>
                <li v-if="service"><nuxt-link :to="`/services/${service.id}`">{{service.name}} </nuxt-link></li>
            </ul>
        </LayoutMiniBanner>

    <!--============================
        SERVICE DETAILS START
    =============================-->
    <section class="services_details pt_120 xs_pt_100">
        <div class="container">
            <div class="row" v-if="service">
                <div class="col-lg-8 wow fadeInLeft">
                    <div class="services_details_img">
                        <img :src="service.images[0]" :alt="service.name" class="img-fluid w-100" v-if="service.images.length">
                        <img src="https://placehold.co/1000x600" :alt="service.name" class="img-fluid w-100" v-else >
                    </div>
                    <div class="services_details_area">
                        <h2 class="details_title">{{service.name}}</h2>
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                    aria-selected="true">Details</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-contact" type="button" role="tab"
                                    aria-controls="pills-contact" aria-selected="false">Reviews</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                aria-labelledby="pills-home-tab" tabindex="0">
                                <div class="service_details_overview">
                                    <p>{{service.description}}</p>

                                    <h3>Service Availability:</h3>
                                    <ul>
                                        <li v-for="(working_hour, index) in service.working_hours" :key="index">
                                            <span class="text-capitalize">{{working_hour.day}}</span> {{working_hour.start_time}} - {{working_hour.end_time}}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                aria-labelledby="pills-contact-tab" tabindex="0">
                                <div class="service_details_review">
                                    <div class="single_review">
                                        <div class="img">
                                            <img src="assets/images/review_img_1.png" alt="review"
                                                class="img-fluid w-100">
                                        </div>
                                        <div class="text">
                                            <h4>
                                                Dianne Russel
                                                <span>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </span>
                                            </h4>
                                            <p class="date">23 Jul 2023</p>
                                            <p class="description">Testimonials are written or recorded statements that
                                                support your credibility and level of expertise.
                                                They also string then your reputation.</p>
                                        </div>
                                    </div>
                                    <div class="single_review">
                                        <div class="img">
                                            <img src="assets/images/review_img_2.png" alt="review"
                                                class="img-fluid w-100">
                                        </div>
                                        <div class="text">
                                            <h4>
                                                Maria Khondoker
                                                <span>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </span>
                                            </h4>
                                            <p class="date">20 May 2023</p>
                                            <p class="description">Testimonials are written or recorded statements that
                                                support your credibility and level of expertise.
                                                They also string then your reputation.</p>
                                        </div>
                                    </div>
                                    <div class="single_review">
                                        <div class="img">
                                            <img src="assets/images/review_img_3.png" alt="review"
                                                class="img-fluid w-100">
                                        </div>
                                        <div class="text">
                                            <h4>
                                                Andrew Wills
                                                <span>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </span>
                                            </h4>
                                            <p class="date">22 Oct 2023</p>
                                            <p class="description">Testimonials are written or recorded statements that
                                                support your credibility and level of expertise.
                                                They also string then your reputation.</p>
                                        </div>
                                    </div>
                                    <div class="pagination mt_30">
                                        <ul class="pagination">
                                            <li class="page-item">
                                                <a class="page-link" href="#" aria-label="Previous">
                                                    <i class="far fa-angle-left"></i>
                                                </a>
                                            </li>
                                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item"><a class="page-link active" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item">
                                                <a class="page-link" href="#" aria-label="Next">
                                                    <i class="far fa-angle-right"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="input_review mt_60">
                                    <h3>Write Your Review</h3>
                                    <div class="select_rating">
                                        <span>select Your rating:</span>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>

                                    <form action="#">
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <label>Name</label>
                                                <input type="text" placeholder="Your answer">
                                            </div>
                                            <div class="col-xl-6">
                                                <label>email</label>
                                                <input type="email" placeholder="Your email">
                                            </div>
                                            <div class="col-xl-12">
                                                <label>Comment</label>
                                                <textarea rows="5" placeholder="Write a review"></textarea>
                                                <button class="common_btn" type="submit">submit<i
                                                        class="far fa-long-arrow-right"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-10 col-md-7 wow fadeInRight">
                    <div class="sidebar sticky_sidebar">
                        <div class="sidebar_package">
                            <span class="text-capitalize">{{service.price_model}}</span>
                            <h2>{{formatCurrency(service.price)}}</h2>
                            <ul>
                                <li>Service duration {{service.duration_minutes}} minutes </li>
                                <li v-for="(benefit, index) in service.included_benefits" :key="index">{{benefit}}</li>
                            </ul>
                            <nuxt-link :to="`/services/${service.id}/book`" class="common_btn w-100">Book Now <i
                                    class="far fa-long-arrow-right"></i></nuxt-link>
                        </div>
                        <div class="sidebar_provider mt_30">
                            <div class="img">
                                <img :src="service.provider?.business_logo.url" :alt="service.provider?.business_name" class="img-fluid w-100">
                            </div>
                            <h2>{{service.provider?.business_name}}</h2>
                            <p>Member Since {{ (new Date(service.created_at)).toDateString()}}</p>
                            <ul>
                                <li>
                                    <b>
                                        <i class="fas fa-map"></i>
                                        Address
                                    </b>
                                    <span>{{service.provider?.address}}</span>
                                </li>
                                <li>
                                    <b>
                                        <i class="fas fa-star"></i>
                                        City
                                    </b>
                                    <span>{{service.provider?.city}}</span>
                                </li>
                            </ul>
                            <a :href="`mailto:${service.provider?.business_email}`"><i class="fas fa-envelope"></i>
                                {{service.provider?.business_email}}</a>
                            <a :href="`callto:${service.provider?.business_phone}`"><i class="fas fa-phone-alt"></i> {{service.provider?.business_phone}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        SERVICE DETAILS END
    =============================-->
    </div>
</template>

<script>
import { mapActions } from "vuex";
import ValidationMixinVue from '@/mixins/ValidationMixin.vue';
import UtilMixin from '@/mixins/UtilMixin.vue';

export default {
    mixins: [ValidationMixinVue, UtilMixin],
    
    data() {
        return {
            service: null
        }
    },

    created(){
        this.getService()
    },

    methods: {
        async getService(){
            try {
                let id = this.$route.params.id;
                const response = await this.$axios.get(`/api/v1/services/${id}`);

                this.service = response.data.data

            } catch (error) {
                this.toastError(error)
            }
        }
    },
}
</script>