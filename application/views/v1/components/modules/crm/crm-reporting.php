<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-chart-line text-primary"></i> Reporting & Statistiques
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">CRM & Clients</a></li>
                        <li class="breadcrumb-item active">Reporting</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Filtres et Export -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-filter"></i> Filtres
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Période</label>
                                        <select class="form-control" id="periodeSelect">
                                            <option value="today">Aujourd'hui</option>
                                            <option value="yesterday">Hier</option>
                                            <option value="week" selected>Cette Semaine</option>
                                            <option value="month">Ce Mois</option>
                                            <option value="year">Cette Année</option>
                                            <option value="custom">Personnalisé</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Date Début</label>
                                        <input type="date" class="form-control" id="dateDebut" value="2026-01-01">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Date Fin</label>
                                        <input type="date" class="form-control" id="dateFin" value="2026-12-31">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button type="button" class="btn btn-primary btn-block" id="btnAppliquer">
                                            <i class="fas fa-sync"></i> Appliquer
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 text-right">
                                    <button type="button" class="btn btn-success btn-sm mr-2" id="btnExportPDF">
                                        <i class="fas fa-file-pdf"></i> Exporter PDF
                                    </button>
                                    <button type="button" class="btn btn-info btn-sm mr-2" id="btnExportExcel">
                                        <i class="fas fa-file-excel"></i> Exporter Excel
                                    </button>
                                    <button type="button" class="btn btn-secondary btn-sm" id="btnImprimer">
                                        <i class="fas fa-print"></i> Imprimer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KPIs Cards -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>124</h3>
                            <p>Total Clients</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            +12 ce mois <i class="fas fa-arrow-up"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>87</h3>
                            <p>Devis Émis</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            +8 ce mois <i class="fas fa-arrow-up"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>34.5%</h3>
                            <p>Taux Transformation</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-percentage"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            -2.3% <i class="fas fa-arrow-down text-danger"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>245M DA</h3>
                            <p>CA Prévisionnel</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            +15% <i class="fas fa-arrow-up"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Graphiques Principaux -->
            <div class="row">
                <!-- Évolution Mensuelle -->
                <div class="col-md-6">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-line"></i> Évolution Mensuelle des Devis
                            </h3>
                        </div>
                        <div class="card-body">
                            <!-- IMPORTANT: div au lieu de canvas pour ApexCharts -->
                            <div id="chartEvolution" style="height: 320px; width: 100%;"></div>
                        </div>
                    </div>
                </div>

                <!-- Répartition par Type de Client -->
                <div class="col-md-6">
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie"></i> Répartition des Clients
                            </h3>
                        </div>
                        <div class="card-body">
                            <div id="chartClients" style="height: 320px; width: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistiques par Projet -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-project-diagram"></i> Performance des Projets
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Projet</th>
                                            <th>Client</th>
                                            <th>Montant Total</th>
                                            <th style="width: 150px;">% Avancement</th>
                                            <th style="width: 150px;">% Décaissé</th>
                                            <th>Écart</th>
                                            <th>Statut</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>Construction Université Oran</strong></td>
                                            <td>Ministère Éducation</td>
                                            <td>10,000,000 DA</td>
                                            <td>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-success" style="width: 45%">45%</div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-warning" style="width: 30%">30%</div>
                                                </div>
                                            </td>
                                            <td><span class="badge badge-success">+15%</span></td>
                                            <td><span class="badge badge-success">En cours</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Hôpital Régional Annaba</strong></td>
                                            <td>Wilaya d'Annaba</td>
                                            <td>15,500,000 DA</td>
                                            <td>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-success" style="width: 60%">60%</div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-success" style="width: 55%">55%</div>
                                                </div>
                                            </td>
                                            <td><span class="badge badge-success">+5%</span></td>
                                            <td><span class="badge badge-success">En cours</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Complexe Sportif Constantine</strong></td>
                                            <td>Ministère Sports</td>
                                            <td>8,200,000 DA</td>
                                            <td>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar" style="width: 0%">0%</div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar" style="width: 0%">0%</div>
                                                </div>
                                            </td>
                                            <td><span class="badge badge-secondary">0%</span></td>
                                            <td><span class="badge badge-warning">Planification</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Centre Commercial Alger</strong></td>
                                            <td>SARL ImmoPlus</td>
                                            <td>20,000,000 DA</td>
                                            <td>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-success" style="width: 85%">85%</div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-info" style="width: 80%">80%</div>
                                                </div>
                                            </td>
                                            <td><span class="badge badge-success">+5%</span></td>
                                            <td><span class="badge badge-success">En cours</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<!-- ApexCharts CDN -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.44.0/dist/apexcharts.min.js"></script>

