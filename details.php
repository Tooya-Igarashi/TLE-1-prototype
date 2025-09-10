<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index_doctor.php');
    exit();
}

/** @var mysqli $db */
require_once 'includes/connection.php';

$id = mysqli_escape_string($db, $_GET['id']);

// Fetch patient health data
$query = "SELECT * FROM health WHERE id = $id";
$result = mysqli_query($db, $query) or die('Error ' . mysqli_error($db) . ' with query ' . $query);
$health = mysqli_fetch_assoc($result);

// Fetch patient permissions
$perm_query = "SELECT * FROM permission WHERE user_id = $id";
$perm_result = mysqli_query($db, $perm_query);
$permissions = mysqli_fetch_assoc($perm_result);

mysqli_close($db);

// Helper for badge
function permission_badge($allowed) {
    if ($allowed) {
        return '<span class="tag is-success permission-badge">Gedeeld door patiënt</span>';
    } else {
        return '<span class="tag is-danger permission-badge">Niet gedeeld door patiënt</span>';
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Artsen Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .hidden-data {
            background-color: #f5f5f5;
            color: #999;
            font-style: italic;
        }
        .permission-badge {
            margin-left: 10px;
            font-size: 0.8rem;
        }
        .tab-content {
            display: none;
        }
        .tab-content.is-active {
            display: block;
        }
    </style>
</head>
<body>
<a href="index_doctor.php"><button class="button is-light">
        <span class="icon">←</span>
        <span>Terug naar vorige pagina</span>
    </button></a>
<section class="section">
    <div class="container">
        <h1 class="title has-text-centered">Artsen Dashboard - <?=htmlentities($health['name'] ?? '')?></h1>

        <div class="notification is-info">
            <p>Patiënt heeft bepaalde gegevensafschermingen ingesteld. <strong>Grijs gemarkeerde data</strong> is niet gedeeld door de patiënt.</p>
        </div>

        <div class="tabs is-centered is-boxed is-large">
            <ul>
                <li class="is-active" data-tab="heart"><a>Hartslag & Bloeddruk</a></li>
                <li data-tab="brain"><a>Hersenactiviteit</a></li>
                <li data-tab="glucose"><a>Glucose</a></li>
                <li data-tab="vital"><a>Vitale functies</a></li>
            </ul>
        </div>

        <!-- Heart Tab -->
        <div id="heart" class="tab-content is-active">
            <h2 class="subtitle">Hartslag & Bloeddruk Monitor
                <?= permission_badge($permissions['heart'] ?? 0) ?>
            </h2>
            <div class="box">
                <canvas id="heartChart" width="400" height="200"></canvas>
            </div>
            <table class="table is-striped is-fullwidth">
                <thead><tr><th>Tijd</th><th>Hartslag (BPM)</th><th>Bloeddruk</th></tr></thead>
                <tbody>
                <?php if ($permissions['heart']) { ?>
                    <tr><td>08:00</td><td>72</td><td>120/80</td></tr>
                    <tr><td>09:00</td><td>75</td><td>118/78</td></tr>
                    <tr><td>10:00</td><td>78</td><td>122/82</td></tr>
                <?php } else { ?>
                    <tr class="hidden-data"><td colspan="3">Niet gedeeld</td></tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Brain Tab -->
        <div id="brain" class="tab-content">
            <h2 class="subtitle">Hersenactiviteit Monitor
                <?= permission_badge($permissions['brain'] ?? 0) ?>
            </h2>
            <div class="box">
                <canvas id="brainChart" width="400" height="200"></canvas>
            </div>
            <table class="table is-striped is-fullwidth">
                <thead><tr><th>Tijd</th><th>EEG Niveau</th></tr></thead>
                <tbody>
                <?php if ($permissions['brain']) { ?>
                    <tr><td>08:00</td><td>Alpha</td></tr>
                    <tr><td>09:00</td><td>Beta</td></tr>
                    <tr><td>10:00</td><td>Alpha</td></tr>
                <?php } else { ?>
                    <tr class="hidden-data"><td>08:00</td><td>Niet gedeeld</td></tr>
                    <tr class="hidden-data"><td>09:00</td><td>Niet gedeeld</td></tr>
                    <tr class="hidden-data"><td>10:00</td><td>Niet gedeeld</td></tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Glucose Tab -->
        <div id="glucose" class="tab-content">
            <h2 class="subtitle">Glucose Monitor
                <?= permission_badge($permissions['glucose'] ?? 0) ?>
            </h2>
            <div class="box">
                <canvas id="glucoseChart" width="400" height="200"></canvas>
            </div>
            <table class="table is-striped is-fullwidth">
                <thead><tr><th>Tijd</th><th>Glucose (mg/dL)</th></tr></thead>
                <tbody>
                <?php if ($permissions['glucose']) { ?>
                    <tr><td>08:00</td><td>95</td></tr>
                    <tr><td>09:00</td><td>102</td></tr>
                    <tr><td>10:00</td><td>98</td></tr>
                <?php } else { ?>
                    <tr class="hidden-data"><td>08:00</td><td>Niet gedeeld</td></tr>
                    <tr class="hidden-data"><td>09:00</td><td>Niet gedeeld</td></tr>
                    <tr class="hidden-data"><td>10:00</td><td>Niet gedeeld</td></tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Vital Tab -->
        <div id="vital" class="tab-content">
            <h2 class="subtitle">Vitale Functies Monitor
                <?= permission_badge($permissions['vital'] ?? 0) ?>
            </h2>
            <div class="box">
                <canvas id="vitalChart" width="400" height="200"></canvas>
            </div>
            <table class="table is-striped is-fullwidth">
                <thead><tr><th>Tijd</th><th>Temperatuur</th><th>Ademhalingsfrequentie</th></tr></thead>
                <tbody>
                <?php if ($permissions['vital']) { ?>
                    <tr><td>08:00</td><td>36.8°C</td><td>16</td></tr>
                    <tr><td>09:00</td><td>36.9°C</td><td>15</td></tr>
                    <tr><td>10:00</td><td>37.0°C</td><td>17</td></tr>
                <?php } else { ?>
                    <tr class="hidden-data"><td>08:00</td><td>Niet gedeeld</td><td>Niet gedeeld</td></tr>
                    <tr class="hidden-data"><td>09:00</td><td>Niet gedeeld</td><td>Niet gedeeld</td></tr>
                    <tr class="hidden-data"><td>10:00</td><td>Niet gedeeld</td><td>Niet gedeeld</td></tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<script>
    // Chart configs (show empty data if not shared)
    const permissions = {
        heart: <?= $permissions['heart'] ? 'true' : 'false' ?>,
        brain: <?= $permissions['brain'] ? 'true' : 'false' ?>,
        glucose: <?= $permissions['glucose'] ? 'true' : 'false' ?>,
        vital: <?= $permissions['vital'] ? 'true' : 'false' ?>
    };

    const chartConfigs = {
        heart: {
            type: 'line',
            data: {
                labels: ['08:00', '09:00', '10:00', '11:00', '12:00'],
                datasets: [
                    {
                        label: 'Hartslag (BPM)',
                        data: permissions.heart ? [72, 75, 78, 74, 76] : [null, null, null, null, null],
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3
                    },
                    {
                        label: 'Bloeddruk (systolisch)',
                        data: permissions.heart ? [120, 118, 122, 119, 121] : [null, null, null, null, null],
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2,
                        fill: false,
                        tension: 0.3
                    }
                ]
            },
            options: { responsive: true }
        },
        brain: {
            type: 'line',
            data: {
                labels: ['08:00', '09:00', '10:00', '11:00', '12:00'],
                datasets: [{
                    label: permissions.brain ? 'EEG Activiteit' : 'EEG Activiteit (niet gedeeld)',
                    data: permissions.brain ? [5, 7, 6, 8, 7] : [null, null, null, null, null],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: { responsive: true }
        },
        glucose: {
            type: 'line',
            data: {
                labels: ['08:00', '09:00', '10:00', '11:00', '12:00'],
                datasets: [{
                    label: 'Glucose (mg/dL)',
                    data: permissions.glucose ? [95, 102, 98, 105, 100] : [null, null, null, null, null],
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: { responsive: true }
        },
        vital: {
            type: 'line',
            data: {
                labels: ['08:00', '09:00', '10:00', '11:00', '12:00'],
                datasets: [
                    {
                        label: 'Temperatuur (°C)',
                        data: permissions.vital ? [36.8, 36.9, 37.0, 36.8, 36.7] : [null, null, null, null, null],
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3
                    },
                    {
                        label: 'Ademhalingsfrequentie',
                        data: permissions.vital ? [16, 15, 17, 16, 15] : [null, null, null, null, null],
                        backgroundColor: 'rgba(255, 205, 86, 0.2)',
                        borderColor: 'rgba(255, 205, 86, 1)',
                        borderWidth: 2,
                        fill: false,
                        tension: 0.3
                    }
                ]
            },
            options: { responsive: true }
        }
    };

    // Initialize all charts
    function initCharts() {
        for (const [tabName, config] of Object.entries(chartConfigs)) {
            const ctx = document.getElementById(`${tabName}Chart`).getContext('2d');
            window[`${tabName}Chart`] = new Chart(ctx, config);
        }
    }

    // Tab switching
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

    document.addEventListener('DOMContentLoaded', initCharts);
</script>
</body>
</html>
