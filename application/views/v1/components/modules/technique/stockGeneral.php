<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= $title ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><?= $title ?></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">



            <!-- STATISTIQUES -->
            <div class="row">

                <div class="col-lg-3 col-md-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= $stats['total_articles']; ?></h3>
                            <p>Articles enregistrés</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-box"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3><?= $stats['total_emplacements']; ?></h3>
                            <p>Emplacements stock</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= $stats['total_lignes_stock']; ?></h3>
                            <p>Lignes de stock</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-layer-group"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= number_format($stats['quantite_totale'], 2, ',', ' '); ?></h3>
                            <p>Quantité totale</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-warehouse"></i>
                        </div>
                    </div>
                </div>

            </div>

            <!-- FILTRE -->
            <div class="card card-outline card-dark">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-filter mr-1"></i>
                        Filtrage du stock
                    </h3>
                </div>

                <form method="get" action="<?= base_url('stock-general') ?>">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Article</label>
                                    <select name="article_id" class="form-control">
                                        <option value="">Tous les articles</option>
                                        <?php foreach ($articles as $article) : ?>
                                        <option value="<?= $article->id ?>"
                                            <?= ($filter_article_id == $article->id) ? 'selected' : ''; ?>>
                                            <?= $article->code_article; ?> - <?= $article->designation; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Emplacement</label>
                                    <select name="emplacement_id" class="form-control">
                                        <option value="">Tous les emplacements</option>
                                        <?php foreach ($emplacements as $emplacement) : ?>
                                        <option value="<?= $emplacement->id ?>"
                                            <?= ($filter_emplacement_id == $emplacement->id) ? 'selected' : ''; ?>>
                                            <?= $emplacement->nom_emplacement; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label>&nbsp;</label>
                                <div>
                                    <button class="btn btn-dark btn-block">
                                        <i class="fas fa-search"></i> Filtrer
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <!-- BOUTONS -->
            <div class="d-flex justify-content-end mb-3">

                <button class="btn btn-success mr-2" data-toggle="modal" data-target="#addArticleModal">

                    <i class="fas fa-plus"></i>
                    Nouvel article

                </button>

                <button class="btn btn-primary mr-2" data-toggle="modal" data-target="#addEmplacementModal">

                    <i class="fas fa-map-marker-alt"></i>
                    Nouvel emplacement

                </button>

                <button class="btn btn-warning" data-toggle="modal" data-target="#addQuantiteModal">

                    <i class="fas fa-boxes"></i>
                    Ajouter quantité

                </button>

            </div>

            <?php if ($this->session->flashdata('success')) : ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?= $this->session->flashdata('success'); ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            <?php endif; ?>

            <!-- DEUX COLONNES -->
            <div class="row">

                <!-- COLONNE 1 : STOCK PAR EMPLACEMENT -->
                <div class="col-md-8">
                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-warehouse mr-1"></i>
                                Quantité de stock par article et emplacement
                            </h3>
                        </div>

                        <div class="card-body table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>

                                        <th>Code</th>
                                        <th>Article</th>
                                        <th>Catégorie</th>
                                        <th>Unité</th>
                                        <th>Emplacement</th>
                                        <th>Qté Emplacement</th>
                                        <th>Total Article</th>

                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if (!empty($stocks)) : ?>
                                    <?php foreach ($stocks as $stock) : ?>
                                    <tr>

                                        <td><?= $stock->code_article ?></td>

                                        <td><?= $stock->designation ?></td>

                                        <td><?= $stock->categorie ?></td>

                                        <td><?= $stock->unite ?></td>

                                        <td>
                                            <span class="badge badge-primary">
                                                <?= $stock->nom_emplacement ?>
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            <span class="badge badge-success">
                                                <?= number_format($stock->quantite_emplacement, 2, ',', ' ') ?>
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            <span class="badge badge-dark">
                                                <?= number_format($stock->total_article, 2, ',', ' ') ?>
                                            </span>
                                        </td>

                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else : ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">
                                            Aucun stock trouvé
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

                <!-- COLONNE 2 : TOTAL PAR ARTICLE -->
                <div class="col-md-4">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-bar mr-1"></i>
                                Total par article
                            </h3>
                        </div>

                        <div class="card-body table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Article</th>
                                        <th class="text-center">Total</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if (!empty($totaux_articles)) : ?>
                                    <?php foreach ($totaux_articles as $item) : ?>
                                    <tr>
                                        <td>
                                            <strong><?= $item->designation; ?></strong><br>
                                            <small class="text-muted">
                                                <?= $item->code_article; ?> / <?= $item->unite; ?>
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-info">
                                                <?= number_format($item->total_quantite, 2, ',', ' '); ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else : ?>
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">
                                            Aucun total disponible
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<div class="modal fade" id="addArticleModal">
    <div class="modal-dialog">
        <form action="<?= base_url('stock-article-store') ?>" method="post">
            <div class="modal-content">

                <div class="modal-header bg-success">
                    <h5 class="modal-title">Nouvel article</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Code article</label>
                        <input type="text" name="code_article" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Désignation</label>
                        <input type="text" name="designation" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Unité</label>
                        <input type="text" name="unite" class="form-control" placeholder="Kg, Sac, Pièce, Tonne...">
                    </div>

                    <div class="form-group">
                        <label>Catégorie</label>
                        <input type="text" name="categorie" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">
                        Enregistrer
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="addEmplacementModal">
    <div class="modal-dialog">
        <form action="<?= base_url('stock-emplacement-store') ?>" method="post">
            <div class="modal-content">

                <div class="modal-header bg-primary">
                    <h5 class="modal-title">Nouvel emplacement</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Nom emplacement</label>
                        <input type="text" name="nom_emplacement" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">
                        Enregistrer
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="addQuantiteModal">
    <div class="modal-dialog">
        <form action="<?= base_url('stock-quantite-store') ?>" method="post">
            <div class="modal-content">

                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Ajouter quantité au stock</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Article</label>
                        <select name="article_id" class="form-control" required>
                            <option value="">-- Sélectionner --</option>
                            <?php foreach ($articles as $article) : ?>
                            <option value="<?= $article->id ?>">
                                <?= $article->designation ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Emplacement</label>
                        <select name="emplacement_id" class="form-control" required>
                            <option value="">-- Sélectionner --</option>
                            <?php foreach ($emplacements as $emplacement) : ?>
                            <option value="<?= $emplacement->id ?>">
                                <?= $emplacement->nom_emplacement ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Quantité</label>
                        <input type="number" step="0.01" name="quantite" class="form-control" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-warning">
                        Ajouter
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>