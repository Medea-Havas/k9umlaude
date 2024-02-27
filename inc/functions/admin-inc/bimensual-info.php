<script>
  /**
   * Users by month registry
   */
  var submittedChart;
  Chart.register(ChartDataLabels);
  Chart.defaults.set('plugins.datalabels', {
    backgroundColor: 'rgba(0, 0, 0, .6)',
    color: 'white',
    borderRadius: 100,
    fontWeight: 'bold',
    padding: {
      top: 2,
      bottom: 2,
      left: 5,
      right: 5
    }
  });
  // Chart data
  let year23 = monthsData.slice(0, 12);
  let year24 = monthsData.slice(12, 24);
  let usersByMonthData23 = [];
  let usersByMonthLabels23 = [];
  let usersByMonthData24 = [];
  let usersByMonthLabels24 = [];
  let usersByPassedData23 = [];
  let usersByPassedLabels23 = [];
  let usersByPassedData24 = [];
  let usersByPassedLabels24 = [];

  for (let i = 0; i < year23.length; i++) {
    usersByMonthData23.push(year23[i].users);
    usersByMonthLabels23.push(year23[i].name);
    usersByPassedData23.push(year23[i].passed);
  }
  for (let i = 0; i < year24.length; i++) {
    usersByMonthData24.push(year24[i].users);
    usersByMonthLabels24.push(year24[i].name);
    usersByPassedData24.push(year24[i].passed);
  }
  const usersByMonth = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
  // Options
  const monthData = {
    labels: usersByMonth,
    datasets: [{
      label: 'Registrados \'23',
      data: usersByMonthData23,
      borderColor: 'rgb(16, 138, 168)',
      backgroundColor: 'rgba(16, 138, 168, .7)',
      borderWidth: 1
    }, {
      label: 'Aprobados \'23',
      data: usersByPassedData23,
      borderColor: 'rgb(56, 178, 208)',
      backgroundColor: 'rgba(56, 178, 208, .7)',
      borderWidth: 1
    }, {
      label: 'Registrados \'24',
      data: usersByMonthData24,
      borderColor: 'rgb(142, 152, 0))',
      backgroundColor: 'rgba(142, 152, 0, .7)',
      borderWidth: 1
    }, {
      label: 'Aprobados \'24',
      data: usersByPassedData24,
      borderColor: 'rgb(182, 192, 40))',
      backgroundColor: 'rgba(182, 192, 40, .7)',
      borderWidth: 1
    }]
  };
  // Config
  const monthConfig = {
    type: 'bar',
    data: monthData,
    plugins: [ChartDataLabels],
    options: {
      plugins: {
        title: {
          display: true,
          text: 'Usuarios registrados y aprobados por mes'
        },
        tooltip: {
          xAlign: 'center',
          yAlign: 'top',
          callbacks: {
            labelTextColor: function(context) {
              return 'yellow';
            },
            labelPointStyle: function(context) {
              return {
                pointStyle: 'triangle'
              };
            },
            tooltip: function(context) {
              return {
                visible: 'true'
              }
            }
          },
        },
        datalabels: {
          formatter: function(value, index, values) {
            if (value > 0) {
              value = value.toString();
              value = value.split(/(?=(?:...)*$)/);
              value = value.join(',');
              return value;
            } else {
              value = "";
              return null;
            }
          }
        }
      },
    }
  }
  // Chart creation
  new Chart(document.getElementById('usersByMonth'), monthConfig);
</script>