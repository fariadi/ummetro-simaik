<!-- Edit User Modal -->
<div class="modal fade" id="modal-aktvts-ranting-add" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple modal-edit-user">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h3 class="mb-2">Aktivitas Ranting</h3>
          <p class="text-muted">Halaman untuk menambahkan data aktivitas ranting.</p>
        </div>
        <form id="aktivitasRantingForm" class="row g-3" onsubmit="return false">
          {{ csrf_field() }}
          <input type="hidden" name="id" value="">
          <input type="hidden" name="pegawai_id" value="" id="pegawai_id">
          <div class="col-12 col-md-4">
            <label class="form-label" for="aktivitas_tanggal">Tanggal</label>
            <input type="text" id="aktivitas_tanggal" name="aktivitas_tanggal" class="form-control" placeholder="" />
          </div>
          <div class="col-12 col-md-8">
            <label class="form-label" for="aktivitas_tempat">Tempat/Lokasi</label>
            <input type="text" id="aktivitas_tempat" name="aktivitas_tempat" class="form-control" placeholder="" />
          </div>
          <div class="col-12 col-md-12">
            <label class="form-label" for="aktivitas_materi">Tema/Materi singkat</label>
            <input type="text" id="aktivitas_materi" name="aktivitas_materi" class="form-control" placeholder="" />
          </div>
         
          <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Simpan Aktivitas</button>
            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--/ Edit User Modal -->
