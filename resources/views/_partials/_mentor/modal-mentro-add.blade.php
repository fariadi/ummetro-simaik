<!-- Edit User Modal -->
<div class="modal fade" id="modal-mentor-add" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple modal-edit-user">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h3 class="mb-2">Tetapkan Mentor</h3>
          <p class="text-muted">Halaman menetapkan mentor peserta BBQ.</p>
        </div>
        <form id="formMentor" class="row g-3" onsubmit="return false">
          {{ csrf_field() }}
          <input type="hidden" name="id" value="" id="mentor_id">
          <input type="hidden" name="pegawai_id" value="" id="pegawai_id">
          <div class="col-12 col-md-12">
            <label class="form-label" for="mentor_user_id">Pilih Nama Mentor</label>
            <select id="mentor_user_id" class="select2_mentor" name="mentor_user_id" class="form-select" aria-label="Perguruan Tinggi">
              <option selected></option>
            </select>
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
