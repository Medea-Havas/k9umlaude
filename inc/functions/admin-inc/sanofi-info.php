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
  let textToCopy = document.getElementById('textToCopy');
  var specialtyChart;
  var provinceChart;
  var genderChart;
  const options = {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  };
  const today = new Date().toLocaleDateString("es-ES", options);

  document.getElementById('hasConsent').addEventListener('change', function(e) {
    resetVisibility();
    hasConsent();
    checkRows();
    getCharts();
  });
  document.getElementById('dateFrom').addEventListener('change', function(e) {
    resetVisibility();
    hasConsent();
    checkRows();
    getCharts();
  });
  document.getElementById('dateTo').addEventListener('change', function(e) {
    resetVisibility();
    hasConsent();
    checkRows();
    getCharts();
  });
  document.getElementById('data').addEventListener('click', function(e) {
    copyText();
  });

  function checkRows() {
    let rows = document.querySelectorAll("#sanofiTable tbody tr");
    let dFrom = document.getElementById('dateFrom').value;
    let dTo = document.getElementById('dateTo').value;
    for (var i = 0; i < rows.length; i++) {
      let reg = rows[i].dataset.registered;
      // From date
      if (dFrom !== null) {
        var fromDate = new Date(dFrom);
        fromDate.toLocaleDateString('es-ES', {
          year: 'numeric',
          month: "2-digit",
          day: "2-digit"
        });
        var fromDateFormat = `${fromDate.getDate()}-${fromDate.getMonth() + 1}-${fromDate.getUTCFullYear()}`;
        var fromDateTime = fromDate.getTime();
      }
      // To date
      if (dTo !== null) {
        var toDate = new Date(dTo);
        toDate.toLocaleDateString('es-ES', {
          year: 'numeric',
          month: "2-digit",
          day: "2-digit"
        });
        var toDateFormat = `${toDate.getDate()}-${toDate.getMonth() + 1}-${toDate.getUTCFullYear()}`;
        var toDateTime = toDate.getTime();
      }
      // Registered date
      var regDateArray = reg.split('-');
      var regDate = new Date(regDateArray[2], regDateArray[1] - 1, regDateArray[0]);
      var regDateTime = regDate.getTime();

      // From - null / To - value
      if (!dFrom && dTo) {
        if (regDateTime > toDateTime) {
          rows[i].classList.add('pokeepsy');
        } else {
          rows[i].classList.remove('pokeepsy');
        }
      }
      // From - value / To - value
      if (dFrom && dTo) {
        if (regDateTime < fromDateTime || regDateTime > toDateTime) {
          rows[i].classList.add('pokeepsy');
        } else {
          rows[i].classList.remove('pokeepsy');
        }
      }
      // From - value / To - null
      if (dFrom && !dTo) {
        if (regDateTime < fromDateTime) {
          rows[i].classList.add('pokeepsy');
        } else {
          rows[i].classList.remove('pokeepsy');
        }
      }
      var countConsent = 0;
      var els = document.getElementsByClassName('consent');
      Array.from(els).forEach((el) => {
        if (!el.parentElement.classList.contains('off') && el.innerHTML == 'NO CONSENT') {
          countConsent++;
        }
      });
      document.querySelector('.noConsentCount').innerHTML = countConsent;
      toggleVisibility('pokeepsy', true);
    }
  }

  function getCharts() {
    /**
     * Users by specialty data
     */
    let specialtiesData = [];
    specialtiesData = document.querySelectorAll("#sanofiTable tbody tr:not(.off) td:nth-child(13)");
    // Reset data
    for (var l = 0; l < specialties.length; l++) {
      specialties[l]['users'] = 0;
    }
    // Set data
    for (var i = 0; i < specialtiesData.length; i++) {
      for (var k = 0; k < specialties.length; k++) {
        if (specialtiesData[i].childNodes[0]) {
          if (specialtiesData[i].childNodes[0].nodeValue === specialties[k]['specialty']) {
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
    let provincesData = [];
    provincesData = document.querySelectorAll("#sanofiTable tbody tr:not(.off) td:nth-child(11)");
    // Reset data
    for (var l = 0; l < provinces.length; l++) {
      provinces[l]['users'] = 0;
    }
    // Set data
    for (var i = 0; i < provincesData.length; i++) {
      for (var k = 0; k < provinces.length; k++) {
        if (provincesData[i].childNodes[0]) {
          if (provincesData[i].childNodes[0].nodeValue === provinces[k]['province']) {
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
    let gendersData = [];
    let genders = [{
        'gender': 'Hombres',
        'users': 0
      },
      {
        'gender': 'Mujeres',
        'users': 0
      },
      {
        'gender': 'N/E',
        'users': 0
      }
    ];
    gendersData = document.querySelectorAll("#sanofiTable tbody tr:not(.off) td:nth-child(12)");
    // Reset data
    for (var l = 0; l < genders.length; l++) {
      genders[l]['users'] = 0;
    }
    // Set data
    var gendersDataInfo = gendersData.length;
    console.log(gendersDataInfo);
    for (var i = 0; i < gendersData.length; i++) {
      for (var k = 0; k < genders.length; k++) {
        if (gendersData[i].childNodes[0]) {
          let gender;
          switch (genders[k]['gender']) {
            case 'Hombres':
              gender = 'M';
              break;
            case 'Mujeres':
              gender = 'F';
              break;
            case 'N/E':
              gender = 'N/E';
              break;
            default:
              break;
          }
          if (gendersData[i].childNodes[0].nodeValue === gender) {
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
  }

  function copyText() {
    textToCopy = document.getElementById('textToCopy');
    navigator.clipboard.writeText(textToCopy.innerText);
    document.getElementById('alert').style.top = '4rem';
    setTimeout(() => {
      document.getElementById('alert').style.top = '-100%';
    }, 3000);
  }

  function hasConsent() {
    var isChecked = document.getElementById('hasConsent').checked;
    toggleVisibility('invisible', isChecked);
  }

  function exportCSV(dis) {
    document.getElementById('datatable3').innerHTML = document.getElementById('sanofiTable').innerHTML;
    removeElementsByClass('off');
    const fileName = 'Integracion_Leads_TEMPLATE NUEVO CURSO_' + today + '_.csv';
    dis.setAttribute('download', fileName);
    return ExcellentExport.csv(dis, 'datatable3');
  }

  function exportExcel(dis) {
    document.getElementById('datatable3').innerHTML = document.getElementById('sanofiTable').innerHTML;
    removeElementsByClass('off');
    const fileName = 'Integracion_Leads_TEMPLATE NUEVO CURSO_' + today + '_.xls';
    dis.setAttribute('download', fileName);
    return ExcellentExport.excel(dis, 'datatable3');

  }

  function removeElementsByClass(className) {
    const elements = document.getElementById('datatable3').getElementsByClassName(className);
    while (elements.length > 0) {
      elements[0].parentNode.removeChild(elements[0]);
    }
  }

  function sendMail() {
    copyText();
    window.open('mailto:adrilg85@gmail.com?subject=Integración BBDD ' + today + ' k9umlaude nueva edición&body=' + encodeURIComponent(textToCopy.innerText));
  }

  function toggleVisibility(className, checked) {
    const elements = document.getElementsByClassName(className);
    for (var u = 0; u < elements.length; u++) {
      if (checked) {
        elements[u].classList.add('off');
      } else {
        elements[u].classList.remove('off');
      }
    }
    removeElementsByClass('off');
  }

  function resetVisibility() {
    const elements = document.querySelectorAll('#sanofiTable tr');
    for (var u = 0; u < elements.length; u++) {
      elements[u].classList.remove('off');
      elements[u].classList.remove('pokeepsy');
    }
  }
</script>