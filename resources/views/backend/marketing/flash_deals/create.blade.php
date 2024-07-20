@extends('backend.layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-10 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{translate('Flash Deal Information')}}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('flash_deals.store') }}" method="POST" enctype="multipart/form-data" >
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-3 control-label" for="name">Caption</label>
                        <div class="col-sm-9">
                                  
                            <input type="text" placeholder="Caption" id="name" name="caption" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label" for="Location">Location <small></small></label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Location" id="background_color" name="location" class="form-control" required>
                        </div>
                    </div>
                    
                        <div class="form-group row">
                        <label class="col-sm-3 control-label" for="Audience">Audience <small></small></label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Audience" id="background_color" name="audience" class="form-control" required>
                        </div>
                    </div>
                    
                    
                    <div class="form-group row">
                        <label class="col-sm-3 control-label" for="Audience">Media <small></small></label>
                        <div class="col-sm-9">
                            <input type="file" placeholder="Media" id="background_color" name="media" class="form-control" required>
                        </div>
                    </div>
                  
                   
                

                  
                    <br>
                    
                

                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#products').on('change', function(){
                var product_ids = $('#products').val();
                if(product_ids.length > 0){
                    $.post('{{ route('flash_deals.product_discount') }}', {_token:'{{ csrf_token() }}', product_ids:product_ids}, function(data){
                        $('#discount_table').html(data);
                        AIZ.plugins.fooTable();
                    });
                }
                else{
                    $('#discount_table').html(null);
                }
            });
        });
    </script>
@endsection
