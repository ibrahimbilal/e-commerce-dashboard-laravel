<div class="col-sm-6 col-lg-12 float-start float-lg-none">
    <div class="main-box box-spaces form-item" id="parent-cat">
        <h2 class="box-title item-title">parent category</h2>
        <div class="form-item second mt-2">
            <label class="item-title" for="parent-id">parent:</label>
            <select class="form-select" id="parent-id" name="parent_id">
                <option value="">None / top level</option>
                @foreach ($parents as $parent)
                    <option value="{{ $parent->id }}" @selected((string) old('parent_id', optional($category ?? null)->parent_id) === (string) $parent->id)>
                        {{ $parent->title }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
