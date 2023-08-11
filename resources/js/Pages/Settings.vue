<template>
    <h1 class="text-3xl font-bold underline">Settings</h1>
    <Nav></Nav>

    <div style="margin-top: 300px">
        <p>The current time is {{time}}</p>
        <Link href="/settings" preserve-scroll>Refresh</Link>
    </div>

    <div>{{doubleCount}}</div>
    <button @click="increment()">Increase</button>
</template>

<script>
import Nav from '../Shared/Nav.vue';
import {Link} from '@inertiajs/vue3';
import {mapState, mapActions} from 'pinia';
import {useCounterStore1} from '../../stores/CounterStore';

export default {
    components: {Nav, Link},
    props: {
        time: String
    },
    computed: {
        ...mapState(useCounterStore1, ['doubleCount'])
    },
    methods: {
        ...mapActions(useCounterStore1, ['increment'])
    }
}
</script>

