<div class="container">
    <h5><strong><?= $data['title'] ?></strong></h5>
    <hr>
    <form method="post" name="priceForm" id="priceForm" action="<?= $data['form_action'] ?>">
        <div class="card">
            <div class="card-body">

                <div class="form-group">
                    <label>Waktu Terima</label>
                    <div class="input-group">
                        <input type="datetime-local" id="datepicker_inpt" name="waktu_terima" class="form-control" value="<?= $data['data_edit']['waktu_terima'] ?? (new DateTime())->format('Y-m-d\TH:i') ?>" required>
                    </div>
                    <?php App::InputValidator('waktu_terima') ?>
                </div>
                <div class="form-group center-input">
                    <label>Jenis Cuci</label>
                    <select class="form-control" id="jenis_inpt" name="jenis" required>
                        <option class="hide" value="" readonly disabled selected>JENIS CUCI</option>
                        <?php
                        foreach ($data['jenis'] as $jenis_cuci) {
                        ?>
                            <option value="<?= $jenis_cuci['id'] ?>" <?= (isset($data['data_edit']['jenis']) && $data['data_edit']['jenis'] == $jenis_cuci['jenis'] ? 'selected' : '') ?>><?= $jenis_cuci['jenis'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <?php App::InputValidator('jenis') ?>
                </div>
                <div class="form-group">
                    <label>Harga</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp.</span>
                        <input type="text" class="form-control" name="harga" readonly id="harga_inpt" value="<?= $data['data_edit']['harga'] ?? '' ?>" required>
                        <span class="input-group-text">/KG</span>
                    </div>
                    <?php App::InputValidator('harga') ?>
                </div>
                <div class="form-group">
                    <label>KG</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="kg" step="0.1" inputmode="numeric" id="kg_inpt" value="<?= $data['data_edit']['kg'] ?? '' ?>" required>
                        <span class="input-group-text">KG</span>
                        <?php App::InputValidator('kg') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label>Total</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp.</span>
                        <input type="text" class="form-control" name="total" readonly id="total_inpt" value="<?= $data['data_edit']['total'] ?? '' ?>" required>
                    </div>
                    <?php App::InputValidator('total') ?>
                </div>

                <div class="form-group">
                    <label>Waktu Selesai <?= (isset($data["edit_id"]) ? '' : '(Estimasi)') ?></label>
                    <div class="input-group">
                        <input type="datetime-local" id="datepicker_inpt" name="waktu_selesai" class="form-control" value="<?= $data['data_edit']['waktu_selesai'] ?? (new DateTime("+1 Day"))->format('Y-m-d\TH:i') ?>" required>
                    </div>
                    <?php App::InputValidator('waktu_terima') ?>
                </div>

                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control" autocomplete="off" placeholder="Keterangan" rows="3"><?= $data['data_edit']['keterangan'] ?? '' ?></textarea>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" id="status_tbl" name="status">
                        <?php foreach (STATUS_TRANSAKSI as $key => $value) { ?>
                            <option value="<?= $key ?>" <?= (isset($data['data_edit']) && isset($data['data_edit']['status']) && $data['data_edit']['status'] == $key ? 'selected' : '') ?>><?= $value ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="card-footer">
                <div class="btn-group" role="group" aria-label="">

                    <a href="<?= BASEURL ?>/Transaksi" type="button" class="btn btn-warning">Batal</a>
                    <input type="submit" class="btn btn-success" value="Simpan" name="priceForm">
                    <?php
                    if (isset($data["data_edit"])) {
                    ?>
                        <a href="<?= BASEURL . "/Transaksi/delete/id/{$data["data_edit"]['id']}" ?>" onclick="return confirm('Are you sure you want to delete?')" class="btn btn-danger">Hapus</a>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    let jenis = <?= json_encode(array_column($data['jenis'], 'harga', 'id')) ?>;
    let harga = 0,
        kg = 0;
    document.querySelector('#jenis_inpt').addEventListener('change', (e) => {
        harga = jenis[e.target.value];
        updateHarga();
        updateTotal()
    })
    document.querySelector('#kg_inpt').addEventListener('change', (e) => {
        kg = e.currentTarget.value;
        updateTotal()
    })
    let updateHarga = () => {
        document.querySelector('#harga_inpt').value = harga;
    }
    let updateTotal = () => {
        document.querySelector('#total_inpt').value = (harga * kg);
    }

    <?php if (isset($data["data_edit"])) { ?>
        const data_edit = <?= json_encode($data['data_edit']) ?>;
        harga = data_edit['harga'];
        kg = data_edit['kg'];
        updateHarga();
        updateTotal()
    <?php } ?>
</script>