<?= $this->extend('layouts/template'); ?>

<?= $this->section('csskhusus'); ?>
<link rel="stylesheet" href="<?= base_url('assets/plugins/daterangepicker/daterangepicker.css') ?>">
<style>
    .user-table-card .card-header {
        padding: 1.25rem 1.5rem;
    }

    .user-table-card .card-title {
        margin: 0;
        font-size: 1.125rem;
        font-weight: 600;
    }

    .user-table-card .table-responsive {
        overflow-x: auto;
    }

    .user-table-card table.dataTable {
        margin-top: 0 !important;
        margin-bottom: 0 !important;
        border-collapse: collapse !important;
    }

    .user-table-card table.dataTable thead th {
        padding: .9rem 1.25rem;
        color: #566a7f;
        background: #fff;
        border-top: 1px solid #eceef1;
        border-bottom: 1px solid #eceef1;
        font-size: .75rem;
        font-weight: 600;
        letter-spacing: .04rem;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .user-table-card table.dataTable tbody td {
        padding: .9rem 1.25rem;
        font-size: 14px; /* 14px */
        color: #697a8d;
        vertical-align: top !important;
        border-bottom: 1px solid #eceef1;
        white-space: nowrap;
    }

    .user-table-card table.dataTable tbody td.wrap-text {
        white-space: normal !important;
        overflow-wrap: break-word;
        word-break: normal;
        line-height: 1.55;
    }

    .user-table-card table.dataTable tbody tr:hover td {
        background-color: #f8f8ff;
    }

    .user-table-card .dataTables_wrapper .row:first-child,
    .user-table-card .dataTables_wrapper .row:last-child {
        padding: 1rem 1.5rem;
        margin: 0;
    }

    .user-table-card .dataTables_wrapper .dataTables_length,
    .user-table-card .dataTables_wrapper .dataTables_filter {
        margin: 0;
    }

    .user-table-card .dataTables_wrapper select,
    .user-table-card .dataTables_wrapper input {
        min-height: 38px;
        border: 1px solid #d9dee3;
        border-radius: .375rem;
        color: #697a8d;
        background-color: #fff;
        padding: .375rem .75rem;
    }

    .user-table-card .dataTables_wrapper input {
        margin-left: .5rem;
    }

    #rentang_tanggal {
        background-color: #fff;
        cursor: pointer;
    }

    .user-table-card .dataTables_wrapper .dataTables_info {
        padding-top: .75rem;
        color: #697a8d;
    }

    .user-table-card .dataTables_wrapper .pagination {
        margin: 0;
    }

    .user-table-card .dataTables_wrapper .page-link {
        min-width: 36px;
        text-align: center;
        border: 0;
        border-radius: .375rem;
        margin-left: .2rem;
    }

    .user-table-card .dataTables_wrapper .page-item.active .page-link {
        background-color: #696cff;
        border-color: #696cff;
    }

    .user-table-actions {
        display: inline-flex;
        gap: .4rem;
        white-space: nowrap;
    }

    .user-table-actions .btn {
        width: 34px;
        height: 34px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .gambar {
        border: 1px solid #dddddd;
        border-radius: 8px; /* opsional */
    }

    .acara-wrapper {
        width: 100%;
    }

    .user-table-card table.dataTable th.acara-column,
    .user-table-card table.dataTable td.acara-column {
        width: 200px !important;
        min-width: 200px !important;
        max-width: 200px !important;
        white-space: normal !important;
    }

    .acara-item {
        display: flex;
        align-items: flex-start;
        gap: .4rem;
        margin-bottom: .5rem;
    }

    .acara-icon {
        flex: 0 0 22px;
        width: 22px;
        text-align: center;
    }

    .acara-text {
        min-width: 0;
        white-space: normal;
        line-height: 1.5;
    }

    .acara-text > div {
        white-space: nowrap;
    }

    .acara-sampai {
        margin: 0;
        font-size: .85em;
    }

    @media (max-width: 767.98px) {
        .user-table-card .dataTables_wrapper .dataTables_length,
        .user-table-card .dataTables_wrapper .dataTables_filter {
            float: none;
            width: 100%;
            text-align: left;
            margin-bottom: .75rem;
        }

        .user-table-card .dataTables_wrapper input {
            width: calc(100% - 4rem);
        }
    }
</style>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card user-table-card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div>
                <h5 class="card-title"><?= $title ?></h5>
            </div>
        </div>
        <div class="table-responsive">
            <div class="px-4 pt-3 pb-2 d-flex align-items-end gap-2 flex-wrap">
                <div>
                    <label for="rentang_tanggal" class="form-label mb-1">Tanggal Pinjam</label>
                    <input type="text" id="rentang_tanggal" class="form-control" placeholder="dd/mm/yyyy - dd/mm/yyyy" autocomplete="off" readonly>
                    <input type="hidden" id="tanggal_mulai">
                    <input type="hidden" id="tanggal_selesai">
                </div>
                <div>
                    <label for="status_filter" class="form-label mb-1">Status</label>
                    <select id="status_filter" class="form-control">
                        <option value="all">Semua</option>
                        <option value="pending">Belum Verifikasi</option>
                        <option value="1">Disetujui</option>
                        <option value="0">Ditolak</option>
                    </select>
                </div>
                <button type="button" id="filterTanggal" class="btn btn-primary">Filter</button>
                <button type="button" id="resetTanggal" class="btn btn-outline-secondary">Reset</button>
            </div>
            <hr>    
            <table class="table" id="example1" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <!-- <th>No. Pinjam</th> -->
                        <th>Tanggal Pinjam</th>
                        <th>Nama Peminjam (Organisasi)</th>
                        <th>Nama Ruang</th>
                        <th>Acara</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('javascriptkhusus'); ?>
<script src="<?= base_url('assets/plugins/moment/moment-with-locales.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/daterangepicker/daterangepicker.js') ?>"></script>
<script>
    const activemenu = document.querySelector('.active-menu-verifikasi-peminjaman-ruang');

    activemenu.classList.add('active');

</script>

<script>
    $(function () {
        moment.locale('id');
        $('#rentang_tanggal').daterangepicker({
            autoUpdateInput: false,
            autoApply: false,
            locale: {
                format: 'DD/MM/YYYY',
                separator: ' - ',
                applyLabel: 'Pilih',
                cancelLabel: 'Batal',
                daysOfWeek: moment.weekdaysMin(),
                monthNames: moment.months()
            }
        });

        const syncSelectedRange = function (picker) {
            if (!picker.endDate) {
                return;
            }

            $('#rentang_tanggal').val(
                picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY')
            );
            $('#tanggal_mulai').val(picker.startDate.format('YYYY-MM-DD'));
            $('#tanggal_selesai').val(picker.endDate.format('YYYY-MM-DD'));
        };

        $(document).on('mousedown.rangePreview', '.daterangepicker td.available', function () {
            setTimeout(function () {
                const picker = $('#rentang_tanggal').data('daterangepicker');
                if (picker) {
                    syncSelectedRange(picker);
                }
            }, 50);
        });

        setInterval(function () {
            const picker = $('#rentang_tanggal').data('daterangepicker');
            if (picker && picker.isShowing && picker.endDate) {
                syncSelectedRange(picker);
            }
        }, 100);

        $('#rentang_tanggal').on('apply.daterangepicker', function (event, picker) {
            syncSelectedRange(picker);
        });

        $('#rentang_tanggal').on('cancel.daterangepicker', function () {
            $(this).val('');
            $('#tanggal_mulai, #tanggal_selesai').val('');
        });

        $('#rentang_tanggal').on('show.daterangepicker', function (event, picker) {
            if (!$('#tanggal_mulai').val() && !$('#tanggal_selesai').val()) {
                picker.endDate = null;
                picker.updateView();
            }
        });

        // $('.select2').select2();

        // let kodeOpd = $('#kode_opd').val();

        const table = $('#example1').DataTable({
            'oLanguage':
            {
                "sProcessing":   "Sedang memproses...",
                "sLengthMenu":   "Tampilkan _MENU_ entri",
                "sZeroRecords":  "Data tidak ditemukan",
                "sInfo":         "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                "sInfoEmpty":    "Menampilkan 0 sampai 0 dari 0 entri",
                "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
                "sInfoPostFix":  "",
                "sSearch":       "Cari:",
                "sUrl":          "",
                "oPaginate": {
                "sFirst":    "Pertama",
                "sPrevious": "Sebelumnya",
                "sNext":     "Selanjutnya",
                "sLast":     "Terakhir"
                }
            },
            processing: true,
            serverSide: true,
            deferRender: true,
            order: [[1, 'desc']],
            ajax: {
                url: "<?= base_url('verifikasi-peminjaman-ruang/data'); ?>",
                type: "POST",
                data: d => {
                    d.tanggal_mulai = $('#tanggal_mulai').val();
                    d.tanggal_selesai = $('#tanggal_selesai').val();
                    d.status = $('#status_filter').val();
                    // d.kode_opd = kodeOpd;
                    d["<?= csrf_token() ?>"] = "<?= csrf_hash() ?>";
                }
            },
            columns: [
                { data: null, orderable: false, searchable: false, render: (d,t,r,meta) => meta.row + 1 + table.page.info().start },
                // { data: 'no_pinjam', className: 'text-center'},
                { data: 'tgl_pinjam', className: 'text-center wrap-text'},
                { data: 'nama_peminjam', className: 'wrap-text'},
                { data: 'nama_ruang', className: 'wrap-text'},
                { data: 'acara', 
                    className: 'acara-column',
                    orderable: false,
                    searchable: false
                },
                { data: 'status', className: 'text-center', orderable:false, searchable:false,},
                { data: 'action', orderable:false, searchable:false, className:'text-center' }
            ]
        });

        $('#filterTanggal').on('click', function () {
            table.ajax.reload(null, true);
        });

        $('#resetTanggal').on('click', function () {
            $('#rentang_tanggal, #tanggal_mulai, #tanggal_selesai').val('');
            $('#status_filter').val('all');
            table.ajax.reload(null, true);
        });

        // $('#kode_opd').on('change', function(){
        //     kodeOpd = $(this).val();
        //     table.ajax.reload(null, true);
        // });

        // contoh: reload saat ganti tahun
        // $('#years').on('change', () => table.ajax.reload(null, false));

        const valOrDash = v => (v === null || v === undefined || v === '') ? '-' : v;
    });

    function confirmDelete(url) {
        // Menampilkan konfirmasi menggunakan SweetAlert2
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data ini akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika pengguna mengonfirmasi, lakukan penghapusan dengan mengarahkan ke URL
                window.location.href = url;
            } else {
                // Jika dibatalkan, tidak melakukan apa-apa
                return false;
            }
        });

        // Mengembalikan false untuk menghentikan aksi default (karena penghapusan akan dilakukan setelah konfirmasi)
        return false;
    }

</script>

<?= $this->endSection(); ?>
