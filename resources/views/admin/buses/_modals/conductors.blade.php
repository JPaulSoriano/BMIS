<form action="{{ route('admin.assign-conductor', $bus) }}" method="post">
    @csrf
    @method('put')

    <!-- Modal -->
    <div class="modal fade" id="conductorModal" tabindex="-1" role="dialog" aria-labelledby="conductorLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="conductorLabel">Select Conductor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <select name="conductor_id" class="form-control">
                        <option selected hidden disabled>...</option>
                        @foreach ($conductors as $conductor)
                            <option value="{{ $conductor->id }}" @if(optional($bus->conductor)->id == $conductor->id) selected @endif>{{ $conductor->employeeProfile->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Assign</button>
                </div>
            </div>
        </div>
    </div>
</form>
