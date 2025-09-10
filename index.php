<!DOCTYPE html>
<html lang="nl">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Patiëntenmonitor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css" />
    <link rel="stylesheet" href="style.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<!-- Navbar -->
<nav class="navbar is-primary" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="#">
            <!-- Hier kan je logo of tekst -->
            <strong>BetterLifeMedical</strong>
        </a>

        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasic">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="navbarBasic" class="navbar-menu">
        <div class="navbar-start">
            <a class="navbar-item" href="#">Home</a>
            <a class="navbar-item" href="#">Overzicht</a>
            <a class="navbar-item" href="#">Instellingen</a>
        </div>
    </div>
</nav>

<!-- Pagina titel -->
<section class="section">
    <div class="container">
        <h1 class="title has-text-centered">Patiëntenmonitor Dashboard</h1>
    </div>
</section>

<div class="container mt-5 mb-5">
    <div class="columns is-multiline">
        <!-- Heart Rate Monitor -->
        <div class="column is-one-quarter-desktop is-full-mobile mb-5">
            <div class="box">
                <h2 class="subtitle">❤️ Heart Rate Monitor</h2>
                <div style="position: relative; height: 250px; width: 100%;">
                    <canvas id="heartChart"></canvas>
                </div>
                <table class="table is-striped is-fullwidth">
                    <thead>
                    <tr><th>Tijd</th><th>Hartslag (BPM)</th></tr>
                    </thead>
                    <tbody>
                    <tr><td>08:00</td><td>72</td></tr>
                    </tbody>
                </table>
                <h3>Delen met arts</h3>
                <label class="switch">
                    <input type="checkbox" />
                    <span class="slider round"></span>
                </label>
            </div>
        </div>

        <!-- Brain Activity Monitor -->
        <div class="column is-one-quarter-desktop is-full-mobile mb-5">
            <div class="box">
                <h2 class="subtitle">🧠 Brain Activity Monitor</h2>
                <table class="table is-striped is-fullwidth">
                    <thead>
                    <tr><th>Tijd</th><th>EEG Niveau</th></tr>
                    </thead>
                    <tbody>
                    <tr><td>08:00</td><td>Alpha</td></tr>
                    </tbody>
                </table>
                <label class="switch">
                    <input type="checkbox" />
                    <span class="slider round"></span>
                </label>
            </div>
        </div>

        <!-- Glucose Monitor -->
        <div class="column is-one-quarter-desktop is-full-mobile mb-5">
            <div class="box">
                <h2 class="subtitle">🩸 Glucose Monitor</h2>
                <table class="table is-striped is-fullwidth">
                    <thead>
                    <tr><th>Tijd</th><th>Glucose (mg/dL)</th></tr>
                    </thead>
                    <tbody>
                    <tr><td>08:00</td><td>95</td></tr>
                    </tbody>
                </table>
                <label class="switch">
                    <input type="checkbox" />
                    <span class="slider round"></span>
                </label>
            </div>
        </div>

        <!-- Vital Sign Monitor -->
        <div class="column is-one-quarter-desktop is-full-mobile mb-5">
            <div class="box">
                <h2 class="subtitle">🌡️ Vital Sign Monitor</h2>
                <table class="table is-striped is-fullwidth">
                    <thead>
                    <tr><th>Tijd</th><th>Temperatuur</th><th>Bloeddruk</th></tr>
                    </thead>
                    <tbody>
                    <tr><td>08:00</td><td>36.8°C</td><td>120/80</td></tr>
                    </tbody>
                </table>
                <label class="switch">
                    <input type="checkbox" />
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>
</div>

<script>

    fetch('/heart-rate', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ tijd: '08:00', bpm: 72 })
    });

    const express = require('express');
    const mysql = require('mysql2');
    const app = express();
    app.use(express.json());

    const db = mysql.createConnection({
        host: 'localhost',
        user: 'root',
        password: '',
        database: 'patient_monitor'
    });

    app.post('/heart-rate', (req, res) => {
        const { tijd, bpm } = req.body;
        db.query('INSERT INTO heart_rate (tijd, bpm) VALUES (?, ?)', [tijd, bpm], (err) => {
            if (err) return res.status(500).send(err);
            res.send('Data opgeslagen');
        });
    });

    app.listen(3000, () => console.log('Server draait op poort 3000'));

    // Navbar burger toggle voor mobiel
    document.addEventListener('DOMContentLoaded', () => {
        const burger = document.querySelector('.navbar-burger');
        const menu = document.getElementById('navbarBasic');

        burger.addEventListener('click', () => {
            burger.classList.toggle('is-active');
            menu.classList.toggle('is-active');
        });
    });

    // Chart.js setup voor Heart Rate Monitor
    const ctx = document.getElementById('heartChart').getContext('2d');
    const heartChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['08:00', '09:00', '10:00', '11:00', '12:00'],
            datasets: [{
                label: 'Hartslag (BPM)',
                data: [72, 75, 78, 74, 76],
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: false,
                    suggestedMin: 60,
                    suggestedMax: 100
                }
            }
        }
    });

    // Toggle switch alert
    document.querySelectorAll('.switch input').forEach(input => {
        input.addEventListener('change', () => {
            alert("Gegevens gedeeld met arts.");
        });
    });
</script>
</body>
</html>
