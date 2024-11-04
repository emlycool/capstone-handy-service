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
                                    <h2>My Service Requests</h2>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="table-responsive">
                                                <table
                                                    class="table table-striped"
                                                >
                                                    <thead>
                                                        <th>S/N</th>
                                                        <th>Status</th>
                                                        <th>Service Name</th>
                                                        <th>
                                                            Service category
                                                        </th>
                                                        <th>Provider Name</th>
                                                        <th>Booked For</th>
                                                        <td>Scheduled on</td>
                                                    </thead>
                                                    <tbody>
                                                        <tr
                                                            v-for="(
                                                                appointment,
                                                                index
                                                            ) in appointments"
                                                            :key="
                                                                appointment.id
                                                            "
                                                        >
                                                            <td>
                                                                {{ (meta.from) + index }}
                                                            </td>
                                                            <td>
                                                                <span
                                                                    :class="
                                                                        appointmentStatusBadge(
                                                                            appointment.status
                                                                        )
                                                                    "
                                                                    >{{
                                                                        appointment.status
                                                                    }}</span
                                                                >
                                                            </td>
                                                            <td>
                                                                {{
                                                                    appointment
                                                                        .service
                                                                        ?.name
                                                                }}
                                                            </td>
                                                            <td>
                                                                {{
                                                                    appointment
                                                                        .service_category
                                                                        ?.name
                                                                }}
                                                            </td>
                                                            <td>
                                                                {{
                                                                    appointment
                                                                        .provider
                                                                        ?.business_name
                                                                }}
                                                            </td>
                                                            <td>
                                                                {{
                                                                    formatToLocalTime(appointment.appointment_start_date)
                                                                }}
                                                            </td>
                                                            <td>
                                                                {{
                                                                    formatToLocalTime(appointment.created_at)
                                                                }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-xl-12" v-if="meta.last_page != 1">
                                            <div
                                                class="pagination mt_35 wow fadeInUp"
                                            >
                                                <ul class="d-flex flex-wrap">
                                                    <li class="page-item">
                                                        <a
                                                            class="page-link"
                                                            href="#"
                                                            aria-label="Previous"
                                                            v-if="meta.current_page !=0"
                                                            @click.prevent="getAppointments({page: meta.current_page-1})"
                                                        >
                                                            <i
                                                                class="fa fa-angle-left"
                                                                aria-hidden="true"
                                                            ></i>
                                                        </a>
                                                    </li>
                                                    <li class="page-item" v-for="page in pageRange()" :key="page">
                                                        <a
                                                            :class="page == meta.current_page ? 'page-link active': 'page-link'"
                                                            href="#"
                                                            @click.prevent="getAppointments({page})"
                                                            >{{page}}</a
                                                        >
                                                    </li>
                                                    <li class="page-item">
                                                        <a
                                                            class="page-link"
                                                            href="#"
                                                            aria-label="Next"
                                                            @click.prevent="getAppointments({page: meta.current_page+1})"
                                                            v-if="meta.current_page != meta.last_page"
                                                        >
                                                            <i
                                                                class="fa fa-angle-right"
                                                                aria-hidden="true"
                                                            ></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
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
import UtilMixin from "@/mixins/UtilMixin.vue";

export default {
    mixins: [UtilMixin],

    data() {
        return {
            params: {
                page: 1,
                limit: 5,
            },
            appointments: [],
            meta: {},
            sendingRequest: false,
        };
    },

    created() {
        this.getAppointments(this.params);
    },

    methods: {
        async getAppointments(params) {
            params = {...this.params, ...params}
            this.params = params
            console.log(this.params);
            
            try {
                const response = await this.$axios.get(
                    "/api/v1/appointment/client/list",
                    {
                        params,
                    }
                );

                this.appointments = response.data.data;
                this.meta = response.data.meta;
            } catch (error) {
                console.log(e);
            }
        },

        appointmentStatusBadge(status) {
            switch (status) {
                case "booked":
                    return "badge badge-yellow";
                    break;

                case "confirmed":
                    return "badge badge-blue";
                    break;
                case "cancelled":
                    return "badge badge-red";
                    break;
                default:
                    return "badge badge-grey";
                    break;
            }
        },

        pageRange() {
            let window_size = 4;
            const current_page = this.meta.current_page
            const last_page = this.meta.last_page
            const start = current_page - window_size > 0 ? current_page - window_size: 1;
            const end = current_page + window_size > last_page ? last_page :   current_page + window_size; 
            return Array.from({ length: end - start + 1 }, (_, i) => i + start);
        },
    },
};
</script>