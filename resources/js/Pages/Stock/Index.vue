<template>
    <div class="container">
        <div class="mx-4 mt-2 mb-5">
            <form class="d-flex align-items-center" @submit.prevent="search()">
                <label for="symbol" class="fw-bold">Mã:</label>
                <input type="text" id="symbol" class="form-control width-100 ms-2" v-model="symbol">

                <label for="from" class="fw-bold ms-3">Từ:</label>
                <input type="date" id="from" class="form-control width-150 ms-2" v-model="from">

                <label for="to" class="fw-bold ms-3">Đến:</label>
                <input type="date" id="to" class="form-control width-150 ms-2" v-model="to">

                <button type="submit" class="btn btn-success ms-3">Tìm kiếm</button>
            </form>
        </div>

        <highcharts :options="chartOptions" />
    </div>
</template>

<script setup lang="ts">
import {ref} from "vue";
import {defineProps} from "vue/dist/vue";
import {format} from "date-fns";
import {router} from "@inertiajs/vue3";

const props = defineProps({
    historicalData: {type: Object},
    symbol: {type: String},
    from: {type: String},
    to: {type: String},
});

const symbol = ref(props.symbol);
const from = ref(props.from);
const to = ref(props.to);

const stockData = ref([]);
const chartOptions = ref({
    chart: {
        height: 1500,
    },
    title: {
        text: '',
    },
    rangeSelector: {
        selected: 1
    },
    xAxis: {
        categories: stockData.value.map(([formattedTime]) => formattedTime),
    },
    yAxis: [{
        title: {
            text: 'Candlestick'
        },
        height: '45%',
        tickInterval: 1000,
    }, {
        title: {
            text: 'Heikin Ashi'
        },
        top: '55%',
        height: '45%',
        offset: 0,
        tickInterval: 1000,
    }],
    plotOptions: {
        candlestick: {
            color: 'red',
            upColor: 'green',
            lineColor: 'black',
        },
        heikinashi: {
            color: 'red',
            upColor: 'green',
            lineColor: 'black',
        },
    },
    series: [{
        type: 'candlestick',
        name: 'Candlestick',
        data: stockData.value
    }, {
        type: 'heikinashi',
        name: 'Heikin Ashi',
        data: stockData.value,
        yAxis: 1,
        tooltip: {
            valueDecimals: 0
        },
    }]
});

init();

function init() {
    transformStockData();
}

function transformStockData() {
    if (!props.historicalData.time?.length) {
        return;
    }

    const length = props.historicalData.time.length;

    for (let index = 0; index < length; index++) {
        stockData.value[index] = [
            format(new Date(Number(props.historicalData.time[index]) * 1000), 'yyyy-MM-dd'),
            Number(props.historicalData.open[index]) * 1000,
            Number(props.historicalData.high[index]) * 1000,
            Number(props.historicalData.low[index]) * 1000,
            Number(props.historicalData.close[index]) * 1000,
            Number(props.historicalData.volume[index])
        ];
    }

    setChartData();
}

function setChartData() {
    chartOptions.value.series[0].data = stockData.value;
    chartOptions.value.series[1].data = stockData.value;
    chartOptions.value.xAxis.categories = stockData.value.map(([formattedTime]) => formattedTime);
}

function getHeikinAshiColor(open, close, high, low) {
    let averagePrice = (open + close + high + low) / 4;
    if (close > open && close > averagePrice) {
        return "green"; // Nến xanh
    } else if (open > close && open > averagePrice) {
        return "red"; // Nến đỏ
    } else {
        return "yellow"; // Nến vàng
    }
}

function search() {
    router.get('/stock', {
        symbol: symbol.value,
        from: from.value,
        to: to.value,
    });
}
</script>
