<template>
    <div class="timeline-steps aos-init aos-animate" data-aos="fade-up">
        <div v-for="val in items" class="timeline-step">
            <div class="timeline-content">
                <div class="inner-circle" :class="_.get(val, 'active', false) == true ? 'active':''" ></div>
                <p class="h6 mt-3 mb-1">{{ _.get(val, 'title', 'Untitled') }}</p>
                <p class="h6 text-muted mb-0 mb-lg-0">{{ _.get(val, 'description', '') }}</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "HorizontalTimeline",
    props: {
        items : {
            type: Array,
            default: function(){ return [] }
        }
    }
}
</script>

<style scoped>
.timeline-steps {
    display: flex;
    justify-content: center;
    flex-wrap: wrap
}

.timeline-steps .timeline-step {
    align-items: center;
    display: flex;
    flex-direction: column;
    position: relative;
    margin: 1rem
}

@media (min-width:768px) {
    .timeline-steps .timeline-step:not(:last-child):after {
        content: "";
        display: block;
        border-top: .2rem dotted #3b82f6;
        width: 2.8rem;
        position: absolute;
        left: 7.3rem;
        top: .3125rem
    }
    .timeline-steps .timeline-step:not(:first-child):before {
        content: "";
        display: block;
        border-top: .2rem dotted #3b82f6;
        width: 2.8rem;
        position: absolute;
        right: 7.3rem;
        top: .3125rem
    }
}

.timeline-steps .timeline-content {
    width: 6.2rem;
    text-align: center
}

.timeline-steps .timeline-content .inner-circle {
    border-radius: 1.5rem;
    height: 1rem;
    width: 1rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background-color: #3b82f6
}


.timeline-steps .timeline-content .inner-circle:before {
    content: "";
    background-color: #3b82f6;
    display: inline-block;
    height: 2rem;
    width: 2rem;
    min-width: 2rem;
    border-radius: 3rem;
    opacity: .4
}

.timeline-steps .timeline-content .inner-circle.active {
    background-color: #29883b !important;
}

.timeline-steps .timeline-content .inner-circle.active:before {
    background-color: #f5c841 !important;
    opacity: .6
}

</style>
