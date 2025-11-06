<?php echo $this->extend('plantilla/layout'); ?>
<?php echo $this->section('contenido'); ?>

<div id="carouselExampleCaptions" class="carousel slide">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>

    <div class="carousel-inner">

        <div class="carousel-item active">
            <button style="background-color: #162456; color: white;" class="btn"
                type="button"
                data-bs-toggle="modal"
                data-bs-target="#modalreporte1">
                Reporte 1
            </button>

            <div style="display: flex; justify-content: center; align-items: center;">
                <canvas id="myChart" style="width: 900px; height: 400px; position: relative;"></canvas>
            </div>

            <div class="carousel-caption d-none d-md-block" style="position: static;">
                <h5 style="color: black;">First slide label</h5>
                <p style="color: black;">Some representative placeholder content for the first slide.</p>
            </div>
        </div>

        <div class="carousel-item ">
            <button style="background-color: #162456; color: white;" class="btn"
                type="button"
                data-bs-toggle="modal"
                data-bs-target="#modalreporte2"
                onclick="LimpiarFormulario()">
                Reporte 2
            </button>

            <div style="display: flex; justify-content: center; align-items: center;">
                <canvas id="myChart2" style="width: 900px; height: 400px; position: relative;"></canvas>
            </div>

            <div class="carousel-caption d-none d-md-block" style="position: static;">
                <h5 style="color: black;">First slide label</h5>
                <p style="color: black;">Some representative placeholder content for the first slide.</p>
            </div>
        </div>

        <div class="carousel-item">
            <button style="background-color: #162456; color: white;" class="btn"
                type="button"
                data-bs-toggle="modal"
                data-bs-target="#modalreporte3"
                onclick="LimpiarFormulario()">
                Reporte 3
            </button>

            <div style="display: flex; justify-content: center; align-items: center;">
                <canvas id="myChart3" style="width: 900px; height: 400px; position: relative;"></canvas>
            </div>

            <div class="carousel-caption d-none d-md-block" style="position: static;">
                <h5 style="color: black;">First slide label</h5>
                <p style="color: black;">Some representative placeholder content for the first slide.</p>
            </div>
        </div>



    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<div class="modal fade" id="modalreporte1" tabindex="-1" aria-labelledby="modalreporte1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalreporte1">Reporte 1</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h3 class="text-center">Reporte 1</h3>
                <div>
                    <table id="tablareporte1" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Columna 1</th>
                                <th>Columna 2</th>
                                <th>Columna 3</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Dato 1</td>
                                <td>Dato 2</td>
                                <td>Dato 3</td>
                            </tr>
                            <tr>
                                <td>Dato 4</td>
                                <td>Dato 5</td>
                                <td>Dato 6</td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalreporte2" tabindex="-1" aria-labelledby="modalreporte2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalreporte2">Reporte 2</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h3 class="text-center">Reporte 2</h3>
                <div>
                    <table id="tablareporte2" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Columna 1</th>
                                <th>Columna 2</th>
                                <th>Columna 3</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Dato 1</td>
                                <td>Dato 2</td>
                                <td>Dato 3</td>
                            </tr>
                            <tr>
                                <td>Dato 4</td>
                                <td>Dato 5</td>
                                <td>Dato 6</td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalreporte3" tabindex="-1" aria-labelledby="modalreporte3" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalreporte3">Reporte 3</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h3 class="text-center">Reporte 3</h3>
                <div>
                    <table id="tablareporte3" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Columna 1</th>
                                <th>Columna 2</th>
                                <th>Columna 3</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Dato 1</td>
                                <td>Dato 2</td>
                                <td>Dato 3</td>
                            </tr>
                            <tr>
                                <td>Dato 4</td>
                                <td>Dato 5</td>
                                <td>Dato 6</td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>

<script>
    $(document).ready(function() {

        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: 'Votes',
                    data: [12, 19, 3, 5, 2, 3],
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false
            }
        });

        const ctx2 = document.getElementById('myChart2').getContext('2d');
        const myChart2 = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: 'Votes',
                    data: [12, 19, 3, 5, 2, 3],
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false
            }
        });

        const ctx3 = document.getElementById('myChart3').getContext('2d');
        const myChart3 = new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: 'Votes',
                    data: [12, 19, 3, 5, 2, 3],
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false
                
            }
        });

        tabla = $('#tablareporte1').DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
            }
        });
        tabla = $('#tablareporte2').DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
            }
        });
        tabla = $('#tablareporte3').DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
            }
        });
    });
</script>

<?php echo $this->endSection(); ?>