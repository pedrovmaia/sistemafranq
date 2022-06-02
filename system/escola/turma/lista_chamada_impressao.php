<style>
    .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
        border-color: #000;
    }
</style>
<div class="content" style="background: white">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 mb-2">
                <div class="card-header-primary">
                    <h4 class="card-title mt-5"><?= $texto['LSTCHMD'] ?></h4>
                </div>
            </div>
            <div class="col-md-4 mb-2">
                <img class="img-fluid" src="<?= BASE ?>/assets/img/logo.png" />
            </div>
            <div class="col-md-4">
                <p><strong><?= $texto['TRMP'] ?></strong>TEENS 1 TT 16:00/17:00</p>
                <p><strong><?= $texto['CRSOP'] ?></strong>TEENS</p>
                <p><strong><?= $texto['INIP'] ?></strong>05/02/2019</p>
                <p><strong><?= $texto['HRRP'] ?></strong>Ter: 16:00 às 17:00 - Ter: 17:00 às 18:00</p>
            </div>
            <div class="col-md-4">
                <p><strong><?= $texto['Profp'] ?> </strong>LORENA REIS</p>
                <p><strong><?= $texto['ESTP'] ?></strong>TEENS 1</p>
                <p><strong><?= $texto['TERMP'] ?></strong>02/07/2019</p>
            </div>
            <div class="col-md-4">
                <p><strong><?= $texto['SALP'] ?></strong>9</p>
                <p><strong><?= $texto['MODAP'] ?></strong>Regular</p>
            </div>
            <div class="col-md-12">
                <p><strong><?= $texto['IMPRP'] ?></strong><?= date('d/m/Y') ?></p>
            </div>
            <div class="col-md-12">
                <div>
                    <table style="border-top: 1px solid;" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th style="text-align: center; background: lightgrey" colspan="30">
                                    <div class="th-inner"><?= $texto['PREVS'] ?></div>
                                    <div class="fht-cell"></div>
                                </th>
                            </tr>
                            <tr>
                                <th style="text-align: center; vertical-align: middle; background: lightgrey" rowspan="2">
                                    <div class="th-inner sortable both">At.</div>
                                </th>
                                <th style="text-align: center; background: lightgrey" colspan="2">
                                    <div class="th-inner"><?= $texto['PREVS'] ?></div>
                                    <div class="fht-cell"></div>
                                </th>
                                <th style="text-align: center; background: lightgrey" colspan="2">
                                    <div class="th-inner "><?= $texto['REALZ'] ?></div>
                                    <div class="fht-cell"></div>
                                </th>
                                <th style="text-align: center; vertical-align: middle; background: lightgrey" rowspan="2">
                                    <div class="th-inner sortable both"><?= $texto['VST'] ?></div>
                                </th>
                            </tr>
                            <tr>
                                <th style="text-align: center; background: lightgrey">
                                    <div class="th-inner sortable both"><?= $texto['DTAi'] ?></div>
                                </th>
                                <th style="text-align: center; background: lightgrey">
                                    <div class="th-inner sortable both"><?= $texto['CONTED'] ?></div>
                                </th>
                                <th style="text-align: center; background: lightgrey">
                                    <div class="th-inner "><?= $texto['DTAi'] ?></div>
                                </th>
                                <th style="text-align: center; background: lightgrey">
                                    <div class="th-inner sortable both"><?= $texto['CONTED'] ?></div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: center; vertical-align: middle;">1</td>
                                <td style="text-align: left;">26/06/2019</td>
                                <td style="text-align: left;">Intro + 1 (OK):</td>
                                <td style="text-align: left;">26/06/2019</td>
                                <td style="text-align: left;">Intro + 1 (OK):</td>
                                <td style="text-align: center;"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>