@extends('layouts.master')
@section('custom_css')
@stop
@section('content')
<div class="container">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Seller</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Buyer</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
  		<div class="row">
			<div class="col-md-12">
		               <table class="datatable mdl-data-table dataTable" cellspacing="0"
    width="100%" role="grid" style="width: 100%;">
						    <thead>
						        <tr>
						            <th>ID</th>
						            <th>First Name</th>
						            <th>Last Name</th>
						            <th>Email</th>
						            <th>Phone</th>
						        </tr>
						    </thead>
						    <tbody>
						    </tbody>
						</table>
		        </div>
		</div>
  </div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
</div>
</div>
@section('scripts')
<!-- <script>
    $(document).ready(function() {
        $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("serverSide") }}',
            columnDefs: [{
                targets: [0, 1, 2],
                className: 'mdl-data-table__cell--non-numeric'
            }]
        });
    });
</script> -->

<script>
    $(document).ready(function () {
        $('.datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "{{ url('serverSide') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [
                { "data": "id" },
                { "data": "title" },
                { "data": "body" },
                { "data": "created_at" },
                { "data": "options" }
            ]	 

        });
    });
</script>
@endsection
@endsection





