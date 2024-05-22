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
                                                    <p>There are a total of {{ count($tasks) }} tasks.</p>
                                                </div>
                                                <!-- .nk-block-head-content -->
                                                <div class="nk-block-head-content">
                                                    <div class="toggle-wrap nk-block-tools-toggle">
                                                        <a href="#"
                                                            class="btn btn-icon btn-trigger toggle-expand me-n1"
                                                            data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                                        <div class="toggle-expand-content" data-content="pageMenu">

                                                        </div><!-- .toggle-expand-content -->
                                                    </div><!-- .toggle-wrap -->
                                                </div><!-- .nk-block-head-content -->
                                            </div><!-- .nk-block-between -->
                                            <div class="nk-block-head-content">
                                                <ul>
                                                    <li>
                                                        <a href="javascript:void(0)" data-bs-toggle="modal"
                                                            data-bs-target="#addTaskModal"
                                                            class="btn btn-md btn-white btn-dim btn-outline-primary">
                                                            <em class="icon ni ni ni-plus"></em>
                                                            <span>Add Task</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div><!-- .nk-block-head -->
                                    <div class="nk-block">
                                        <div class="card card-bordered card-preview">
                                            <div class="card-inner">
                                                @if (count($tasks) > 0)
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
                                                                <th class="nk-tb-col"><span class="sub-text">Guard </span>
                                                                </th>
                                                                <th class="nk-tb-col tb-col-mb"><span
                                                                        class="sub-text">Title</span></th>
                                                                <th class="nk-tb-col tb-col-md"><span
                                                                        class="sub-text">Status</span></th>
                                                                <th class="nk-tb-col nk-tb-col-tools text-right">
                                                                    <div class="dropdown">
                                                                        <a href="#"
                                                                            class="btn btn-xs btn-trigger dropdown-toggle"
                                                                            data-toggle="dropdown"
                                                                            data-offset="0,5">Tools</a>
                                                                        <div
                                                                            class="dropdown-menu dropdown-menu-xs dropdown-menu-right">
                                                                            <ul class="link-check">
                                                                                <li><a href="#"
                                                                                        class="dropdown-item">Mark as
                                                                                        Done</a></li>
                                                                                <li><a href="#"
                                                                                        class="dropdown-item">Delete</a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </th>
                                                            </tr><!-- .nk-tb-item -->
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($tasks as $task)
                                                                <tr class="nk-tb-item">
                                                                    <td class="nk-tb-col nk-tb-col-check">
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
                                                                            <div class="user-avatar sm">
                                                                                <em class="icon ni ni">
                                                                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($task->owner->name) }}"
                                                                                        alt="">
                                                                                </em>
                                                                            </div>
                                                                            <div class="user-info">
                                                                                <span
                                                                                    class="tb-lead">{{ $task->owner->name }}</span>
                                                                                <span>{{ $task->owner->phone }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="nk-tb-col tb-col-mb">
                                                                        <span>{{ $task->title }}</span>
                                                                    </td>
                                                                    <td class="nk-tb-col tb-col-md">
                                                                        <span class="tb-sub">{{ $task->status }}</span>
                                                                    </td>
                                                                    <td class="nk-tb-col nk-tb-col-tools">
                                                                        <ul class="nk-tb-actions gx-1">

                                                                            <li>
                                                                                <div class="drodown">
                                                                                    <a href="#"
                                                                                        class="dropdown-toggle btn btn-icon btn-trigger"
                                                                                        data-bs-toggle="dropdown">
                                                                                        <em
                                                                                            class="icon ni ni-more-h"></em></a>
                                                                                    <div
                                                                                        class="dropdown-menu dropdown-menu-end">
                                                                                        <ul class="link-list-opt no-bdr">
                                                                                            <li>
                                                                                                <a href="javascript:void(0)"
                                                                                                    data-bs-toggle="modal"
                                                                                                    data-bs-target="#viewTaskModal"
                                                                                                    onclick="viewTask({{ $task }})"
                                                                                                    class="dropdown-item">View</a>
                                                                                            </li>
                                                                                            <li><a href="{{ route('admin.updateTask', $task->id) }}"
                                                                                                    class="dropdown-item">Edit</a>
                                                                                            </li>
                                                                                            <li>
                                                                                                <form
                                                                                                    action="{{ route('admin.deleteTask', $task->id) }}"
                                                                                                    method="POST">
                                                                                                    @csrf
                                                                                                    @method('DELETE')
                                                                                                    <button type="submit"
                                                                                                        class="dropdown-item">Delete</button>
                                                                                                </form>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                    </td>
                                                                </tr><!-- .nk-tb-item -->
                                                            @endforeach
                                                        </tbody>
                                                    </table><!-- .nk-tb-list -->
                                                @else
                                                    <div class="alert alert-icon alert-gray" role="alert">
                                                        <em class="icon ni ni">
                                                            {{-- <img src="https://ui-avatars.com/api/?name={{ urlencode($task->owner->name) }}"
                                                                alt=""> --}}
                                                        </em>
                                                        <p class="text-center">No active tasks</p>.
                                                    </div>
                                                @endif
                                            </div>
                                        </div><!-- .card-preview -->
                                    </div> <!-- nk-block -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalExample"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h5 class="modal-title">Add Task</h5>
                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form action="{{ route('admin.addTask') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="form-label" for="full-name-1">Select
                                    Guard</label>
                                <div class="form-control-wrap">
                                    <div class="form-group">
                                        <select class="custom-select form-select" data-search="on" name="guard_id">
                                            <option>Select Guard</option>
                                            @foreach ($siteguards as $siteguard)
                                                <option value="{{ $siteguard->id }}">
                                                    {{ $siteguard->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="form-label">Title</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="title">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="form-label">Description</label>
                                <div class="form-control-wrap">
                                    <textarea class="form-control" name="description"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="form-label">Comments</label>
                                <div class="form-control-wrap">
                                    <textarea class="form-control" name="comments"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="start" class="form-label">Start Time</label>
                                        <div class="form-control-wrap">
                                            <input type="time" class="form-control" name="from" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="end" class="form-label">End Time</label>
                                        <div class="form-control-wrap">
                                            <input type="time" class="form-control" name="to" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="site_id" value="{{ $site->id }}">
                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary btn-md float-end">Add Task</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="viewTaskModal" tabindex="-1" aria-labelledby="viewTaskModalExample"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Task Details</h5>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label" for="full-name-1">Guard</label>
                        <div class="form-control-wrap">
                            <span id="guard"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="form-label">Title</label>
                        <div class="form-control-wrap">
                            <span id="title"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="form-label">Description</label>
                        <div class="form-control-wrap">
                            <span id="description"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="form-label">Comments</label>
                        <div class="form-control-wrap">
                            <span id="comments"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group
                                ">
                                <label for="start" class="form-label">Start Time</label>
                                <div class="form-control-wrap">
                                    <span id="from"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="end" class="form-label">End Time</label>
                                <div class="form-control-wrap">
                                    <span id="to"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    function viewTask(task) {
        console.log(task);
        document.getElementById('guard').innerHTML = task.owner.name;
        document.getElementById('title').innerHTML = task.title;
        document.getElementById('description').innerHTML = task.description;
        document.getElementById('comments').innerHTML = task.comments;
        document.getElementById('from').innerHTML = task.from;
        document.getElementById('to').innerHTML = task.to;
    }
</script>
