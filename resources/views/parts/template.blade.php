<template class="template-dropzone">

  <div class="file-row template image-row">

    <input type="hidden" name="image" class="image" value="" />
    <div class="col-image" >
      <div class="preview aspect-1-1">
        <img class="thumbnail " data-dz-thumbnail />
      </div>
    </div>

    <div class="col">
      <div class="row">
        <p class="name col" data-dz-name></p>
        <p class="size col" data-dz-size></p>
      </div>
      <div>
        <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100"
          aria-valuenow="0">
          <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
          <strong class="error text-danger" data-dz-errormessage></strong>
        </div>
      </div>
    </div>

    <div class="col-action">
      <div data-dz-remove class="btn btn-warning cancel">
        <i class="glyphicon glyphicon-ban-circle"></i>
        <span>Cancel</span>
      </div>
      <div data-dz-remove class="btn btn-danger delete">
        <i class="glyphicon glyphicon-trash"></i>
        <span>Delete</span>
      </div>
    </div>
  </div>

</template>