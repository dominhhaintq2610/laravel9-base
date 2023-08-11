<template>
    <h1 class="text-3xl font-bold underline">Home</h1>
    <Nav></Nav>
    <div>Count: {{count}}<button class="ps-3" @click="increment()">Increase</button></div>
</template>

<script setup>
import Nav from '../Shared/Nav.vue';
import {defineProps} from 'vue';
import {useCounterStore2} from "../../stores/CounterStore";
import {storeToRefs} from "pinia";

const props = defineProps({
    name: {type: String},
    frameworks: {type: Array}
});

const counterStore2 = useCounterStore2();
const {count, name} = storeToRefs(counterStore2);
const {increment} = counterStore2;
</script>
