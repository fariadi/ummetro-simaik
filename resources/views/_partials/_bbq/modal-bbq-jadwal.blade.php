<!-- Edit User Modal -->
<div class="modal fade" id="modal-pertemuan-add" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog  modal-simple modal-edit-user">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h3 class="mb-2">Tetapkan Tanggal </h3>
          <p class="text-muted">Halaman untuk menginputkan tanggal pertemuan.</p>
        </div>
        <form id="formPertemuan" class="row g-3" onsubmit="return false">
          {{ csrf_field() }}
          <input type="hidden" name="id" value="" id="bbq_id">
          <div class="col-12 col-md-6">
            <label class="form-label" for="mentor_jadwal">Tanggal</label>
            <input type="text" id="mentor_jadwal" name="mentor_jadwal" class="form-control" placeholder="" />
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label" for="mentor_jam">Waktu</label>
            <input type="text" id="mentor_jam" name="mentor_jam" class="form-control" placeholder="" />
          </div>
          <div class="col-12 col-md-12">
            <label class="form-label" for="mentor_lokasi">Tempat/Lokasi</label>
            <input type="text" id="mentor_lokasi" name="mentor_lokasi" class="form-control" placeholder="" />
          </div>
          
         
          <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Simpan Jadwal</button>
            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--/ Edit User Modal -->
