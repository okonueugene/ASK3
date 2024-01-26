@extends('admin.layouts.layout')
@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block">
                        <div class="card card-bordered">
                            <div class="card-aside-wrap">
                                <div class="card-inner card-inner-lg">
                                    <div class="nk-block-head nk-block-head-lg">
                                        <div class="nk-block-between">
                                            <div class="nk-block-head-content">
                                                <h4 class="nk-block-title">{{ $title }}</h4>
                                                <div class="nk-block-des">
                                                    <p>
                                                        This Site has {{ count($tags) }} Tags
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="nk-block-head-content">
                                                <ul>
                                                    <li>
                                                        <a href="javascript:void(0)"
                                                            class="btn btn-white btn-dim btn-outline-primary"
                                                            data-bs-toggle="modal" data-bs-target="#addTagModal">
                                                            Add Single Tag
                                                        </a>
                                                        <a href="javascript:void(0)" data-bs-toggle="modal"
                                                            data-bs-target="#addMultipleTagModal"
                                                            class="btn btn-white btn-dim btn-outline-primary">
                                                            Add Multiple Tags
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nk-block">
                                        <div class="card card-bordered card-preview">
                                            <div class="card-inner">
                                                @if (count($tags) > 0)
                                                    <table class="datatable-init nk-tb-list nk-tb-ulist"
                                                        data-auto-responsive="false">
                                                        <thead>
                                                            <tr class="nk-tb-item nk-tb-head">
                                                                <th class="nk-tb-col nk-tb-col-check">
                                                                    <div
                                                                        class="custom-control custom-control-sm custom-checkbox notext">
                                                                        <input type="checkbox" class="custom-control-input"
                                                                            id="uid">
                                                                        <label class="custom-control-label"
                                                                            for="uid"></label>
                                                                    </div>
                                                                </th>
                                                                <th class="nk-tb-col"><span class="sub-text">Name</span>
                                                                </th>
                                                                <th class="nk-tb-col"><span class="sub-text">Type</span>
                                                                </th>
                                                                <th class="nk-tb-col"><span class="sub-text">Code</span>
                                                                </th>
                                                                <th class="nk-tb-col"><span class="sub-text">Location</span>
                                                                </th>
                                                                <th class="nk-tb-col"><span class="sub-text">Action</span>
                                                                </th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            @foreach ($tags as $tag)
                                                                <tr>
                                                                    <td class="nk-tb-col">
                                                                        <div
                                                                            class="custom-control custom-control-sm custom-checkbox notext">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input" id="uid1">
                                                                            <label class="custom-control-label"
                                                                                for="uid1"></label>
                                                                        </div>
                                                                    </td>
                                                                    <td class="nk-tb-col">
                                                                        <div class="user-card">
                                                                            <div
                                                                                class="user-avatar bg-dim-primary d-none d-sm-flex">
                                                                                @if ($tag->type == 'qr')
                                                                                    <span>{!! QrCode::size(50)->generate($tag->code) !!}</span>
                                                                                @else
                                                                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($tag->name) }}"
                                                                                        alt="">
                                                                                @endif
                                                                            </div>
                                                                            <div class="user-info">
                                                                                <span
                                                                                    class="tb-lead">{{ $tag->name }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="nk-tb-col tb-col-mb">
                                                                        <span>{{ strtoupper($tag->type) }}</span>
                                                                    </td>
                                                                    <td class="nk-tb-col tb-col-md">

                                                                        <span>{{ $tag->code }}</span>

                                                                    </td>
                                                                    <td class="nk-tb-col tb-col-lg">
                                                                        <span>{{ $tag->location }}</span>
                                                                    </td>
                                                                    <td class="nk-tb-col tb-col-md">
                                                                        <a href="javascript:void(0)"
                                                                            onclick="deleteTag({{ $tag->id }})"
                                                                            class="btn btn-sm btn-danger">
                                                                            Delete
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                @else
                                                    <table class="table text-center">
                                                        <tr>
                                                            <td class="nk-tb-col">
                                                                <span>No Records Found</span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                @endif
                                            </div>
                                        </div><!-- .card-preview -->
                                    </div>
                                </div>
                                @include('admin.commons.sidebar')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addTagModal" tabindex="-1" aria-labelledby="addTagModalExample" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Add A Tag</h5>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="addSingleTagForm" action="{{ route('admin.addSingleTag', $site->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="form-label">Name</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="code" class="form-label">Code</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="code" name="code" required>
                            </div>
                            @error('code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="location" name="location" required>
                            </div>
                            @error('location')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-primary">Add Tag</button>
                            <button type="button" class="btn btn-lg btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <span class="sub-text">AskariTechnologies {{ date('Y') }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addMultipleTagModal" tabindex="-1" aria-labelledby="addMultipleTagModalExample"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Add Multiple Tags</h5>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="addMultipleTagsForm" action="{{ route('admin.addMultipleTags', $site->id) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="number" class="form-label">Number of Tags</label>
                            <div class="form-control-wrap">
                                <input type="number" class="form-control" id="number" name="number" required>
                            </div>
                            @error('number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-primary">Add Tags</button>
                            <button type="button" class="btn btn-lg btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <span class="sub-text">AskariTechnologies {{ date('Y') }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    function deleteTag(id) {
        if (confirm('Are you sure you want to delete this tag?')) {
            let url = "{{ route('admin.deleteTag', ':id') }}";
            url = url.replace(':id', id);

            axios.delete(url)
                .then(function(response) {
                    if (response.data.success) {
                        displaySuccess(response.data.message);
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        displayError(response.data.error);
                    }
                })
                .catch(function(error) {
                    displayError(error.response.data.error);
                });
        }
    }
</script>
