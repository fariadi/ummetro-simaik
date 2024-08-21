<!-- Edit User Modal -->
<div class="modal fade" id="modal-validasi" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog  modal-simple modal-edit-user">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h3 class="mb-2">Validasi </h3>
          <p class="text-muted">Halaman untuk menginputkan tanggal pertemuan.</p>
        </div>
        <form id="formValidasi" class="row g-3" onsubmit="return false">
          {{ csrf_field() }}
          <input type="hidden" name="id" value="" id="validasi_bbq_id">
            <dl class="row m-1">
              <dt class="col-sm-6 mb-2 mb-sm-0 ps-0">
                <span class="text-nowrap">Nama Lengkap</span>
              </dt>
              <dd class="col-sm-6 d-flex pe-0 ps-0 ps-sm-2">
                <span class="text-nowrap text-nowrap" id="dd-nama"></span>
              </dd>
              <dt class="col-sm-6 mb-2 mb-sm-0 ps-0">
                <span class="text-nowrap">Nama Surah</span>
              </dt>
              <dd class="col-sm-6 d-flex  pe-0 ps-0 ps-sm-2">
                <span class="fw-normal text-nowrap" id="dd-surah"></span>
              </dd>
              <dt class="col-sm-6 mb-2 mb-sm-0 ps-0">
                <span class="text-nowrap">Ayat Ke</span>
              </dt>
              <dd class="col-sm-6 d-flex pe-0 ps-0 ps-sm-2">
                <span class="fw-normal" id="dd-ayatke"></span>
              </dd>
          </dl>
          
            <div class="col-12 col-md-12">
              <label class="form-label" for="mentor_validasi">Status Validasi</label>
              <select id="mentor_validasi" name="mentor_validasi" class="form-select" aria-label="Default select example">
                <option selected></option>
                <option value="lancar">Lancar</option>
                <option value="kurang lancar">Kurang Lancar</option>
                <option value="bellum bisa">Belum Bisa</option>
              </select>
            </div>
          
          <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--/ Edit User Modal -->
