<!-- Edit User Modal -->
<div class="modal fade" id="modal-add" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h3 class="mb-2">Tambah</h3>
          <p class="text-muted">Tambah data surat Al-qur'an.</p>
        </div>
        <form id="addAlquranForm" class="row g-3" onsubmit="return false">
          <div class="col-12 col-md-12">
            <label class="form-label" for="nama_surat">Nama Surat</label>
            <input type="text" id="nama_surat" name="nama_surat" class="form-control" placeholder="" />
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label" for="surat_ke">Surat Ke.</label>
            <input type="text" id="surat_ke" name="surat_ke" class="form-control" placeholder="0" />
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label" for="jumlah_ayat">Jumlah Ayat</label>
            <input type="text" id="jumlah_ayat" name="jumlah_ayat" class="form-control" placeholder="0" />
          </div>
          <input type="hidden" name="id" id="id" value="">
          <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Simpan</button>
            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--/ Edit User Modal -->
