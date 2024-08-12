/**
 * Dashboard eCommerce
 */

'use strict';

(function () {
  let cardColor, labelColor, headingColor, borderColor, legendColor;

  if (isDarkStyle) {
    cardColor = config.colors_dark.cardColor;
    labelColor = config.colors_dark.textMuted;
    legendColor = config.colors_dark.bodyColor;
    headingColor = config.colors_dark.headingColor;
    borderColor = config.colors_dark.borderColor;
  } else {
    cardColor = config.colors.cardColor;
    labelColor = config.colors.textMuted;
    legendColor = config.colors.bodyColor;
    headingColor = config.colors.headingColor;
    borderColor = config.colors.borderColor;
  }

  // Donut Chart Colors
  const chartColors = {
    donut: {
      series1: config.colors.success,
      series2: '#28c76fb3',
      series3: '#28c76f80',
      series4: config.colors_label.success
    }
  };

  // Expenses Radial Bar Chart
  // --------------------------------------------------------------------
  const expensesRadialChartEl = document.querySelector('#expensesChart'),
    expensesRadialChartConfig = {
      chart: {
        height: 145,
        sparkline: {
          enabled: true
        },
        parentHeightOffset: 0,
        type: 'radialBar'
      },
      colors: [config.colors.warning],
      series: [78],
      plotOptions: {
        radialBar: {
          offsetY: 0,
          startAngle: -90,
          endAngle: 90,
          hollow: {
            size: '65%'
          },
          track: {
            strokeWidth: '45%',
            background: borderColor
          },
          dataLabels: {
            name: {
              show: false
            },
            value: {
              fontSize: '22px',
              color: headingColor,
              fontWeight: 600,
              offsetY: -5
            }
          }
        }
      },
      grid: {
        show: false,
        padding: {
          bottom: 5
        }
      },
      stroke: {
        lineCap: 'round'
      },
      labels: ['Progress'],
      responsive: [
        {
          breakpoint: 1442,
          options: {
            chart: {
              height: 120
            },
            plotOptions: {
              radialBar: {
                dataLabels: {
                  value: {
                    fontSize: '18px'
                  }
                },
                hollow: {
                  size: '60%'
                }
              }
            }
          }
        },
        {
          breakpoint: 1025,
          options: {
            chart: {
              height: 136
            },
            plotOptions: {
              radialBar: {
                hollow: {
                  size: '65%'
                },
                dataLabels: {
                  value: {
                    fontSize: '18px'
                  }
                }
              }
            }
          }
        },
        {
          breakpoint: 769,
          options: {
            chart: {
              height: 120
            },
            plotOptions: {
              radialBar: {
                hollow: {
                  size: '55%'
                }
              }
            }
          }
        },
        {
          breakpoint: 426,
          options: {
            chart: {
              height: 145
            },
            plotOptions: {
              radialBar: {
                hollow: {
                  size: '65%'
                }
              }
            },
            dataLabels: {
              value: {
                offsetY: 0
              }
            }
          }
        },
        {
          breakpoint: 376,
          options: {
            chart: {
              height: 105
            },
            plotOptions: {
              radialBar: {
                hollow: {
                  size: '60%'
                }
              }
            }
          }
        }
      ]
    };
  if (typeof expensesRadialChartEl !== undefined && expensesRadialChartEl !== null) {
    const expensesRadialChart = new ApexCharts(expensesRadialChartEl, expensesRadialChartConfig);
    expensesRadialChart.render();
  }

})();
