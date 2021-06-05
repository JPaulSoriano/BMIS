@extends('layouts.admin')

@section('main-content')


<div class="container">

    <div class="row justify-content-center">
        <div class="col-lg-12">
            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                {{ $message }}
            </div>
            @endif
            <div class="card shadow mb-4">
                <div class="card-header bg-primary d-sm-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-white">Employees</h6>
                    <a class="btn btn-light btn-sm" href="{{ route('admin.employees.create') }}"><i
                            class="fas fa-plus"></i></a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Employee No</th>
                                    <th>Full Name</th>
                                    <th>Role</th>
                                    <th style="width: 130px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $employee->employeeProfile->employee_no }}</td>
                                    <td>{{ $employee->employeeProfile->full_name }}</td>
                                    <td>{{ $employee->roles->first()->name }}</td>
                                    <td class="d-flex justify-content-around">
                                        <a class="btn btn-info btn-sm"
                                            href="{{ route('admin.employees.show', $employee->employeeProfile) }}"><i
                                                class="fas fa-eye"></i></a>
                                        <a class="btn btn-primary btn-sm"
                                            href="{{ route('admin.employees.edit', $employee->employeeProfile ) }}"><i
                                                class="fas fa-edit"></i></a>
                                        <form
                                            action="{{ route('admin.employees.destroy',$employee->employeeProfile ) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
    $('table').DataTable();
</script>
@endsection
