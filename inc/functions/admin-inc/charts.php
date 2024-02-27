<?php include_once('jspdf.php'); ?>
<script>
  Chart.register(ChartDataLabels);
  Chart.defaults.set('plugins.datalabels', {
    anchor: 'end',
    align: 'center',
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
  var specialtyChart;
  var provinceChart;
  var genderChart;
  var monthsChart;
  const options = {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  };
  const today = new Date().toLocaleDateString("es-ES", options);

  document.getElementById('data').addEventListener('click', function() {
    textToCopy = document.getElementById('textToCopy');
    navigator.clipboard.writeText(textToCopy.innerText);
    document.getElementById('alert').style.top = '4rem';
    setTimeout(() => {
      document.getElementById('alert').style.top = '-100%';
    }, 3000);
  });
  document.querySelector('.btnPDF').addEventListener('click', function() {
    textToCopy = document.getElementById('textToCopy');
    navigator.clipboard.writeText(textToCopy.innerText);
    document.getElementById('alert').style.top = '4rem';
    setTimeout(() => {
      document.getElementById('alert').style.top = '-100%';
    }, 3000);
  });

  /**
   * Users by specialty data
   */
  // Reset data
  for (var l = 0; l < specialties.length; l++) {
    specialties[l]['users'] = 0;
  }
  // Set data
  for (var i = 0; i < specialtiesData.length; i++) {
    for (var k = 0; k < specialties.length; k++) {
      if (specialtiesData[i]) {
        if (specialtiesData[i] === specialties[k]['specialty']) {
          specialties[k]['users'] += 1;
          break;
        }
      }
    }
  }
  // Chart data
  let usersBySpecialtyLabels = [];
  let usersBySpecialtyData = [];
  for (let i = 0; i < specialties.length; i++) {
    usersBySpecialtyLabels.push(specialties[i].specialty);
    usersBySpecialtyData.push(specialties[i].users);
  }
  let usersBySpecialtyBG = []
  let usersBySpecialtyBorder = []
  usersBySpecialtyLabels.forEach(element => {
    usersBySpecialtyBG.push('rgba(16, 138, 168, .7)');
    usersBySpecialtyBorder.push('rgb(16, 138, 168)');
  });
  // Options
  let data = {};
  data = {
    labels: usersBySpecialtyLabels,
    datasets: [{
      label: 'Usuarios por especialidad',
      data: usersBySpecialtyData,
      backgroundColor: usersBySpecialtyBG,
      borderColor: usersBySpecialtyBorder,
      borderWidth: 1,
      hoverOffset: 4
    }]
  };
  // Config
  let config = {};
  config = {
    type: 'bar',
    data: data,
    plugins: [ChartDataLabels],
    options: {
      plugins: {
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
      }
    }
  }
  // Chart creation
  if (typeof specialtyChart !== 'undefined') {
    specialtyChart.destroy();
    specialtyChart = new Chart(document.getElementById('usersBySpecialty'), config);
  } else {
    specialtyChart = new Chart(document.getElementById('usersBySpecialty'), config);
  }

  /**
   * Users by province data
   */
  // Reset data
  for (var l = 0; l < provinces.length; l++) {
    provinces[l]['users'] = 0;
  }
  // Set data
  for (var i = 0; i < provincesData.length; i++) {
    for (var k = 0; k < provinces.length; k++) {
      if (provincesData[i]) {
        if (provincesData[i] === provinces[k]['province']) {
          provinces[k]['users'] += 1;
          break;
        }
      }
    }
  }
  // Chart data
  let usersByProvinceLabels = [];
  let usersByProvinceData = [];
  for (let i = 0; i < provinces.length; i++) {
    usersByProvinceLabels.push(provinces[i].province);
    usersByProvinceData.push(provinces[i].users);
  }
  let usersByProvinceBG = []
  let usersByProvinceBorder = []
  usersByProvinceLabels.forEach(element => {
    usersByProvinceBG.push('rgba(16, 138, 168, .7)');
    usersByProvinceBorder.push('rgb(16, 138, 168)');
  });
  // Options
  let pData = {};
  pData = {
    labels: usersByProvinceLabels,
    datasets: [{
      label: 'Usuarios por provincia',
      data: usersByProvinceData,
      backgroundColor: usersByProvinceBG,
      borderColor: usersByProvinceBorder,
      borderWidth: 1,
      hoverOffset: 4
    }]
  };
  // Config
  let provincesConfig = {};
  provincesConfig = {
    type: 'bar',
    data: pData,
    plugins: [ChartDataLabels],
    options: {
      plugins: {
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
      }
    }
  }
  // Chart creation
  if (typeof provinceChart !== 'undefined') {
    provinceChart.destroy();
    provinceChart = new Chart(document.getElementById('usersByProvince'), provincesConfig);
  } else {
    provinceChart = new Chart(document.getElementById('usersByProvince'), provincesConfig);
  }

  /**
   * Users by gender data
   */
  let genders = [{
      'gender': 'Masculino',
      'users': 0
    },
    {
      'gender': 'Femenino',
      'users': 0
    },
    {
      'gender': 'N/E',
      'users': 0
    }
  ];
  // Reset data
  for (var l = 0; l < genders.length; l++) {
    genders[l]['users'] = 0;
  }
  // Set data
  var gendersDataInfo = gendersData.length;
  for (var i = 0; i < gendersData.length; i++) {
    for (var k = 0; k < genders.length; k++) {
      if (gendersData[i]) {
        let gender;
        switch (genders[k]['gender']) {
          case 'Masculino':
            gender = 'Masculino';
            break;
          case 'Femenino':
            gender = 'Femenino';
            break;
          case 'N/E':
            gender = 'N/E';
            break;
          default:
            break;
        }
        if (gendersData[i] === gender) {
          genders[k]['users'] += 1;
          break;
        }
      }
    }
  }
  // Chart data
  let usersByGenderLabels = [];
  let usersByGenderData = [];
  for (let i = 0; i < genders.length; i++) {
    if (genders[i].users > 0) {
      usersByGenderLabels.push(genders[i].gender + ' [' + genders[i].users + ']');
    } else {
      usersByGenderLabels.push(genders[i].gender);
    }
    usersByGenderData.push(genders[i].users);
  }
  let usersByGenderBG = ['rgba(16, 138, 168, .7)', 'rgba(142, 152, 0, .7)', 'rgba(155, 155, 155, .7)'];
  let usersByGenderBorder = ['rgb(16, 138, 168)', 'rgb(142, 152, 0)', 'rgb(155, 155, 155)'];
  // Options
  let genderData;
  genderData = {
    labels: usersByGenderLabels,
    datasets: [{
      label: 'Usuarios por género',
      data: usersByGenderData,
      backgroundColor: usersByGenderBG,
      borderColor: usersByGenderBorder,
      borderWidth: 1,
      hoverOffset: 4
    }]
  };
  // Config
  let genderconfig;
  genderConfig = {
    type: 'doughnut',
    data: genderData,
    plugins: [ChartDataLabels],
    options: {
      tooltips: {
        callbacks: {
          label: function(tooltipItem, data) {
            var dataset = data.datasets[tooltipItem.datasetIndex];
            var meta = dataset._meta[Object.keys(dataset._meta)[0]];
            var total = meta.total;
            var currentValue = dataset.data[tooltipItem.index];
            var percentage = parseFloat((currentValue / total * 100).toFixed(1));
            return currentValue + ' (' + percentage + '%)';
          },
        }
      },
      legend: true,
      plugins: {
        title: {
          display: true,
          text: 'Datos demográficos por sexo',
          font: {
            weight: 'normal'
          },
        },
        legend: {
          labels: {
            generateLabels: (chart) => {
              const datasets = chart.data.datasets;
              return datasets[0].data.map((data, i) => ({
                text: `${chart.data.labels[i]}`,
                fillStyle: datasets[0].backgroundColor[i],
              }))
            }
          }
        },
        datalabels: {
          anchor: 'center',
          formatter: function(value, index, values) {
            if (value > 0) {
              value = value.toString();
              value = value.split(/(?=(?:...)*$)/);
              value = value.join(',');
              let percentage = parseFloat((value / gendersDataInfo * 100).toFixed(1));
              return percentage + '%';
            } else {
              value = "";
              return null;
            }
          }
        },
      }
    }
  }
  // Chart creation
  if (typeof genderChart !== 'undefined') {
    genderChart.destroy();
    genderChart = new Chart(document.getElementById('usersByGender'), genderConfig);
  } else {
    genderChart = new Chart(document.getElementById('usersByGender'), genderConfig);
  }

  /**
   * Users by month registry
   */
  // Chart.register(ChartDataLabels);
  // Chart.defaults.set('plugins.datalabels', {
  //   backgroundColor: 'rgba(0, 0, 0, .6)',
  //   color: 'white',
  //   borderRadius: 100,
  //   fontWeight: 'bold',
  //   padding: {
  //     top: 2,
  //     bottom: 2,
  //     left: 5,
  //     right: 5
  //   }
  // });
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

  function generatePDF() {
    const canvasSpecialty = document.getElementById('usersBySpecialty');
    const canvasProvince = document.getElementById('usersByProvince');
    const canvasGender = document.getElementById('usersByGender');
    const canvasMonth = document.getElementById('usersByMonth');
    var cSpecialty = canvasSpecialty.toDataURL('image/png', 1.0);
    var cProvince = canvasProvince.toDataURL('image/png', 1.0);
    var cGender = canvasGender.toDataURL('image/png', 1.0);
    var cMonth = canvasMonth.toDataURL('image/png', 1.0);
    const doc = new jspdf.jsPDF();
    doc.addImage(cSpecialty, '', 10, 40, 190, 90);
    doc.addImage(cProvince, '', 10, 150, 190, 90);
    doc.addPage();
    doc.addImage(cGender, '', 47, 40, 95, 95);
    doc.addImage(cMonth, '', 10, 155, 190, 90);
    doc.save("Informe K9um.pdf");
  }
</script>