<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms /</span> Basic Inputs</h4> -->

    <div class="row">
        <!-- <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Float label</h5>
                <div class="card-body">
                    <div class="form-floating">
                        <input
                            type="text"
                            class="form-control"
                            id="floatingInput"
                            placeholder="John Doe"
                            aria-describedby="floatingInputHelp" />
                        <label for="floatingInput">Name</label>
                        <div id="floatingInputHelp" class="form-text">
                            We'll never share your details with anyone else.
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="col-lg-8 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Selamat datang <?= user()->fullname; ?> 🎉</h5>
                            <p class="mb-4">
                                Selamat Datang di <span class="fw-bold">SiRuang</span>. Silahkan gunakan menu yang tersedia untuk mengelola data anda.
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img
                                src="../assets/img/illustrations/man-with-laptop-light.png"
                                height="140"
                                alt="View Badge User"
                                data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                data-app-light-img="illustrations/man-with-laptop-light.png" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img
                                src="../assets/img/icons/unicons/submit.png"
                                alt="chart success"
                                class="rounded" />
                        </div>
                        <div class="dropdown">
                            <button
                                class="btn p-0"
                                type="button"
                                id="cardOpt3"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                <!-- <a class="dropdown-item" href="javascript:void(0);">Delete</a> -->
                            </div>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Jumlah Pengajuan</span>
                    <h3 class="card-title mb-2">4684</h3>                    
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img
                                src="../assets/img/icons/unicons/check.png"
                                alt="chart success"
                                class="rounded" />
                        </div>
                        <div class="dropdown">
                            <button
                                class="btn p-0"
                                type="button"
                                id="cardOpt3"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                <!-- <a class="dropdown-item" href="javascript:void(0);">Delete</a> -->
                            </div>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Pengajuan Diterima</span>
                    <h3 class="card-title mb-2">2698</h3>                    
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img
                                src="../assets/img/icons/unicons/chart-success.png"
                                alt="chart success"
                                class="rounded" />
                        </div>
                        <div class="dropdown">
                            <button
                                class="btn p-0"
                                type="button"
                                id="cardOpt3"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                <!-- <a class="dropdown-item" href="javascript:void(0);">Delete</a> -->
                            </div>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Pengajuan Ditolak</span>
                    <h3 class="card-title mb-2">1033</h3>                    
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img
                                src="../assets/img/icons/unicons/chart-success.png"
                                alt="chart success"
                                class="rounded" />
                        </div>
                        <div class="dropdown">
                            <button
                                class="btn p-0"
                                type="button"
                                id="cardOpt3"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                            </div>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Pengajuan Dibatalkan</span>
                    <h3 class="card-title mb-2">2698</h3>                    
                </div>
            </div>
        </div>
        

    </div>
</div>
<!-- / Content -->
<?= $this->endSection(); ?>