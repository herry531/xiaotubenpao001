<canvas id="myChart" width="400" height="100"></canvas>

<script>

    $(function () {
        var ctx = document.getElementById("myChart");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
                datasets: [
                    {
                    {{--label: '财务收入数据(月报表)',--}}
                    {{--data: [0, 0, 0, 0, 0, 0, 0, {{$eight}}, {{$nine}}, {{$ten}}, {{$eleven}}, {{$twelve}}],--}}
                    {{--backgroundColor: [--}}
                        {{--'rgba(255, 99, 132, 0.2)',--}}

                    {{--],--}}

                    {{--borderColor: [--}}
                        {{--'rgba(255,99,132,1)',--}}

                    {{--],--}}
                    {{--pointBackgroundColor: "#fff", //数据点的颜色--}}
                    {{--borderWidth: 1--}}

                    label: "财务支出(测试数据)",  //当前数据的说明
                        data: [2243, 3982, 2100, 3422, 1922, 3910, 2232, {{$eight}}, {{$nine}}, {{$ten}}, {{$eleven}}, {{$twelve}}],
                        backgroundColor: [
                        'rgba(9, 99, 132, 0.2)',
                        ],
                        fill: false,  //是否要显示数据部分阴影面积块  false:不显示
                        borderColor: [
                        'rgba(9,99,132,1)',
                        ],
                        pointBackgroundColor: "#fff", //数据点的颜色
                        borderWidth: 1
                },
                    {
                        label: "财务收入(测试数据)",  //当前数据的说明
                        data: [1352, 4521, 8321, 2213, 4421, 2290, 2134, 3321, 4219, 2390, 1920, 3212],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                        ],
                        fill: false,  //是否要显示数据部分阴影面积块  false:不显示
                        borderColor: [
                            'rgba(255,99,132,1)',
                        ],
                        pointBackgroundColor: "#fff", //数据点的颜色
                        borderWidth: 1
                    },
                ]


            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    });
</script>





