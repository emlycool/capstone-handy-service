<template>
    <div>
        <LayoutMiniBanner breadcrumb="Services">
            <ul class="d-flex flex-wrap">
                <li><nuxt-link to="/">Home</nuxt-link></li>
                <li><nuxt-link to="/services">Services</nuxt-link></li>
            </ul>
        </LayoutMiniBanner>

        <!--============================
        SERVICES PAGE START
        =============================-->
        <section class="services_page pt_120 xs_pt_100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-9 order-2 wow fadeInLeft">
                        <div class="sticky_sidebar">
                            <form action="#" class="service__sidebar">
                                <div class="service_search_box">
                                    <input
                                        type="text"
                                        placeholder="Search"
                                    />
                                    <button>
                                        <i
                                            class="far fa-search"
                                            aria-hidden="true"
                                        ></i>
                                    </button>
                                </div>

                                <div class="service__sidebar_location">
                                    <h5>Province</h5>
                                    <select class="select_2 form-control" @change="getServices({province_id: $event.target.value})">
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

                                <div class="service__sidebar_category">
                                    <h5>categories</h5>
                                    <ul>
                                        <li v-for="(category, index) in categories" :key="index">
                                            <span class="cursor-pointer" @click="getServices({category_id: category.id})">{{category.name}}</span>
                                        </li>
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-8 small_margin order-lg-2">
                        <div class="row">
                            <div v-for="(service, index) in services" :key="index" 
                                class="col-md-6 col-xl-6 wow fadeInUp">
                                <div class="single_services">
                                    <nuxt-link
                                        class="single_services_img"
                                        :to="`/services/${service.id}`"
                                    >
                                        <img
                                            src="/assets/images/custom/service_3_img_4.png"
                                            alt="services"
                                            class="img-fluid w-100"
                                        />
                                        <!-- <span class="trending"
                                            ><i class="fas fa-bolt"></i
                                        ></span> -->
                                    </nuxt-link>
                                    <div class="single_services_text">
                                        <ul
                                            class="d-flex flex-wrap align-items-center"
                                        >
                                            <li>
                                                <div class="img">
                                                    <img
                                                        :src="service?.provider?.business_logo.url"
                                                        alt="provider"
                                                        class="img-fluid w-100"
                                                    />
                                                </div>
                                                {{ service?.provider?.business_name}}
                                            </li>
                                        </ul>
                                        <nuxt-link
                                            :to="`/services/${service.id}`"
                                            class="title mb-3"
                                            >{{service.name}}</nuxt-link
                                        >
                                        <div class="d-flex align-items-center">
                                                                                    <nuxt-link
                                            class="book_now_btn"
                                            :to="`/services/${service.id}`"
                                            >book now</nuxt-link
                                        >
                                        <!-- <span class="ml-auto">{{service.price_model}}</span> -->
                                        <h4>{{ formatCurrency(service.price)}}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pagination mt_35 wow fadeInUp">
                            <ul class="d-flex flex-wrap">
                                <li class="page-item">
                                    <a
                                        class="page-link"
                                        href="#"
                                        aria-label="Previous"
                                    >
                                        <i
                                            class="far fa-angle-left"
                                            aria-hidden="true"
                                        ></i>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link active" href="#">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">3</a>
                                </li>
                                <li class="page-item">
                                    <a
                                        class="page-link"
                                        href="#"
                                        aria-label="Next"
                                    >
                                        <i
                                            class="far fa-angle-right"
                                            aria-hidden="true"
                                        ></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--============================
        SERVICES PAGE END
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
            params: {
                page: 1,
                search: null,
                category_id: null,
                province_id: null
            },
            services: [],
            meta: [],
            categories: [],
            provinces: []
        };
    },

    created() {
        this.getProvinces()
        this.getServiceCategories()
        this.getServices({
            page: 1
        })
    },

    methods: {
        async getServices(params){
            try {
                const response = await this.$axios.get('/api/v1/services', {
                    params
                });

                this.services = response.data.data
                this.meta = response.data.meta

            } catch (error) {
                this.toastError(error)
            }
        },

        async getServiceCategories(){
            try{
                const response = await this.$axios.get('/api/v1/service-categories');

                this.categories = response.data.data
            }catch(error){
                this.toastError(error)
            }
        },

        async getProvinces()
        {
            try{
                const response = await this.$axios.get('/api/v1/onboarding/provinces');

                this.provinces = response.data.data
            }catch(error){
                this.toastError(error)
            }
        },
    },
};
</script>