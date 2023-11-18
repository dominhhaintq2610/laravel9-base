<template>
    <h1 class="text-3xl font-bold underline">Users</h1>
    <Nav></Nav>

    <div>{{doubleCount}}</div>
    <button @click="increment()">Increase</button>
</template>

<script>
import Nav from '../Shared/Nav.vue';
import {mapState, mapActions} from 'pinia';
import {useCounterStore1} from '../../stores/CounterStore';

export default {
    components: {Nav},
    computed: {
        ...mapState(useCounterStore1, ['doubleCount'])
    },
    methods: {
        ...mapActions(useCounterStore1, ['increment'])
    }
}
</script>
