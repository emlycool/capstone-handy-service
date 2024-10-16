<template>
    <!--============================
        BREADCRUMB START
    =============================-->
    <section class="page_breadcrumb" style="background: url(/assets/images/custom/water-sink.jpg);">
        <div class="breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12 wow fadeInUp">
                        <div class="breadcrumb_text">
                            <h1>{{breadcrumb}}</h1>
                            <slot></slot>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        BREADCRUMB END
    =============================-->
</template>

<script>
export default {
    props: {
        breadcrumb: {
            type: String,
            default: ''
        }
    }
}
</script>