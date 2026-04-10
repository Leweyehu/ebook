<!-- ========== ADD PROGRAM MODAL ========== -->
<div class="modal fade" id="addProgramModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-plus me-2"></i> Add New Program</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.programs.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Program Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Program Type <span class="text-danger">*</span></label>
                            <select name="type" class="form-select" required>
                                <option value="undergraduate">Undergraduate (B.Sc.)</option>
                                <option value="postgraduate">Postgraduate (M.Sc.)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Icon Class</label>
                            <input type="text" name="icon" class="form-control" placeholder="fas fa-laptop-code" value="fas fa-laptop-code">
                            <small class="text-muted">Font Awesome icon class</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Duration (Years)</label>
                            <input type="number" name="duration_years" class="form-control" placeholder="4">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Credit Hours</label>
                            <input type="number" name="credit_hours" class="form-control" placeholder="173">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">ECTS</label>
                            <input type="number" name="ects" class="form-control" placeholder="280">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Semesters</label>
                            <input type="number" name="semesters" class="form-control" placeholder="8">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Program description..."></textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Career Opportunities (comma separated)</label>
                            <input type="text" name="career_opportunities" class="form-control" placeholder="Software Developer, Systems Analyst, Database Administrator">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Specializations (comma separated)</label>
                            <input type="text" name="specializations" class="form-control" placeholder="AI, Data Science, Networking">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mode of Delivery</label>
                            <input type="text" name="mode_of_delivery" class="form-control" placeholder="Face-to-Face">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Teaching Method</label>
                            <input type="text" name="teaching_method" class="form-control" placeholder="Active Learning">
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" class="form-check-input" id="programActive" checked>
                                <label class="form-check-label" for="programActive">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Program</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========== ADD COURSE REQUIREMENT MODAL ========== -->
<div class="modal fade" id="addRequirementModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-plus me-2"></i> Add Course Requirement</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.programs.requirements.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="category_name" class="form-control" placeholder="Compulsory Courses" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Number of Courses <span class="text-danger">*</span></label>
                        <input type="number" name="number_of_courses" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Credit Hours <span class="text-danger">*</span></label>
                        <input type="number" name="credit_hours" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ECTS <span class="text-danger">*</span></label>
                        <input type="number" name="ects" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Requirement</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========== ADD ADMISSION REQUIREMENT MODAL ========== -->
<div class="modal fade" id="addAdmissionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-plus me-2"></i> Add Admission Requirement</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.programs.admission.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" placeholder="Undergraduate Admission" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Content <span class="text-danger">*</span></label>
                        <textarea name="content" class="form-control" rows="4" placeholder="Admission requirements content..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" id="admissionActive" checked>
                            <label class="form-check-label" for="admissionActive">Active</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Admission Requirement</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========== ADD GRADUATION REQUIREMENT MODAL ========== -->
<div class="modal fade" id="addGraduationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-plus me-2"></i> Add Graduation Requirement</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.programs.graduation.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Requirement <span class="text-danger">*</span></label>
                        <textarea name="requirement" class="form-control" rows="3" placeholder="Enter graduation requirement..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" id="graduationActive" checked>
                            <label class="form-check-label" for="graduationActive">Active</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Graduation Requirement</button>
                </div>
            </form>
        </div>
    </div>
</div>