<!-- Script isolé dans une IIFE pour éviter les conflits -->
<script>
(function() {
    'use strict';

    // Attendre que TOUT soit chargé (images, scripts externes, etc.)
    window.addEventListener('load', function() {
        console.log('🎯 Page complètement chargée');

        // Vérifier qu'ApexCharts est disponible
        if (typeof ApexCharts === 'undefined') {
            console.error('❌ ApexCharts non chargé');
            return;
        }

        console.log('✅ ApexCharts disponible');

        // Petit délai pour s'assurer que les conteneurs sont bien dimensionnés
        setTimeout(function() {
            creerGraphiqueEvolution();
            creerGraphiqueClients();
        }, 300);
    });

    function creerGraphiqueEvolution() {
        var container = document.getElementById('chartEvolution');
        if (!container) {
            console.error('❌ Container chartEvolution introuvable');
            return;
        }

        var options = {
            series: [{
                name: 'Devis Émis',
                data: [5, 8, 12, 7, 10, 15, 9, 11, 14, 8, 6, 10]
            }, {
                name: 'Devis Acceptés',
                data: [2, 3, 5, 3, 4, 6, 3, 4, 5, 3, 2, 4]
            }],
            chart: {
                height: 300,
                type: 'area',
                fontFamily: 'inherit',
                toolbar: {
                    show: false
                }
            },
            colors: ['#36a2eb', '#4bc0c0'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.05,
                    stops: [0, 100]
                }
            },
            xaxis: {
                categories: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov',
                    'Déc'
                ]
            },
            yaxis: {
                beginAtZero: true
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right'
            },
            grid: {
                borderColor: '#e7e7e7',
                strokeDashArray: 4
            }
        };

        try {
            var chart = new ApexCharts(container, options);
            chart.render();
            console.log('✅ Graphique Évolution rendu');
        } catch (e) {
            console.error(' Erreur Evolution:', e);
        }
    }

    function creerGraphiqueClients() {
        var container = document.getElementById('chartClients');
        if (!container) {
            console.error('❌ Container chartClients introuvable');
            return;
        }

        var options = {
            series: [98, 18, 8],
            chart: {
                height: 300,
                type: 'donut',
                fontFamily: 'inherit'
            },
            colors: ['#36a2eb', '#ff6384', '#ffcd56'],
            labels: ['Entreprises', 'Secteur Public', 'Particuliers'],
            legend: {
                position: 'bottom'
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total Clients',
                                fontSize: '14px',
                                formatter: function() {
                                    return '124';
                                }
                            }
                        }
                    }
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function(val) {
                    return val.toFixed(1) + '%';
                }
            }
        };

        try {
            var chart = new ApexCharts(container, options);
            chart.render();
            console.log('✅ Graphique Clients rendu');
        } catch (e) {
            console.error('❌ Erreur Clients:', e);
        }
    }

    // Gestion des boutons
    document.addEventListener('click', function(e) {
        var target = e.target.closest('button');
        if (!target) return;

        if (target.id === 'btnAppliquer') {
            var periode = document.getElementById('periodeSelect').value;
            alert('Filtres appliqués: ' + periode);
        }
        if (target.id === 'btnExportPDF') {
            alert('Export PDF en cours...');
        }
        if (target.id === 'btnExportExcel') {
            alert('Export Excel en cours...');
        }
        if (target.id === 'btnImprimer') {
            window.print();
        }
    });
})();
</script>

<style>
/* Forcer les dimensions des conteneurs de graphiques */
#chartEvolution,
#chartClients {
    min-height: 300px !important;
    height: 320px !important;
    width: 100% !important;
}

/* S'assurer que les small-box ont une hauteur fixe */
.small-box {
    min-height: 140px;
}

/* Ajustement pour l'impression */
@media print {
    .no-print {
        display: none !important;
    }

    .card {
        break-inside: avoid;
    }
}
</style>