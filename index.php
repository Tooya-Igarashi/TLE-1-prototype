<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

global $db;
require_once 'includes/connection.php';

if (isset($_POST['submit'])) {
    $heart = isset($_POST['heart']) ? 1 : 0;
    $brain = isset($_POST['brain']) ? 1 : 0;
    $glucose = isset($_POST['glucose']) ? 1 : 0;
    $vital = isset($_POST['vital']) ? 1 : 0;

    $query = "UPDATE `permission` SET
        `heart`='$heart', `brain`='$brain', `glucose`='$glucose', `vital`='$vital'
        WHERE `user_id` = 2";
    mysqli_query($db, $query);
}
?>
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
    <a href="index_doctor.php"><button class="button is-light" onclick=>
            <span class="icon">←</span>
            <span>Terug naar vorige pagina</span>
        </button></a>
    <form action="" method="post">
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
                        <input type="checkbox" name="heart" value="1" <?= isset($_POST['heart']) ? 'checked' : '' ?>>
                        <span class="slider round"></span>
                    </label>
                    <button class="button" type="submit" name="submit">Opslaan</button>
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
                        <label class="switch">
                            <input type="checkbox" name="brain" value="1" <?= isset($_POST['brain']) ? 'checked' : '' ?>>
                            <span class="slider round"></span>
                        </label>
                    </label>
                    <button class="button" type="submit" name="submit">Opslaan</button>
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
                        <input type="checkbox" name="glucose" value="1" <?= isset($_POST['glucose']) ? 'checked' : '' ?>>
                        <span class="slider round"></span>
                    </label>
                    <button class="button" type="submit" name="submit">Opslaan</button>
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
                        <input type="checkbox" name="vital" value="1" <?= isset($_POST['vital']) ? 'checked' : '' ?>>
                        <span class="slider round"></span>
                    </label>
                    <button class="button" type="submit" name="submit">Opslaan</button>
                </div>
            </div>
        </div>
    </section>
    </form>

    <script>
        document.querySelectorAll('.switch input[type="checkbox"]').forEach(input => {
            input.addEventListener('change', function() {
                const type = this.closest('.tab-content').id;
                const checked = this.checked;

                if (type === 'heart') {
                    if (checked) {
                        <?= $heart = 1; ?>
                    } else {
                        <?= $heart = 0; ?>
                    }
                } else if (type === 'brain') {
                    if (checked) {
                        <?= $brain = 1; ?>
                    } else {
                        <?= $brain = 0; ?>
                    }
                } else if (type === 'glucose') {
                    if (checked) {
                        <?= $glucose = 1; ?>
                    } else {
                        <?= $glucose = 0; ?>
                    }
                } else if (type === 'vital') {
                    if (checked) {
                        <?= $vital = 1; ?>
                    } else {
                        <?= $vital = 0; ?>
                    }
                }
            });
        });

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
            input.addEventListener('change', function() {
                const type = this.closest('.tab-content').id;
                const value = this.checked ? 1 : 0;
                fetch('update_permission.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: `type=${type}&value=${value}`
                });
            });
        });


        // Initialize charts when page loads
        document.addEventListener('DOMContentLoaded', initCharts);
    </script>

    </body>
    </html>