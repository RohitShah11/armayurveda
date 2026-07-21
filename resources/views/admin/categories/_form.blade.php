@csrf
@if($category->exists) @method('PUT') @endif
<div class="row g-3">
  <div class="col-md-4"><label class="form-label">Parent Category</label><select class="form-select" name="parent_id"><option value="">No Parent (Top Level)</option>@foreach($parents as $parent)<option value="{{ $parent->id }}" @selected(old('parent_id', $category->parent_id)==$parent->id)>{{ $parent->name }}</option>@endforeach</select></div>
  <div class="col-md-4"><label class="form-label">Name <span class="text-danger">*</span></label><input required class="form-control" id="name" name="name" value="{{ old('name', $category->name) }}"></div>
  <div class="col-md-4"><label class="form-label">Slug <span class="text-danger">*</span></label><input required class="form-control" id="slug" name="slug" value="{{ old('slug', $category->slug) }}"></div>
  <div class="col-md-4"><label class="form-label">Image</label><input type="file" accept="image/*" class="form-control" name="image">@if($category->image)<small class="text-muted">Leave blank to keep the current image.</small>@endif</div>
  <div class="col-md-4"><label class="form-label">Meta Title</label><input class="form-control" name="meta_title" value="{{ old('meta_title', $category->meta_title) }}"></div>
  <div class="col-md-4"><label class="form-label">Status</label><select class="form-select" name="is_active"><option value="1" @selected(old('is_active', $category->is_active ?? true)==1)>Active</option><option value="0" @selected(old('is_active', $category->is_active ?? true)==0)>Inactive</option></select></div>
  <div class="col-12"><label class="form-label">Meta Description</label><textarea class="form-control" rows="3" name="meta_description">{{ old('meta_description', $category->meta_description) }}</textarea></div>
  <div class="col-12"><label class="form-label">Details</label><textarea class="form-control" rows="8" name="details">{{ old('details', $category->details) }}</textarea></div>
</div>
<button class="btn btn-main mt-4"><i class="fa fa-floppy-disk me-1"></i> {{ $category->exists ? 'Update Category' : 'Save Category' }}</button>
@push('scripts')<script>const n=document.getElementById('name'),s=document.getElementById('slug');let touched=s.value!=='';s.addEventListener('input',()=>touched=true);n.addEventListener('input',()=>{if(!touched)s.value=n.value.toLowerCase().trim().replace(/[^a-z0-9]+/g,'-').replace(/^-|-$/g,'')});</script>@endpush
