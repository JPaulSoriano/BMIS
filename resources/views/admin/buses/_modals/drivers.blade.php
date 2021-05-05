<!-- Modal -->
<form action="{{ route('admin.assign-driver', $bus) }}" method="post">
    @csrf
    @method('put')

    <div class="modal fade" id="driverModal" tabindex="-1" role="dialog" aria-labelledby="driverLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="driverLabel">Select driver</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <select name="driver_id" class="form-control">
                        <option selected hidden disabled>...</option>
                        @foreach ($drivers as $driver)
                        <option value="{{ $driver->id }}" @if(optional($bus->driver)->id == $driver->id) selected @endif>{{ $driver->employeeProfile->full_name }}</option>
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
