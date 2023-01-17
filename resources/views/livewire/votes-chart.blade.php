<div>
    <div class="flex justify-center px-6 mx-auto max-w-md">
        <canvas id="myChart" style="width: 100%;"></canvas>
    </div>

    <script>

        function updateChart()
        {
            function getColor(str){
                // Generate color from string
                var hash = 0;
                for (var i = 0; i < str.length; i++) {
                    hash = str.charCodeAt(i) + ((hash << 5) - hash);
                }
                var color = '#';
                for (var i = 0; i < 3; i++) {
                    var value = (hash >> (i * 8)) & 0xFF;
                    color += ('00' + value.toString(16)).substr(-2);
                }
                return color;
            }

            // php $answers to js array, include answer->nVotes() function
            var answers = @json($answers);

            var xValues = answers.map(function(answer) {
                return answer.text;
            });

            // yValues = map answers to votes
            var yValues = answers.map(function(answer) {
                return answer.votes;
            });

            // bar colors = map answers to random colors
            var barColors = answers.map(function(answer) {
                return getColor(answer.text);
            });

            new Chart("myChart", {
                type: "pie",
                responsive: true,
                data: {
                    labels: xValues,
                    datasets: [{
                        backgroundColor: barColors,
                        data: yValues
                    }]
                },
                options: {
                    title: {
                        display: false,
                        text: "Voting chart"
                    },
                    legend: {
                        position: 'right',
                        responsive: false,
                        display: true,
                    },
                }
            });
        }

        window.addEventListener('contentChanged', event => {
            updateChart();
        });

        updateChart()
    </script>
</div>
