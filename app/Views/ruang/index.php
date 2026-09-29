<?= $this->extend('layouts/template'); ?>

<?= $this->section('csskhusus'); ?>
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
        color: #697a8d;
        vertical-align: top !important;
        border-bottom: 1px solid #eceef1;
        white-space: nowrap;
    }

    .user-table-card table.dataTable tbody td.wrap-text {
        white-space: normal !important;
        overflow-wrap: anywhere;
        word-break: break-word;
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
            <a href="<?= base_url('master-ruang/create'); ?>" class="btn btn-success">
                <i class="bx bx-plus me-1"></i> Tambah Ruang
            </a>
        </div>
        <div class="table-responsive">
            <table class="table" id="example1" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Ruang</th>
                        <th>Alamat</th>
                        <th>Peruntukan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('javascriptkhusus'); ?>
<script>
    const activemenu = document.querySelector('.active-menu-ruang');

    activemenu.classList.add('active');

</script>

<script>
    $(function () {
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
            ajax: {
                url: "<?= base_url('master-ruang/data'); ?>",
                type: "POST",
                data: d => {
                    // d.kode_opd = kodeOpd;
                    d["<?= csrf_token() ?>"] = "<?= csrf_hash() ?>";
                }
            },
            columns: [
                { data: null, orderable: false, searchable: false, render: (d,t,r,meta) => meta.row + 1 + table.page.info().start },
                { data: 'nama_ruang', className: 'wrap-text'},
                { data: 'alamat', className: 'wrap-text'},
                { data: 'peruntukan', orderable:false, searchable:false, className:'text-center'},
                { data: 'action', orderable:false, searchable:false, className:'text-center' }
            ]
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
