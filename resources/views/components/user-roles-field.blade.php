@php
    $selectedRoleNames = old('roles', isset($user) ? $user->getRoleNames()->all() : []);
@endphp
<div class="form-item second d-flex flex-wrap flex-sm-nowrap mt-3">
<label class="item-title">roles:</label>
<div class="d-flex flex-wrap gap-3 align-items-center">
@forelse ($roles as $role)
<label class="radio-label mb-0 d-flex align-items-center gap-1">
<input class="input-radio" name="roles[]" type="checkbox" value="{{ $role->name }}" @checked(in_array($role->name, $selectedRoleNames, true))/>
<span class="text-capitalize">{{ $role->name }}</span>
</label>
@empty
<span class="text-muted">No roles defined.</span>
@endforelse
</div>
</div>
