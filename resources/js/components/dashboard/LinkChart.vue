<script>
  import { Bar } from 'vue-chartjs'

  export default {
    name: 'LinkChart',

    props: ['chartData', 'chartLabels'],

    extends: Bar,

    mounted () {
      this.renderBarChart()
    },

    methods: {
      renderBarChart () {
        let data = {
          labels: this.chartLabels,
          datasets:
            [{
              data: this.chartData,
              backgroundColor: 'rgba(107, 70, 193, 1)',
              borderColor: 'rgba(107, 70, 193, 1)',
              categoryPercentage: 1,
            }]
        }

        let options = {
          animation: {
            easing: 'easeOutCubic'
          },

          scales: {
            yAxes: [{
              display: false,
              ticks: {
                beginAtZero: true,
              },
              gridLines: {
                display: false,
              }
            }],

            xAxes: [{
              ticks: {
                fontSize: 14,
                fontStyle: 'bold',
                fontColor: '#A0AEC0',
              },
              gridLines: {
                display: false,
              },
            }]
          },

          legend: {
            display: false
          },

          responsive: true,
        }

        this.renderChart(data, options)
      }
    },

    watch: {
      chartData () {
        this.$data._chart.destroy()
        this.renderBarChart()
      }
    }
  }
</script>
