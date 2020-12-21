<tr id="center-{{ $center->id }}">
    <form action="#" id="collectionForm-{{ $center->id }}">
    @csrf
        <input type="hidden" name="id" value="{{ $center->id }}" form="collectionForm-{{ $center->id }}">
        <td>{{ $center->id }}</td>
        <td><input type="text" value="{{ $center->name }}" id="name" class="form-control" name="name" form="collectionForm-{{ $center->id }}"></td>
        <td><input type="text" value="{{ $center->addresss }}" id="address" class="form-control" name="address" form="collectionForm-{{ $center->id }}"></td>
        <td><input type="number" value="{{ $center->fat_rate }}" id="fat-rate" step="0.001" class="form-control" name="fat_rate" form="collectionForm-{{ $center->id }}"></td>
        <td><input type="number" value="{{ $center->snf_rate }}" id="snf-rate" step="0.001" class="form-control" name="snf_rate" form="collectionForm-{{ $center->id }}"></td>
        <td><span onclick="editCollection({{$center->id}});" form="collectionForm-{{ $center->id }}" class="btn btn-primary btn-sm"> Update </span> | <span class="btn btn-danger btn-sm" onclick="removeCenter({{$center->id}});">Delete</span></td>
    </form>
</tr>
