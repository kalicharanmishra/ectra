@section('content')
  <style>
    .myul_style { list-style:none; margin:0px; padding:0;}
    .myul_style li:nth-child(even) {font-weight: 600;}

  </style>
  <div class="content-wrapper">
    <div class="content-header">
      @extends('admin.master')
    </div>
    <section class="content">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Vemdor Details ({{$dataview->username}})</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button> -->
            </div>
          </div>

            <div class="card-body">
              <div class="table-responsive">
                <div>
                  <ul class="myul_style">
                    <li> Name :</li>
                    <li> {{$dataview->username}}</li>
                    <li> Bank Name :</li>
                    <li> {{$UserBank->bank_name}}</li>
                    <li> Account Holder :</li>
                    <li> {{$UserBank->bank_account_holder}}</li>
                    <li> Account No :</li>
                    <li> {{$UserBank->bank_account}}</li>
                    <li> Ifsc :</li>
                    <li> {{$UserBank->bank_ifsc}}</li>
                    <li> Address :</li>
                    <li> {{$UserBank->bank_address}}</li>
                  </ul>
                </div>
              </div>
            </div>
        </div>
    </section>
</div>
  @endsection
