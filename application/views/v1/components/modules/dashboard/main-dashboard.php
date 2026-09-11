<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tableau de Bord</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Tableau de Bord</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Stats Cards -->
            <div class="row">
                <!-- Chiffre d'Affaires -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-chart-line"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Chiffre d'Affaires</span>
                            <span class="info-box-number">
                                2.45M
                                <small>FCFA</small>
                            </span>
                            <div class="progress">
                                <div class="progress-bar bg-info" style="width: 70%"></div>
                            </div>
                            <span class="progress-description">+12% ce mois</span>
                        </div>
                    </div>
                </div>

                <!-- Projets en Cours -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-hard-hat"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Projets en Cours</span>
                            <span class="info-box-number">12</span>
                            <div class="progress">
                                <div class="progress-bar bg-success" style="width: 85%"></div>
                            </div>
                            <span class="progress-description">3 livrables ce mois</span>
                        </div>
                    </div>
                </div>

                <!-- Employés -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Employés Actifs</span>
                            <span class="info-box-number">248</span>
                            <div class="progress">
                                <div class="progress-bar bg-warning" style="width: 60%"></div>
                            </div>
                            <span class="progress-description">+5 nouveaux</span>
                        </div>
                    </div>
                </div>

                <!-- Taux de Satisfaction -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-star"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Satisfaction Clients</span>
                            <span class="info-box-number">94%</span>
                            <div class="progress">
                                <div class="progress-bar bg-danger" style="width: 94%"></div>
                            </div>
                            <span class="progress-description">+2% vs mois dernier</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row">
                <!-- Evolution CA -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Evolution du Chiffre d'Affaires</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg">2.45M FCFA</span>
                                    <span>+18.2% vs année dernière</span>
                                </p>
                                <p class="ml-auto d-flex flex-column text-right">
                                    <span class="text-success">
                                        <i class="fas fa-arrow-up"></i> 12.5%
                                    </span>
                                    <span class="text-muted">Ce mois</span>
                                </p>
                            </div>
                            <div class="position-relative mb-4">
                                <canvas id="revenueChart" height="300"></canvas>
                            </div>
                            <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2">
                                    <i class="fas fa-square text-primary"></i> 2026
                                </span>
                                <span>
                                    <i class="fas fa-square text-gray"></i> 2025
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Répartition des Projets -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Répartition des Projets</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="projectsChart" height="300"></canvas>
                            <ul class="mt-3">
                                <li class="d-flex mb-2">
                                    <span class="mr-2"><i class="fas fa-circle text-primary"></i></span>
                                    <span>Résidentiel <span class="float-right text-muted">45%</span></span>
                                </li>
                                <li class="d-flex mb-2">
                                    <span class="mr-2"><i class="fas fa-circle text-success"></i></span>
                                    <span>Commercial <span class="float-right text-muted">30%</span></span>
                                </li>
                                <li class="d-flex mb-2">
                                    <span class="mr-2"><i class="fas fa-circle text-warning"></i></span>
                                    <span>Industriel <span class="float-right text-muted">15%</span></span>
                                </li>
                                <li class="d-flex">
                                    <span class="mr-2"><i class="fas fa-circle text-danger"></i></span>
                                    <span>Infrastructure <span class="float-right text-muted">10%</span></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Projects Table & Activity -->
            <div class="row">
                <!-- Projets Récents -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Projets Récents</h3>
                            <div class="card-tools">
                                <a href="#" class="btn btn-tool btn-primary">
                                    <i class="fas fa-plus"></i> Nouveau Projet
                                </a>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped table-valign-middle">
                                <thead>
                                    <tr>
                                        <th>Projet</th>
                                        <th>Client</th>
                                        <th>Budget</th>
                                        <th>Progression</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <img src="dist/img/default-project.png" alt="Projet"
                                                class="img-circle img-size-32 mr-2">
                                            Résidence Les Palmiers
                                        </td>
                                        <td>SOCIETE IMMO</td>
                                        <td>450M FCFA</td>
                                        <td>
                                            <div class="progress progress-xs">
                                                <div class="progress-bar bg-success" style="width: 75%"></div>
                                            </div>
                                            <small class="text-muted">75%</small>
                                        </td>
                                        <td><span class="badge bg-success">En Cours</span></td>
                                        <td>
                                            <a href="#" class="text-muted"><i class="fas fa-edit"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img src="dist/img/default-project.png" alt="Projet"
                                                class="img-circle img-size-32 mr-2">
                                            Centre Commercial Nord
                                        </td>
                                        <td>GROUPE COMMERCIAL</td>
                                        <td>1.2M FCFA</td>
                                        <td>
                                            <div class="progress progress-xs">
                                                <div class="progress-bar bg-warning" style="width: 45%"></div>
                                            </div>
                                            <small class="text-muted">45%</small>
                                        </td>
                                        <td><span class="badge bg-warning">En Cours</span></td>
                                        <td>
                                            <a href="#" class="text-muted"><i class="fas fa-edit"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img src="dist/img/default-project.png" alt="Projet"
                                                class="img-circle img-size-32 mr-2">
                                            Usine de Traitement
                                        </td>
                                        <td>INDUSTRIE PLUS</td>
                                        <td>850M FCFA</td>
                                        <td>
                                            <div class="progress progress-xs">
                                                <div class="progress-bar bg-info" style="width: 90%"></div>
                                            </div>
                                            <small class="text-muted">90%</small>
                                        </td>
                                        <td><span class="badge bg-info">Presque Terminé</span></td>
                                        <td>
                                            <a href="#" class="text-muted"><i class="fas fa-edit"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img src="dist/img/default-project.png" alt="Projet"
                                                class="img-circle img-size-32 mr-2">
                                            Pont Autoroutier A3
                                        </td>
                                        <td>MINISTERE INFRA</td>
                                        <td>2.1M FCFA</td>
                                        <td>
                                            <div class="progress progress-xs">
                                                <div class="progress-bar bg-danger" style="width: 25%"></div>
                                            </div>
                                            <small class="text-muted">25%</small>
                                        </td>
                                        <td><span class="badge bg-danger">Démarrage</span></td>
                                        <td>
                                            <a href="#" class="text-muted"><i class="fas fa-edit"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <a href="#" class="btn btn-sm btn-info float-left">Voir Tous les Projets</a>
                            <a href="#" class="btn btn-sm btn-secondary float-right">Exporter PDF</a>
                        </div>
                    </div>
                </div>

                <!-- Activités Récentes -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Activités Récentes</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <ul class="products-list product-list-in-card pl-2 pr-2">
                                <li class="item">
                                    <div class="product-img">
                                        <i class="fas fa-check-circle text-success fa-2x"></i>
                                    </div>
                                    <div class="product-info">
                                        <a href="#" class="product-title">Phase 1 terminée - Résidence Palmiers</a>
                                        <span class="product-description">Gros œuvre achevé</span>
                                        <div class="product-price">
                                            <span class="text-success">Aujourd'hui</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="product-img">
                                        <i class="fas fa-file-invoice text-primary fa-2x"></i>
                                    </div>
                                    <div class="product-info">
                                        <a href="#" class="product-title">Facture #2026-089 approuvée</a>
                                        <span class="product-description">Montant: 45M FCFA</span>
                                        <div class="product-price">
                                            <span class="text-muted">Hier</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="product-img">
                                        <i class="fas fa-users text-warning fa-2x"></i>
                                    </div>
                                    <div class="product-info">
                                        <a href="#" class="product-title">Nouveau personnel affecté</a>
                                        <span class="product-description">5 ingénieurs sur Centre Commercial</span>
                                        <div class="product-price">
                                            <span class="text-muted">2 jours</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="product-img">
                                        <i class="fas fa-exclamation-triangle text-danger fa-2x"></i>
                                    </div>
                                    <div class="product-info">
                                        <a href="#" class="product-title">Alerte: Retard livraison matériaux</a>
                                        <span class="product-description">Usine de Traitement</span>
                                        <div class="product-price">
                                            <span class="text-muted">3 jours</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="product-img">
                                        <i class="fas fa-handshake text-info fa-2x"></i>
                                    </div>
                                    <div class="product-info">
                                        <a href="#" class="product-title">Nouveau contrat signé</a>
                                        <span class="product-description">Villa Luxe - 120M FCFA</span>
                                        <div class="product-price">
                                            <span class="text-muted">1 semaine</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="card-footer text-center">
                            <a href="#" class="uppercase">Voir Toutes les Activités</a>
                        </div>
                    </div>

                    <!-- Alertes -->
                    <div class="card bg-gradient-danger">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                Alertes
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <i class="fas fa-clock mr-2"></i>
                                    3 projets en retard de planning
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-dollar-sign mr-2"></i>
                                    5 factures en attente de paiement
                                </li>
                                <li>
                                    <i class="fas fa-hard-hat mr-2"></i>
                                    2 inspections de sécurité requises
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Calendrier & Tâches -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="far fa-calendar-alt mr-1"></i>
                                Calendrier des Livraisons
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tâches Prioritaires</h3>
                            <div class="card-tools">
                                <span class="badge badge-danger">3 Urgentes</span>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <ul class="todo-list m-2">
                                <li>
                                    <span class="handle">
                                        <i class="fas fa-ellipsis-v"></i>
                                        <i class="fas fa-ellipsis-v"></i>
                                    </span>
                                    <div class="icheck-primary d-inline ml-2">
                                        <input type="checkbox" id="todoCheck1">
                                        <label for="todoCheck1"></label>
                                    </div>
                                    <div class="todo-text">
                                        <span class="text-danger">Approuver devis électricité</span>
                                        <br>
                                        <small>Résidence Palmiers - Échéance: Demain</small>
                                    </div>
                                    <div class="tools">
                                        <i class="fas fa-trash text-danger"></i>
                                    </div>
                                </li>
                                <li>
                                    <span class="handle">
                                        <i class="fas fa-ellipsis-v"></i>
                                        <i class="fas fa-ellipsis-v"></i>
                                    </span>
                                    <div class="icheck-primary d-inline ml-2">
                                        <input type="checkbox" id="todoCheck2">
                                        <label for="todoCheck2"></label>
                                    </div>
                                    <div class="todo-text">
                                        <span class="text-warning">Réunion de chantier</span>
                                        <br>
                                        <small>Centre Commercial - 10h00</small>
                                    </div>
                                    <div class="tools">
                                        <i class="fas fa-trash text-danger"></i>
                                    </div>
                                </li>
                                <li>
                                    <span class="handle">
                                        <i class="fas fa-ellipsis-v"></i>
                                        <i class="fas fa-ellipsis-v"></i>
                                    </span>
                                    <div class="icheck-primary d-inline ml-2">
                                        <input type="checkbox" id="todoCheck3" checked>
                                        <label for="todoCheck3"></label>
                                    </div>
                                    <div class="todo-text">
                                        <span class="text-success">Rapport mensuel soumis</span>
                                        <br>
                                        <small>Direction Générale</small>
                                    </div>
                                    <div class="tools">
                                        <i class="fas fa-trash text-danger"></i>
                                    </div>
                                </li>
                                <li>
                                    <span class="handle">
                                        <i class="fas fa-ellipsis-v"></i>
                                        <i class="fas fa-ellipsis-v"></i>
                                    </span>
                                    <div class="icheck-primary d-inline ml-2">
                                        <input type="checkbox" id="todoCheck4">
                                        <label for="todoCheck4"></label>
                                    </div>
                                    <div class="todo-text">
                                        <span class="text-muted">Commander matériaux</span>
                                        <br>
                                        <small>Usine de Traitement</small>
                                    </div>
                                    <div class="tools">
                                        <i class="fas fa-trash text-danger"></i>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="card-footer clearfix">
                            <button type="button" class="btn btn-info float-right">
                                <i class="fas fa-plus"></i> Ajouter une tâche
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Scripts pour les graphiques -->
<script>
    $(document).ready(function() {
        // Graphique Evolution CA
        var revenueChart = new Chart($('#revenueChart'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov',
                    'Déc'
                ],
                datasets: [{
                        label: '2026',
                        borderColor: '#3498db',
                        backgroundColor: 'rgba(52, 152, 219, 0.1)',
                        data: [180, 210, 195, 230, 245, 260, 275, 290, 310, 325, 340, 355],
                        fill: true
                    },
                    {
                        label: '2025',
                        borderColor: '#95a5a6',
                        backgroundColor: 'rgba(149, 165, 166, 0.1)',
                        data: [150, 175, 165, 190, 200, 215, 230, 245, 260, 275, 290, 305],
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        ticks: {
                            callback: function(value) {
                                return value + 'K';
                            }
                        }
                    }
                }
            }
        });

        // Graphique Répartition Projets
        var projectsChart = new Chart($('#projectsChart'), {
            type: 'doughnut',
            data: {
                labels: ['Résidentiel', 'Commercial', 'Industriel', 'Infrastructure'],
                datasets: [{
                    data: [45, 30, 15, 10],
                    backgroundColor: [
                        '#3498db',
                        '#2ecc71',
                        '#f1c40f',
                        '#e74c3c'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    });
</script>