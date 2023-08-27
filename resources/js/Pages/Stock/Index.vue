<template>
    <div class="container">
        <highcharts :options="chartOptions" />
    </div>
</template>

<script setup lang="ts">
import {ref} from "vue";
import {defineProps} from "vue/dist/vue";
import {format} from "date-fns";

const props = defineProps({
    historicalData: {type: Object},
});

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
            color: 'red',       // Color of bullish (up) candlesticks
            upColor: 'green',       // Color of bearish (down) candlesticks
            lineColor: 'black',   // Color of the lines connecting the candles
        },
        heikinashi: {
            color: 'red',       // Color of bullish (up) candlesticks
            upColor: 'green',       // Color of bearish (down) candlesticks
            lineColor: 'black',   // Color of the lines connecting the candles
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

transformStockData();

function transformStockData() {
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
</script>
