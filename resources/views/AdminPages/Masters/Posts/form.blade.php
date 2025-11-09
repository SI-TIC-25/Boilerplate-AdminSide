<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" enctype="multipart/form-data" method="post" class="form-horizontal">
            @csrf
            @method('post')

            <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating mb-4">
                        <select name="category_id" class="form-select" id="category_id" aria-label="Floating label select example">
                            <option value="">Select Category</option>
                            @foreach ($categories as $cat)
                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                            @endforeach
                        </select>
                        <label for="category_id">Category</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input name="title" type="text" class="form-control" id="title" placeholder="title">
                        <label for="title">title</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input name="desc" type="text" class="form-control" id="desc" placeholder="desc">
                        <label for="desc">desc</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" type="file" id="thumbnail" name="thumbnail">
                        <label for="thumbnail" class="form-label">thumbnail</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i>
                        Simpan</button>
                    <button type="button" class="btn btn-sm btn-flat btn-warning" data-bs-dismiss="modal"><i
                            class="fa fa-arrow-circle-left"></i> Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>