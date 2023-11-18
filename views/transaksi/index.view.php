<div class="container">
    <div class="row">
        <div class="col-sm me-auto">
            <h5><strong><?= $data['title'] ?></strong></h5>
        </div>
        <div class="col-sm">
            <a href="<?= BASEURL ?>/Transaksi/add" class="btn btn-outline-primary btn-xl float-end">
                + Transaksi
            </a>
        </div>
    </div>
    <hr>
    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    List Jenis Cuci & Harga
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Jenis</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['jenis'] as $jenis) { ?>
                                <tr data-id="<?= $jenis['id'] ?>">
                                    <td data-label="JENIS">
                                        <?php echo $jenis['jenis'] ?>
                                    </td>
                                    <td data-label="HARGA">
                                        <?php echo 'Rp. ' . number_format($jenis['harga'], 0, ",", ".") . ",-/KG" ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <table data-label="Tabel Transaksi" class="table table-responsive table-hover table-sm table-bordered myTable" id="FormatTable">
        <thead class="sticky-top">
            <tr>
                <th scope="col" width="10%">ID</th>
                <th scope="col" width="15%">WAKTU TERIMA</th>
                <th scope="col" width="15%">JENIS</th>
                <th scope="col" width="15%">HARGA</th>
                <th scope="col" width="15%">KG</th>
                <th scope="col" width="15%">TOTAL</th>
                <th scope="col" width="13%">WAKTU SELESAI</th>
                <th scope="col" width="13%">KETERANGAN</th>
                <th scope="col" width="13%">STATUS</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($data['transaksi'] as $transaksi) {
            ?>
                <tr data-id="<?= $transaksi['id'] ?>" <?= ($transaksi['status'] !== 4) ? "data-bs-toggle='tooltip' data-bs-html='true' title='<h6><strong>Klik 2x untuk Edit</strong></h6>' ondblclick='location.replace(`" . BASEURL . "/Transaksi/edit/id/{$transaksi['id']}`);'" : '' ?>>
                    <td scope="row" data-label="ID">
                        <?php echo $transaksi['id'] ?>
                    </td>
                    <td data-label="WAKTU TERIMA">
                        <?php
                        setlocale(LC_ALL, 'id-ID', 'id_ID');
                        $timestamp =  strftime("%d %B %Y Jam %H:%M", strtotime($transaksi['waktu_terima']));
                        echo $timestamp ?>
                    </td>
                    <td data-label="JENIS">
                        <?php echo $transaksi['jenis'] ?>
                    </td>
                    <td data-label="HARGA">
                        <?php echo 'Rp. ' . number_format($transaksi['harga'], 0, ",", ".") . ",-/KG" ?>
                    </td>
                    <td data-label="KG">
                        <?php echo  number_format($transaksi['kg'], 2, ",", ".") . " KG" ?>
                    </td>
                    <td data-label="TOTAL">
                        <?php echo 'Rp. ' . number_format($transaksi['total'], 0, ",", ".") . ",-" ?>
                    </td>
                    <td data-label="WAKTU SELESAI">
                        <?php
                        setlocale(LC_ALL, 'id-ID', 'id_ID');
                        $timestamp =  strftime("%d %B %Y Jam %H:%M", strtotime($transaksi['waktu_selesai']));
                        echo $timestamp ?>
                    </td>
                    <td data-label="KETERANGAN">
                        <?php echo $transaksi['keterangan'] ?>
                    </td>
                    <td data-label="STATUS">
                        <?php if (($transaksi['status'] !== 4)) { ?>
                            <select class="form-control" onchange="updateStatus(<?= $transaksi['id'] ?>,this.value)" name="status">
                                <?php foreach (STATUS_TRANSAKSI as $key => $value) { ?>
                                    <option value="<?= $key ?>" <?= ($transaksi['status'] == $key ? 'selected' : '') ?>><?= $value ?></option>
                                <?php } ?>
                            </select>
                        <?php } else {
                            echo STATUS_TRANSAKSI[$transaksi['status']];
                        } ?>
                    </td>
                </tr>
            <?php
            }
            ?>
        <tbody>
    </table>
</div>
<form style="display: none" method="post" id="updateStatus_form" action="">
    <input type="text" name="update_status" id="update_status">
</form>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/datatables.min.css" />

<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/datatables.min.js"></script>

<script>
    let updateStatus = (id, status) => {
        form = document.getElementById('updateStatus_form');
        form.action = `<?= BASEURL ?>/Transaksi/edit/id/${id}`
        document.getElementById('update_status').value = status
        form.submit();
    }

    document.addEventListener("DOMContentLoaded", function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                html: true,
                placement: 'bottom'
            })
        })

    })
    $(document).ready(function() {

        var Ftable = $("#FormatTable").DataTable({
            "dom": "ftlp",
            "language": {
                "lengthMenu": "Menampilkan _MENU_ baris per halaman",
                "zeroRecords": "Tidak ada data",
                "infoEmpty": "Tidak ada data",
                "search": "Cari : ",
                "paginate": {
                    "first": "<<",
                    "last": ">>",
                    "next": ">",
                    "previous": "<"
                }
            },
            "order": [
                [0, "desc"],
            ],
        });

    });
</script>