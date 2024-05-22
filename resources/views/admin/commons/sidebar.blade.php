<div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg toggle-screen-lg"
    data-toggle-body="true" data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
    <div class="card-inner-group" data-simplebar="init">
        <div class="simplebar-wrapper" style="margin: 0px;">
            <div class="simplebar-height-auto-observer-wrapper">
                <div class="simplebar-height-auto-observer"></div>
            </div>
            <div class="simplebar-mask">
                <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                    <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content"
                        style="height: auto; overflow: hidden;">
                        <div class="simplebar-content" style="padding: 0px;">
                            <div class="card-inner">
                                @if ($site->owner)
                                    <div class="user-account-info py-0">
                                        <h6 class="overline-title-alt">Site Owner</h6>
                                        <div class="user-card">
                                            <div class="user-avatar bg-primary">
                                                {{-- <a href="{{ route('org.team.show', $site->owner->id) }}"> --}}
                                                <a href="#">
                                                    {{-- <img src="{{ Gravatar::get($site->owner->email) }}" alt="User"> --}}
                                                </a>
                                            </div>
                                            <div class="user-info">
                                                {{-- <a href="{{ route('org.team.show', $site->owner->id) }}"><span --}}
                                                <a href="#"><span
                                                        class="lead-text">{{ $site->owner->name }}</span></a>
                                                <span class="sub-text">{{ $site->owner->email }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-icon alert-gray" role="alert">
                                        <em class="icon ni ni-alert-circle"></em>
                                        <strong>No active client</strong>.
                                    </div>
                                @endif
                                {{-- @if (request()->routeIs('org.site-overview') && $site->owner == null)
                                    <a href="{{ route('org.site-update', $site->id) }}"
                                        class="w-100 btn btn-gray">Update Client</a>
                                @endif --}}
                            </div>
                            <div class="card-inner p-0">
                                <ul class="link-list-menu">
                                    <li>
                                        <a class="{{ request()->routeIs('admin.site-overview') ? 'active' : '' }}"
                                            href="{{ route('admin.site-overview', $site->id) }}"><em
                                                class="icon ni ni-dashboard-fill"></em><span> Overview</span></a>
                                    </li>
                                    <li>
                                        <a class="{{ request()->routeIs('admin.site-activity') ? 'active' : '' }}"
                                            href="{{ route('admin.site-activity', $site->id) }}"><em
                                                class="icon ni ni-activity-round-fill"></em><span>
                                                Activity</span></a>
                                    </li>
                                    <li>
                                        <a class="{{ request()->routeIs('admin.site-guards') ? 'active' : '' }}"
                                            href="{{ route('admin.site-guards', $site->id) }}"><em
                                                class="icon ni ni-user-list-fill"></em><span> Guards</span></a>
                                    </li>
                                    <li>
                                        <a class="{{ request()->routeIs('admin.site-tags') ? 'active' : '' }}"
                                            href="{{ route('admin.site-tags', $site->id) }}"><em
                                                class="icon ni ni-tag-fill"></em><span> Tags</span></a>
                                    </li>
                                    <li>
                                        <a class="{{ request()->routeIs('admin.site-patrols') ? 'active' : '' }}"
                                            href="{{ route('admin.site-patrols', $site->id) }}"><em
                                                class="icon ni ni-clock-fill"></em><span>Patrols</span></a>
                                    </li>
                                    <li>
                                        <a class="{{ request()->routeIs('admin.site-incidents') ? 'active' : '' }}"
                                            href="{{ route('admin.site-incidents', $site->id) }}"><em
                                                class="icon ni ni-alert-fill"></em><span> Incidents</span></a>
                                    </li>
                                    <li>
                                        <a class="{{ request()->routeIs('admin.site-tasks') ? 'active' : '' }}"
                                            href="{{ route('admin.site-tasks', $site->id) }}"><em
                                                class="icon ni ni-folder-fill"></em><span> Tasks</span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>site-tasks
                    </div>
                </div>
            </div>
            <div class="simplebar-placeholder" style="width: auto; height: 504px;"></div>
        </div>
        <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
            <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
        </div>
        <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
            <div class="simplebar-scrollbar" style="height: 0px; display: none;"></div>
        </div>
    </div>
</div>
