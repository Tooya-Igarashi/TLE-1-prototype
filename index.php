<!--test test test test test-->

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Patiëntenmonitor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>
    <body>
    <section class="section">
        <div class="container">
            <h1 class="title has-text-centered">🩺 Patiëntenmonitor Dashboard</h1>

            <!-- Tabs -->
            <div class="tabs is-centered is-boxed is-large">
                <ul>
                    <li class="is-active" data-tab="heart"><a>❤️ Heart Rate</a></li>
                    <li data-tab="brain"><a>🧠 Brain Activity</a></li>
                    <li data-tab="glucose"><a>🩸 Glucose</a></li>
                    <li data-tab="vital"><a>🌡️ Vital Signs</a></li>
                </ul>
            </div>

            <!-- Tab Content -->
            <div id="heart" class="tab-content is-active">
                <h2 class="subtitle">Heart Rate & Blood Pressure Monitor</h2>
                <div class="chart-container">
                    <canvas id="heartChart" width="400" height="200"></canvas>
                </div>
                <table class="table is-striped is-fullwidth">
                    <thead><tr><th>Tijd</th><th>Hartslag (BPM)</th><th>Bloeddruk</th></tr></thead>
                    <tbody>
                    <tr><td>08:00</td><td>72</td><td>120/80</td></tr>
                    <tr><td>09:00</td><td>75</td><td>118/78</td></tr>
                    <tr><td>10:00</td><td>78</td><td>122/82</td></tr>
                    </tbody>
                </table>
                <div>
                    <h3>Delen met arts</h3>
                    <label class="switch">
                        <input type="checkbox">
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>

            <div id="brain" class="tab-content">
                <h2 class="subtitle">Brain Activity Monitor</h2>
                <div class="chart-container">
                    <canvas id="brainChart" width="400" height="200"></canvas>
                </div>
                <table class="table is-striped is-fullwidth">
                    <thead><tr><th>Tijd</th><th>EEG Niveau</th></tr></thead>
                    <tbody>
                    <tr><td>08:00</td><td>Alpha</td></tr>
                    <tr><td>09:00</td><td>Beta</td></tr>
                    <tr><td>10:00</td><td>Alpha</td></tr>
                    </tbody>
                </table>
                <div>
                    <h3>Delen met arts</h3>
                    <label class="switch">
                        <input type="checkbox">
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>

            <div id="glucose" class="tab-content">
                <h2 class="subtitle">Glucose Monitor</h2>
                <div class="chart-container">
                    <canvas id="glucoseChart" width="400" height="200"></canvas>
                </div>
                <table class="table is-striped is-fullwidth">
                    <thead><tr><th>Tijd</th><th>Glucose (mg/dL)</th></tr></thead>
                    <tbody>
                    <tr><td>08:00</td><td>95</td></tr>
                    <tr><td>09:00</td><td>102</td></tr>
                    <tr><td>10:00</td><td>98</td></tr>
                    </tbody>
                </table>
                <div>
                    <h3>Delen met arts</h3>
                    <label class="switch">
                        <input type="checkbox">
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>

            <div id="vital" class="tab-content">
                <h2 class="subtitle">Vital Sign Monitor</h2>
                <div class="chart-container">
                    <canvas id="vitalChart" width="400" height="200"></canvas>
                </div>
                <table class="table is-striped is-fullwidth">
                    <thead><tr><th>Tijd</th><th>Temperatuur</th><th>Ademhalingsfrequentie</th></tr></thead>
                    <tbody>
                    <tr><td>08:00</td><td>36.8°C</td><td>16</td></tr>
                    <tr><td>09:00</td><td>36.9°C</td><td>15</td></tr>
                    <tr><td>10:00</td><td>37.0°C</td><td>17</td></tr>
                    </tbody>
                </table>
                <div>
                    <h3>Delen met arts</h3>
                    <label class="switch">
                        <input type="checkbox">
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Chart configurations for each tab
        const chartConfigs = {
            heart: {
                type: 'line',
                data: {
                    labels: ['08:00', '09:00', '10:00', '11:00', '12:00'],
                    datasets: [
                        {
                            label: 'Hartslag (BPM)',
                            data: [72, 75, 78, 74, 76],
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.3,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Bloeddruk (systolisch)',
                            data: [120, 118, 122, 119, 121],
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 2,
                            fill: false,
                            tension: 0.3,
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: false,
                            suggestedMin: 60,
                            suggestedMax: 100,
                            title: {
                                display: true,
                                text: 'Hartslag (BPM)'
                            }
                        },
                        y1: {
                            beginAtZero: false,
                            position: 'right',
                            suggestedMin: 110,
                            suggestedMax: 130,
                            title: {
                                display: true,
                                text: 'Bloeddruk'
                            },
                            grid: {
                                drawOnChartArea: false
                            }
                        }
                    }
                }
            },
            brain: {
                type: 'line',
                data: {
                    labels: ['08:00', '09:00', '10:00', '11:00', '12:00'],
                    datasets: [{
                        label: 'EEG Activiteit',
                        data: [5, 7, 6, 8, 7],
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: false,
                            suggestedMin: 0,
                            suggestedMax: 10
                        }
                    }
                }
            },
            glucose: {
                type: 'line',
                data: {
                    labels: ['08:00', '09:00', '10:00', '11:00', '12:00'],
                    datasets: [{
                        label: 'Glucose (mg/dL)',
                        data: [95, 102, 98, 105, 100],
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: false,
                            suggestedMin: 80,
                            suggestedMax: 120
                        }
                    }
                }
            },
            vital: {
                type: 'line',
                data: {
                    labels: ['08:00', '09:00', '10:00', '11:00', '12:00'],
                    datasets: [
                        {
                            label: 'Temperatuur (°C)',
                            data: [36.8, 36.9, 37.0, 36.8, 36.7],
                            backgroundColor: 'rgba(255, 159, 64, 0.2)',
                            borderColor: 'rgba(255, 159, 64, 1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.3
                        },
                        {
                            label: 'Ademhalingsfrequentie',
                            data: [16, 15, 17, 16, 15],
                            backgroundColor: 'rgba(255, 205, 86, 0.2)',
                            borderColor: 'rgba(255, 205, 86, 1)',
                            borderWidth: 2,
                            fill: false,
                            tension: 0.3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: false
                        }
                    }
                }
            }
        };

        // Initialize all charts
        function initCharts() {
            for (const [tabName, config] of Object.entries(chartConfigs)) {
                const ctx = document.getElementById(`${tabName}Chart`).getContext('2d');
                window[`${tabName}Chart`] = new Chart(ctx, config);
            }
        }

        // Tab switching functionality
        const tabs = document.querySelectorAll(".tabs ul li");
        const contents = document.querySelectorAll(".tab-content");

        tabs.forEach(tab => {
            tab.addEventListener("click", () => {
                tabs.forEach(t => t.classList.remove("is-active"));
                tab.classList.add("is-active");

                contents.forEach(c => c.classList.remove("is-active"));
                document.getElementById(tab.dataset.tab).classList.add("is-active");
            });
        });

        // Toggle switch functionality
        document.querySelectorAll('.switch input').forEach(input => {
            input.addEventListener('change', () => {
                alert("Gegevens gedeeld met arts.");
            });
        });

        // Initialize charts when page loads
        document.addEventListener('DOMContentLoaded', initCharts);
    </script>

    </body>
    </html>